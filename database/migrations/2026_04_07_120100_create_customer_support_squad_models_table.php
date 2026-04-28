<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_support_squad_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_support_squad_id')->constrained()->onDelete('cascade');
            $table->foreignId('chatbot_model_id')->constrained()->onDelete('cascade');
            $table->string('task_role');
            $table->text('system_prompt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(
                ['customer_support_squad_id', 'chatbot_model_id', 'task_role'],
                'uniq_support_squad_model_role'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_support_squad_models');
    }
};
