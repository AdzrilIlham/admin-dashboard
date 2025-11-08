<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Untuk data yang sudah ada, set user_id ke user pertama
        if (Schema::hasTable('skills')) {
            $firstUserId = DB::table('users')->value('id');
            if ($firstUserId) {
                DB::table('skills')->whereNull('user_id')->update(['user_id' => $firstUserId]);
            }
        }

        // Ubah constraint untuk allow cascade delete
        Schema::table('skills', function (Blueprint $table) {
            // Hapus foreign key constraint lama jika ada
            $table->dropForeign(['user_id']);
            
            // Tambahkan foreign key constraint baru dengan cascade
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};