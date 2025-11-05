<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $user = User::create([
            'name' => 'Admin Portfolio',
            'email' => 'admin@portfolio.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'avatar' => null,
        ]);

        echo "✓ User created: admin@portfolio.com (password: password)\n";

        // ============================================
        // CREATE SKILLS
        // ============================================
        $skills = [
            // Expert Level
            ['name' => 'Laravel', 'level' => 95, 'proficiency' => 'expert'],
            ['name' => 'PHP', 'level' => 90, 'proficiency' => 'expert'],
            ['name' => 'JavaScript', 'level' => 88, 'proficiency' => 'expert'],
            
            // Advanced Level
            ['name' => 'Vue.js', 'level' => 85, 'proficiency' => 'advanced'],
            ['name' => 'Tailwind CSS', 'level' => 82, 'proficiency' => 'advanced'],
            ['name' => 'MySQL', 'level' => 80, 'proficiency' => 'advanced'],
            ['name' => 'Git', 'level' => 78, 'proficiency' => 'advanced'],
            
            // Intermediate Level
            ['name' => 'React', 'level' => 70, 'proficiency' => 'intermediate'],
            ['name' => 'Node.js', 'level' => 68, 'proficiency' => 'intermediate'],
            ['name' => 'Docker', 'level' => 65, 'proficiency' => 'intermediate'],
            
            // Beginner Level
            ['name' => 'AWS', 'level' => 45, 'proficiency' => 'beginner'],
            ['name' => 'Python', 'level' => 40, 'proficiency' => 'beginner'],
        ];

        $createdSkills = [];
        foreach ($skills as $skillData) {
            $skill = $user->skills()->create($skillData);
            $createdSkills[] = $skill;
        }

        echo "✓ Created " . count($skills) . " skills\n";

        // ============================================
        // CREATE PROJECTS
        // ============================================
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'description' => 'Full-featured e-commerce platform dengan payment gateway integration, inventory management, dan admin dashboard.',
                'status' => 'completed',
                'link' => 'https://github.com/yourusername/ecommerce',
                'skills' => ['Laravel', 'Vue.js', 'Tailwind CSS', 'MySQL']
            ],
            [
                'title' => 'Portfolio Website',
                'description' => 'Modern portfolio website dengan admin panel untuk manage projects, skills, dan blog posts.',
                'status' => 'completed',
                'link' => 'https://github.com/yourusername/portfolio',
                'skills' => ['Laravel', 'JavaScript', 'Tailwind CSS']
            ],
            [
                'title' => 'Task Management App',
                'description' => 'Collaborative task management application dengan real-time updates dan team collaboration features.',
                'status' => 'ongoing',
                'link' => null,
                'skills' => ['Laravel', 'Vue.js', 'MySQL', 'Git']
            ],
            [
                'title' => 'Blog CMS',
                'description' => 'Content Management System untuk blog dengan SEO optimization, media library, dan user management.',
                'status' => 'completed',
                'link' => 'https://github.com/yourusername/blog-cms',
                'skills' => ['Laravel', 'PHP', 'Tailwind CSS', 'MySQL']
            ],
            [
                'title' => 'API Gateway Service',
                'description' => 'RESTful API gateway dengan authentication, rate limiting, dan comprehensive documentation.',
                'status' => 'ongoing',
                'link' => null,
                'skills' => ['Laravel', 'PHP', 'MySQL', 'Docker']
            ],
            [
                'title' => 'Real-time Chat Application',
                'description' => 'Real-time chat application menggunakan WebSockets dengan group chat dan file sharing.',
                'status' => 'paused',
                'link' => null,
                'skills' => ['Laravel', 'Vue.js', 'Node.js']
            ],
            [
                'title' => 'Inventory Management System',
                'description' => 'Comprehensive inventory management system untuk warehouse dan retail business.',
                'status' => 'completed',
                'link' => 'https://github.com/yourusername/inventory',
                'skills' => ['Laravel', 'JavaScript', 'MySQL', 'Tailwind CSS']
            ],
            [
                'title' => 'Social Media Dashboard',
                'description' => 'Analytics dashboard untuk social media management dengan scheduling dan reporting features.',
                'status' => 'ongoing',
                'link' => null,
                'skills' => ['Laravel', 'React', 'MySQL']
            ],
        ];

        foreach ($projects as $projectData) {
            // Ambil skills yang akan di-attach
            $skillNames = $projectData['skills'];
            unset($projectData['skills']);

            // Create project
            $project = $user->projects()->create($projectData);

            // Attach skills
            $skillsToAttach = collect($createdSkills)
                ->whereIn('name', $skillNames)
                ->pluck('id')
                ->toArray();

            $project->skills()->attach($skillsToAttach);
        }

        echo "✓ Created " . count($projects) . " projects\n";

        // ============================================
        // CREATE DUMMY VISITORS (untuk testing dashboard)
        // ============================================
        
        // Visitors dari 30 hari terakhir
        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $visitorCount = rand(5, 20); // Random 5-20 visitors per day

            for ($j = 0; $j < $visitorCount; $j++) {
                Visitor::create([
                    'user_id' => $user->id,
                    'ip_address' => $this->randomIp(),
                    'user_agent' => $this->randomUserAgent(),
                    'device' => $this->randomDevice(),
                    'browser' => $this->randomBrowser(),
                    'os' => $this->randomOS(),
                    'page_visited' => $this->randomPage(),
                    'created_at' => $date->copy()->addHours(rand(0, 23))->addMinutes(rand(0, 59)),
                ]);
            }
        }

        echo "✓ Created visitor data for testing\n";
        echo "\n";
        echo "========================================\n";
        echo "✓ Seeding completed successfully!\n";
        echo "========================================\n";
        echo "Login credentials:\n";
        echo "Email: admin@portfolio.com\n";
        echo "Password: password\n";
        echo "========================================\n";
    }

    // Helper methods untuk random data
    private function randomIp()
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255);
    }

    private function randomUserAgent()
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
        ];
        return $agents[array_rand($agents)];
    }

    private function randomDevice()
    {
        $devices = ['Desktop', 'Mobile', 'Tablet'];
        return $devices[array_rand($devices)];
    }

    private function randomBrowser()
    {
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera'];
        return $browsers[array_rand($browsers)];
    }

    private function randomOS()
    {
        $os = ['Windows', 'macOS', 'Linux', 'Android', 'iOS'];
        return $os[array_rand($os)];
    }

    private function randomPage()
    {
        $pages = ['', 'about', 'portfolio', 'projects', 'skills', 'contact'];
        return $pages[array_rand($pages)];
    }
}