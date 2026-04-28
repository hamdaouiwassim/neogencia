<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SQLite enforces ENUM as CHECK(user IN (...)); widen to string so "admin" is allowed in tests and portable DBs.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 32)->default('user')->change();
        });
    }

    public function down(): void
    {
        if (! in_array(Schema::getConnection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'creator', 'admin'])->default('user')->change();
        });
    }
};
