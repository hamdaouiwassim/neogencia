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
        Schema::create('chatbot_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Display name (e.g. "Mistral 7B")
            $table->string('api_name');       // API model identifier (e.g. "mistralai/Mistral-7B-Instruct-v0.2")
            $table->boolean('is_default')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_models');
    }
};
