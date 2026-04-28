# Langflow, LangChain, LangSmith (hosted agents)

## Docker Compose

From the project root:

```bash
docker compose up -d langflow-db langflow agent-runtime
```

- **Langflow UI**: `http://localhost:7860` (port from `LANGFLOW_PORT`, default 7860)
- **Agent runtime API**: `http://localhost:8088` (from `AGENT_RUNTIME_PORT`, default 8088)

## Laravel `.env`

```env
AGENT_RUNTIME_URL=http://localhost:8088
AGENT_RUNTIME_SECRET=dev-secret-change-me

# Public link shown to creators (open Langflow in browser)
LANGFLOW_PUBLIC_URL=http://localhost:7860

# Optional LangSmith (set on agent-runtime container / same values if running runtime locally)
LANGCHAIN_TRACING_V2=true
LANGCHAIN_API_KEY=lsv2_...
LANGCHAIN_PROJECT=neogencia-agents
```

Use the **same** `AGENT_RUNTIME_SECRET` in Laravel and in the `agent-runtime` container (`AGENT_RUNTIME_SECRET`).

## Flow

1. Creator sets agent **execution mode** to **Hosted**, saves **Langflow flow ID**, submits for admin approval.
2. Laravel `POST /agents/{agent}/invoke` forwards to agent-runtime with `X-Agent-Runtime-Secret`.
3. Runtime tries Langflow HTTP run, then falls back to a small LangChain graph; LangSmith records traces when env vars are set.

## Local PHP without Docker

Run the Python service locally:

```bash
cd services/agent-runtime
pip install -r requirements.txt
export AGENT_RUNTIME_SECRET=dev-secret-change-me
uvicorn app.main:app --reload --port 8088
```

Point `AGENT_RUNTIME_URL` at `http://127.0.0.1:8088`.