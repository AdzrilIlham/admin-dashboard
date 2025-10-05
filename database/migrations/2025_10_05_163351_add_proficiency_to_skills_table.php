<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            // Add proficiency column if it doesn't exist
            if (!Schema::hasColumn('skills', 'proficiency')) {
                $table->enum('proficiency', ['Beginner', 'Intermediate', 'Advanced', 'Expert'])
                      ->default('Intermediate')
                      ->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            if (Schema::hasColumn('skills', 'proficiency')) {
                $table->dropColumn('proficiency');
            }
        });
    }
};