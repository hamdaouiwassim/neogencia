<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerSupportSquad extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function squadModels()
    {
        return $this->hasMany(CustomerSupportSquadModel::class)->orderBy('sort_order');
    }

    public function models()
    {
        return $this->belongsToMany(
            ChatbotModel::class,
            'customer_support_squad_models',
            'customer_support_squad_id',
            'chatbot_model_id'
        )->withPivot('task_role', 'system_prompt', 'sort_order')
            ->orderBy('customer_support_squad_models.sort_order');
    }

    public static function getTaskRoles(): array
    {
        return [
            'intent_detection' => 'Intent Detection',
            'sentiment_analysis' => 'Sentiment Analysis',
            'response_drafting' => 'Response Drafting',
            'escalation_risk' => 'Escalation Risk',
            'policy_compliance' => 'Policy Compliance',
            'qa_reviewer' => 'Final QA Reviewer',
        ];
    }
}
