<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotModel extends Model
{
    protected $table = 'chatbot_models';

    protected $fillable = [
        'name',
        'api_name',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the default model for the chatbot.
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first()
            ?? static::orderBy('sort_order')->orderBy('id')->first();
    }

    /**
     * Scope to order by sort_order then id.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
