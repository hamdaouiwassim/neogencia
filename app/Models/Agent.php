<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'featured_image',
        'description',
        'link',
        'documentation',
        'price',
        'pricing_type',
        'views',
        'is_featured',
        'is_approved',
        'execution_mode',
        'langflow_flow_id',
        'langflow_revision',
        'langsmith_project',
        'published_to_marketplace_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'views' => 'integer',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'published_to_marketplace_at' => 'datetime',
        ];
    }

    public function isHosted(): bool
    {
        return $this->execution_mode === 'hosted';
    }

    public function invocations()
    {
        return $this->hasMany(AgentInvocation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
