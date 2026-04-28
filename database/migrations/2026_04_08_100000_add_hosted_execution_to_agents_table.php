<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->string('execution_mode', 20)->default('external')->after('is_approved');
            $table->string('langflow_flow_id')->nullable()->after('execution_mode');
            $table->string('langflow_revision')->nullable()->after('langflow_flow_id');
            $table->string('langsmith_project')->nullable()->after('langflow_revision');
            $table->timestamp('published_to_marketplace_at')->nullable()->after('langsmith_project');
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'execution_mode',
                'langflow_flow_id',
                'langflow_revision',
                'langsmith_project',
                'published_to_marketplace_at',
            ]);
        });
    }
};
