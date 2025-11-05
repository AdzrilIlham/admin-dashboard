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
        $user = auth()->user();
        
        // ============================================
        // PROJECTS STATISTICS
        // ============================================
        $totalProjects = $user->projects()->count();
        $completedProjects = $user->projects()->where('status', 'completed')->count();
        $ongoingProjects = $user->projects()->where('status', 'ongoing')->count();
        $pausedProjects = $user->projects()->where('status', 'paused')->count();
        
        // Completion Rate
        $completionRate = $totalProjects > 0 
            ? round(($completedProjects / $totalProjects) * 100) 
            : 0;
        
        // Projects Growth (dibanding bulan lalu)
        $lastMonthProjects = $user->projects()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $projectsGrowth = $lastMonthProjects > 0
            ? round((($totalProjects - $lastMonthProjects) / $lastMonthProjects) * 100)
            : 0;
        
        // Recent Projects (5 terbaru dengan skills)
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
            ? round((($totalSkills - $lastMonthSkills) / $lastMonthSkills) * 100)
            : 0;
        
        // Top Skills (berdasarkan level)
        $topSkills = $user->skills()
            ->orderBy('level', 'desc')
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
        
        // Total Profile Views
        $profileViews = $user->visitors()->count();
        
        // Today's Views
        $todayViews = $user->visitors()
            ->whereDate('created_at', today())
            ->count();
        
        // Views Growth (optional)
        $lastMonthViews = $user->visitors()
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        // Return view dengan semua data
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