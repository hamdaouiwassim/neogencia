<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentInvocation extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'status',
        'langsmith_run_id',
        'trace_url',
        'latency_ms',
        'runtime_source',
        'output',
        'error',
    ];

    protected function casts(): array
    {
        return [
            'latency_ms' => 'integer',
        ];
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
