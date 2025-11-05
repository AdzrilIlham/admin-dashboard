<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table untuk Many-to-Many: Projects <-> Skills
     */
    public function up(): void
    {
        Schema::create('project_skill', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->cascadeOnDelete();
                  
            $table->foreignId('skill_id')
                  ->constrained('skills')
                  ->cascadeOnDelete();
            
            $table->timestamps();
            
            // Prevent duplicate entries
            $table->unique(['project_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_skill');
    }
};