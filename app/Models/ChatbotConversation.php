<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotConversation extends Model
{
    protected $fillable = [
        'user_id',
        'model_id',
        'title',
        'system_prompt',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->belongsTo(ChatbotModel::class, 'model_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatbotMessage::class, 'conversation_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatbotMessage::class, 'conversation_id')->latestOfMany();
    }
}
