<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke users - PERBAIKAN
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            $table->string('name');
            $table->integer('level')->default(0);
            $table->string('icon')->nullable();
            $table->enum('proficiency', ['beginner', 'intermediate', 'advanced', 'expert'])->default('beginner');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};