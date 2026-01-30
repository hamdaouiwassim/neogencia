<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSquad extends Model
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
        return $this->hasMany(SeoSquadModel::class)->orderBy('sort_order');
    }

    public function models()
    {
        return $this->belongsToMany(ChatbotModel::class, 'seo_squad_models', 'seo_squad_id', 'chatbot_model_id')
            ->withPivot('task_role', 'system_prompt', 'sort_order')
            ->orderBy('seo_squad_models.sort_order');
    }

    /**
     * Get available task roles for SEO squads
     */
    public static function getTaskRoles(): array
    {
        return [
            'keyword_research' => 'Keyword Research',
            'content_optimization' => 'Content Optimization',
            'meta_tags' => 'Meta Tags & Descriptions',
            'competitor_analysis' => 'Competitor Analysis',
            'technical_seo' => 'Technical SEO',
            'link_building' => 'Link Building Strategy',
            'content_audit' => 'Content Audit',
            'performance_analysis' => 'Performance Analysis',
        ];
    }
}
