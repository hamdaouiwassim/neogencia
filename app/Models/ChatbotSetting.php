<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotSetting extends Model
{
    protected $fillable = [
        'base_url',
        'api_key',
        'temperature',
        'max_tokens',
    ];

    protected $casts = [
        'temperature' => 'float',
        'max_tokens' => 'integer',
    ];

    /**
     * Get the singleton settings instance (first row, or create from config defaults).
     */
    public static function get(): self
    {
        $settings = static::first();
        if ($settings) {
            return $settings;
        }
        return static::create([
            'base_url' => config('services.chatbot.base_url', 'https://api.ai.cc/v1'),
            'api_key' => config('services.chatbot.api_key', ''),
            'temperature' => (float) config('services.chatbot.temperature', 0.7),
            'max_tokens' => (int) config('services.chatbot.max_tokens', 256),
        ]);
    }
}
