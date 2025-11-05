<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        // Ambil user login (fallback null-safe)
        $user = auth()->user();

        // Jika belum login, arahkan ke halaman utama
        if (!$user) {
            return redirect()->route('home');
        }

        // ============================================
        // PROJECTS STATISTICS
        // ============================================
        $totalProjects = $user->projects()->count();
        $completedProjects = $user->projects()->where('status', 'completed')->count();
        $ongoingProjects = $user->projects()->where('status', 'ongoing')->count();
        $pausedProjects = $user->projects()->where('status', 'paused')->count();

        // Completion Rate
        $completionRate = $totalProjects > 0
            ? round(($completedProjects / $totalProjects) * 100, 1)
            : 0;

        // Projects Growth (dibanding bulan lalu)
        $lastMonthProjects = $user->projects()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $projectsGrowth = $lastMonthProjects > 0
            ? round((($totalProjects - $lastMonthProjects) / $lastMonthProjects) * 100, 1)
            : 100;

        // Recent Projects (5 terbaru dengan relasi skills)
        $recentProjects = $user->projects()
            ->with('skills')
            ->latest()
            ->take(5)
            ->get();

        // ============================================
        // SKILLS STATISTICS
        // ============================================
        $totalSkills = $user->skills()->count();

        // Skills Growth (dibanding bulan lalu)
        $lastMonthSkills = $user->skills()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $skillsGrowth = $lastMonthSkills > 0
            ? round((($totalSkills - $lastMonthSkills) / $lastMonthSkills) * 100, 1)
            : 100;

        // Top Skills (berdasarkan level)
        $topSkills = $user->skills()
            ->orderByDesc('level')
            ->take(5)
            ->get();

        // Skills Distribution by Proficiency
        $skillDistribution = [
            'beginner' => $user->skills()->where('proficiency', 'beginner')->count(),
            'intermediate' => $user->skills()->where('proficiency', 'intermediate')->count(),
            'advanced' => $user->skills()->where('proficiency', 'advanced')->count(),
            'expert' => $user->skills()->where('proficiency', 'expert')->count(),
        ];

        // ============================================
        // VISITORS STATISTICS (Profile Views)
        // ============================================
        $profileViews = $user->visitors()->count();

        $todayViews = $user->visitors()
            ->whereDate('created_at', today())
            ->count();

        $lastMonthViews = $user->visitors()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        // ============================================
        // RETURN VIEW
        // ============================================
        return view('dashboard', compact(
            // Projects
            'totalProjects',
            'completedProjects',
            'ongoingProjects',
            'pausedProjects',
            'completionRate',
            'projectsGrowth',
            'recentProjects',

            // Skills
            'totalSkills',
            'skillsGrowth',
            'topSkills',
            'skillDistribution',

            // Visitors
            'profileViews',
            'todayViews'
        ));
    }
}
