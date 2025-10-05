<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Tambah kolom untuk icon/thumbnail
            $table->string('icon')->nullable()->after('name');
            $table->string('thumbnail')->nullable()->after('icon');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['icon', 'thumbnail']);
        });
    }
};