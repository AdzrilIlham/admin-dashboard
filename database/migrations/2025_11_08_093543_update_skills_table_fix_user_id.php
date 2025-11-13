<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan tabel skills & users ada
        if (!Schema::hasTable('skills') || !Schema::hasTable('users')) {
            return;
        }

        // Isi user_id kosong dengan user pertama
        $firstUserId = DB::table('users')->value('id');
        if ($firstUserId) {
            DB::table('skills')->whereNull('user_id')->update(['user_id' => $firstUserId]);
        }

        // Cek apakah foreign key benar-benar ada
        $fkExists = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'skills' 
            AND CONSTRAINT_NAME = 'skills_user_id_foreign'
        ");

        // Drop FK hanya jika benar-benar ada
        if (!empty($fkExists)) {
            DB::statement('ALTER TABLE skills DROP FOREIGN KEY skills_user_id_foreign');
        }

        // Tambahkan ulang FK dengan cascade
        Schema::table('skills', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Cek dulu sebelum drop FK
        $fkExists = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'skills' 
            AND CONSTRAINT_NAME = 'skills_user_id_foreign'
        ");

        if (!empty($fkExists)) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });
        }
    }
};
