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
        // Ganti after('name') jadi after('title') atau hapus saja
        $table->string('icon')->nullable()->after('title');
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