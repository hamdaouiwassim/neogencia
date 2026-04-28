<?php

return [

    'url' => rtrim((string) env('AGENT_RUNTIME_URL', 'http://127.0.0.1:8088'), '/'),

    'secret' => (string) env('AGENT_RUNTIME_SECRET', ''),

    'langflow_public_url' => rtrim((string) env('LANGFLOW_PUBLIC_URL', 'http://localhost:7860'), '/'),

];
