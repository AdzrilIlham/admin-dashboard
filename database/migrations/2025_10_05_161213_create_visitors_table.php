<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('user_agent')->nullable();
            $table->string('device_type', 50)->nullable(); // mobile, desktop, tablet
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable(); // OS
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('page_visited', 255);
            $table->string('referrer', 255)->nullable();
            $table->integer('visit_count')->default(1);
            $table->timestamp('last_visit_at');
            $table->timestamps();
            
            // Index untuk performa
            $table->index('ip_address');
            $table->index('created_at');
        });

        Schema::create('daily_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->integer('total_visitors')->default(0);
            $table->integer('unique_visitors')->default(0);
            $table->integer('page_views')->default(0);
            $table->timestamps();
            
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
        Schema::dropIfExists('daily_stats');
    }
};