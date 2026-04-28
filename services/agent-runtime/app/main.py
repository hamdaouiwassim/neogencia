"""Agent runtime: LangChain invoke + optional LangSmith tracing + optional Langflow API."""

from __future__ import annotations

import os
import time
import uuid
from typing import Any

import httpx
from fastapi import FastAPI, Header, HTTPException
from langchain_core.runnables import RunnablePassthrough
from langchain_core.tracers.langchain import wait_for_all_tracers
from pydantic import BaseModel, Field
from pydantic_settings import BaseSettings


class Settings(BaseSettings):
    agent_runtime_secret: str = Field(default="dev-secret-change-me", alias="AGENT_RUNTIME_SECRET")
    langflow_base_url: str = Field(default="http://localhost:7860", alias="LANGFLOW_BASE_URL")
    langflow_api_key: str = Field(default="", alias="LANGFLOW_API_KEY")

    class Config:
        env_file = ".env"
        extra = "ignore"


settings = Settings()
app = FastAPI(title="Neogencia Agent Runtime", version="0.1.0")


class InvokeRequest(BaseModel):
    flow_id: str | None = None
    input: str = Field(..., min_length=1, max_length=32000)
    agent_id: int | None = None
    user_id: int | None = None
    langsmith_project: str | None = None


class InvokeResponse(BaseModel):
    success: bool
    output: str
    trace_url: str | None = None
    langsmith_run_id: str | None = None
    source: str
    error: str | None = None


def _require_secret(x_agent_runtime_secret: str | None) -> None:
    if not x_agent_runtime_secret or x_agent_runtime_secret != settings.agent_runtime_secret:
        raise HTTPException(status_code=401, detail="Invalid or missing X-Agent-Runtime-Secret")


def _build_lc_graph():
    """Minimal LangChain graph: echo with prefix (LangSmith attaches if env set)."""

    return RunnablePassthrough.assign(output=lambda x: f"[hosted] {x.get('input', '')}")


@app.get("/health")
def health():
    return {"status": "ok"}


@app.post("/invoke", response_model=InvokeResponse)
def invoke(
    body: InvokeRequest,
    x_agent_runtime_secret: str | None = Header(default=None, alias="X-Agent-Runtime-Secret"),
):
    _require_secret(x_agent_runtime_secret)

    run_id = str(uuid.uuid4())
    metadata: dict[str, str] = {}
    if body.agent_id is not None:
        metadata["agent_id"] = str(body.agent_id)
    if body.user_id is not None:
        metadata["user_id"] = str(body.user_id)
    if body.langsmith_project:
        metadata["langsmith_project"] = body.langsmith_project

    source = "langchain"
    output = ""
    trace_url: str | None = None
    error: str | None = None

    if body.flow_id and settings.langflow_base_url:
        try:
            output, trace_url = _try_langflow_run(body.flow_id, body.input)
            source = "langflow"
        except Exception as e:  # noqa: BLE001
            error = str(e)
            output = _run_langchain(body.input, metadata)
            source = "langchain"
    else:
        output = _run_langchain(body.input, metadata)

    wait_for_all_tracers()

    langsmith_run_id = run_id if os.environ.get("LANGCHAIN_TRACING_V2", "").lower() == "true" else None

    return InvokeResponse(
        success=True,
        output=output,
        trace_url=trace_url,
        langsmith_run_id=langsmith_run_id,
        source=source,
        error=error,
    )


def _run_langchain(user_input: str, metadata: dict[str, str]) -> str:
    graph = _build_lc_graph()
    cfg = {"metadata": metadata} if metadata else None
    result = graph.invoke({"input": user_input}, config=cfg)
    if isinstance(result, dict):
        return str(result.get("output", result))
    return str(result)


def _try_langflow_run(flow_id: str, user_input: str) -> tuple[str, str | None]:
    """Best-effort Langflow HTTP run across common API variants."""
    base = settings.langflow_base_url.rstrip("/")
    headers: dict[str, str] = {}
    if settings.langflow_api_key:
        headers["x-api-key"] = settings.langflow_api_key

    attempts: list[tuple[str, str, dict[str, Any]]] = [
        ("POST", f"{base}/api/v1/run/{flow_id}", {"input_value": user_input, "output_type": "chat", "input_type": "chat"}),
        ("POST", f"{base}/api/v1/flows/{flow_id}/run", {"input_value": user_input, "output_type": "chat", "input_type": "chat"}),
        ("POST", f"{base}/api/v1/run", {"flow_id": flow_id, "input_value": user_input, "output_type": "chat", "input_type": "chat"}),
    ]

    attempt_logs: list[str] = []
    with httpx.Client(timeout=120.0) as client:
        for method, url, payload in attempts:
            try:
                if method == "POST":
                    r = client.post(url, json=payload, headers=headers)
                else:
                    r = client.get(url, params=payload, headers=headers)

                # In some Langflow deployments, sending an API key while skip-auth is enabled returns 403.
                # Retry once without auth headers before failing this attempt.
                if r.status_code == 403 and headers:
                    if method == "POST":
                        r2 = client.post(url, json=payload, headers={})
                    else:
                        r2 = client.get(url, params=payload, headers={})
                    if r2.status_code not in (403, 404, 405):
                        r2.raise_for_status()
                        data = r2.json()
                        return _extract_langflow_output(data), None
                    r = r2

                if r.status_code in (404, 405):
                    attempt_logs.append(f"{method} {url} -> {r.status_code}")
                    continue

                r.raise_for_status()
                data = r.json()
                return _extract_langflow_output(data), None
            except Exception as e:  # noqa: BLE001
                attempt_logs.append(f"{method} {url} -> {e}")
                continue

    raise RuntimeError("Langflow run failed; attempts: " + " | ".join(attempt_logs))


def _extract_langflow_output(data: dict[str, Any]) -> str:
    # Langflow payloads vary by version; recursively extract the first meaningful text.
    text = _extract_text_value(data)
    if text:
        return text
    return str(data)


def _extract_text_value(value: Any) -> str | None:
    if value is None:
        return None

    if isinstance(value, str):
        candidate = value.strip()
        return candidate or None

    if isinstance(value, dict):
        preferred_keys = [
            "text",
            "message",
            "content",
            "output",
            "result",
            "response",
            "value",
        ]
        for key in preferred_keys:
            if key in value:
                hit = _extract_text_value(value[key])
                if hit:
                    return hit

        for key in ["outputs", "data", "results", "messages"]:
            if key in value:
                hit = _extract_text_value(value[key])
                if hit:
                    return hit

        for nested in value.values():
            hit = _extract_text_value(nested)
            if hit:
                return hit
        return None

    if isinstance(value, list):
        for item in value:
            hit = _extract_text_value(item)
            if hit:
                return hit
        return None

    return str(value)
