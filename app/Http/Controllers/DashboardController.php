<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalSkills = Skill::count();
        $totalProjects = Project::count();
        
        // Project status counts
        $completedProjects = Project::where('status', 'completed')->count();
        $ongoingProjects = Project::where('status', 'ongoing')->count();
        $pausedProjects = Project::where('status', 'paused')->count();
        
        // Growth calculations (comparing this month with last month)
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth()->month;
        $lastMonthYear = now()->subMonth()->year;
        
        $skillsThisMonth = Skill::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $skillsLastMonth = Skill::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
        $skillsGrowth = $skillsLastMonth > 0 
            ? round((($skillsThisMonth - $skillsLastMonth) / $skillsLastMonth) * 100, 1)
            : ($skillsThisMonth > 0 ? 100 : 0);
        
        $projectsThisMonth = Project::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $projectsLastMonth = Project::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
        $projectsGrowth = $projectsLastMonth > 0 
            ? round((($projectsThisMonth - $projectsLastMonth) / $projectsLastMonth) * 100, 1)
            : ($projectsThisMonth > 0 ? 100 : 0);
        
        // Completion rate
        $completionRate = $totalProjects > 0 
            ? round(($completedProjects / $totalProjects) * 100, 1)
            : 0;
        
        // Recent skills
        $recentSkills = Skill::latest()->take(5)->get();
        
        // Recent projects
        $recentProjects = Project::latest()->take(5)->get();
        
        // Skills by proficiency for chart (Pie Chart)
        // FIXED: Gunakan level (0-100) bukan proficiency
        $skillsByProficiency = [
            'Expert' => Skill::where('level', '>=', 80)->count(),
            'Advanced' => Skill::whereBetween('level', [60, 79])->count(),
            'Intermediate' => Skill::whereBetween('level', [40, 59])->count(),
            'Beginner' => Skill::where('level', '<', 40)->count()
        ];
        
        // Projects by status for chart (Donut Chart)
        try {
            $projectsByStatus = Project::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();
        } catch (\Exception $e) {
            $projectsByStatus = [
                'ongoing' => 0,
                'completed' => 0,
                'paused' => 0
            ];
        }
        
        // Monthly project growth (for line chart) - Last 6 months
        $monthlyProjects = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M');
            $count = Project::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyProjects[$month] = $count;
        }
        
        // Profile views (dummy data)
        $profileViews = 0;
        $todayViews = 0;
        
        // Top Skills - FIXED: Langsung gunakan level
        $topSkills = Skill::orderBy('level', 'desc')
            ->take(4)
            ->get();
        
        // Activity log - recent activities
        $activityLog = collect([]);
        
        foreach ($recentSkills as $skill) {
            $activityLog->push([
                'type' => 'skill',
                'title' => 'Added new skill: ' . $skill->name,
                'time' => $skill->created_at->diffForHumans(),
                'icon' => 'fa-code',
                'color' => 'primary'
            ]);
        }
        
        foreach ($recentProjects as $project) {
            $activityLog->push([
                'type' => 'project',
                'title' => 'New project: ' . $project->name,
                'time' => $project->created_at->diffForHumans(),
                'icon' => 'fa-folder',
                'color' => 'success'
            ]);
        }
        
        $activityLog = $activityLog->sortByDesc('time')->take(10);
        
        // FIXED: Skill Distribution berdasarkan level (0-100)
        $skillDistribution = [
            'expert' => Skill::where('level', '>=', 80)->count(),
            'advanced' => Skill::whereBetween('level', [60, 79])->count(),
            'intermediate' => Skill::whereBetween('level', [40, 59])->count(),
            'beginner' => Skill::where('level', '<', 40)->count(),
        ];
        
        return view('dashboard', compact(
            'totalSkills',
            'totalProjects',
            'completedProjects',
            'ongoingProjects',
            'pausedProjects',
            'skillsGrowth',
            'projectsGrowth',
            'completionRate',
            'recentSkills',
            'recentProjects',
            'skillsByProficiency',
            'projectsByStatus',
            'monthlyProjects',
            'profileViews',
            'todayViews',
            'topSkills',
            'activityLog',
            'skillDistribution'
        ));
    }
}