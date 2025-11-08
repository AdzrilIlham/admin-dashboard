<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Drop foreign key constraint sementara
        Schema::table('skills', function (Blueprint $table) {
            // Gunakan try-catch untuk handle jika foreign key tidak ada
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Foreign key mungkin tidak ada, lanjutkan saja
                Log::info('Foreign key user_id tidak ditemukan, melanjutkan...');
            }
        });

        // Step 2: Update data existing yang user_id-nya NULL
        $firstUserId = DB::table('users')->value('id');
        if ($firstUserId) {
            DB::table('skills')->whereNull('user_id')->update(['user_id' => $firstUserId]);
        } else {
            // Jika tidak ada user, buat user default
            $firstUserId = DB::table('users')->insertGetId([
                'name' => 'Default User',
                'email' => 'default@example.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('skills')->whereNull('user_id')->update(['user_id' => $firstUserId]);
        }

        // Step 3: Pastikan tidak ada data dengan user_id NULL
        DB::table('skills')->whereNull('user_id')->delete();

        // Step 4: Add foreign key constraint kembali
        Schema::table('skills', function (Blueprint $table) {
            // Ubah kolom menjadi tidak nullable
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Tambahkan foreign key constraint
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