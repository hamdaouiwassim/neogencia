<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSupportSquadModel extends Model
{
    protected $table = 'customer_support_squad_models';

    protected $fillable = [
        'customer_support_squad_id',
        'chatbot_model_id',
        'task_role',
        'system_prompt',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function squad()
    {
        return $this->belongsTo(CustomerSupportSquad::class, 'customer_support_squad_id');
    }

    public function chatbotModel()
    {
        return $this->belongsTo(ChatbotModel::class, 'chatbot_model_id');
    }
}
