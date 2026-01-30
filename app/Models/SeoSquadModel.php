<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSquadModel extends Model
{
    protected $table = 'seo_squad_models';

    protected $fillable = [
        'seo_squad_id',
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
        return $this->belongsTo(SeoSquad::class, 'seo_squad_id');
    }

    public function chatbotModel()
    {
        return $this->belongsTo(ChatbotModel::class, 'chatbot_model_id');
    }
}
