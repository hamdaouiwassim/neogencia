<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_squad_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_squad_id')->constrained()->onDelete('cascade');
            $table->foreignId('chatbot_model_id')->constrained()->onDelete('cascade');
            $table->string('task_role'); // e.g., 'keyword_research', 'content_optimization', 'meta_tags', 'competitor_analysis'
            $table->text('system_prompt')->nullable(); // Custom system prompt for this model's task
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            
            // Prevent duplicate model-task combinations in the same squad
            $table->unique(['seo_squad_id', 'chatbot_model_id', 'task_role'], 'unique_squad_model_task');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_squad_models');
    }
};
