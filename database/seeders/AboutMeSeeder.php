<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutMeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('about_me')->insert([
            'title' => 'Adzril Ilham Ramadhan',
            'subtitle' => 'Fullstack Developer & UI Designer',
            'description' => 'Saya seorang fullstack developer yang fokus pada Laravel dan React. Saya menyukai pembuatan sistem yang efisien dengan desain clean.',
            'profile_image' => 'https://yourdomain.com/storage/profile.jpg',
            'resume_file' => 'https://yourdomain.com/storage/resume.pdf',
            'github_url' => 'https://github.com/adzrilfikri',
            'linkedin_url' => 'https://linkedin.com/in/adzrilfikri',
            'email' => 'adzril@example.com',
            'phone' => '+62 812 3456 7890',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
