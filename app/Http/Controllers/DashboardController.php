<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // Ambil ID user yang login
        
        // Total counts - FILTER BY USER
        $totalSkills = Skill::where('user_id', $userId)->count();
        $totalProjects = Project::where('user_id', $userId)->count();
        
        // Project status counts - FILTER BY USER
        $completedProjects = Project::where('user_id', $userId)->where('status', 'completed')->count();
        $ongoingProjects = Project::where('user_id', $userId)->where('status', 'ongoing')->count();
        $pausedProjects = Project::where('user_id', $userId)->where('status', 'paused')->count();
        
        // Growth calculations
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $lastMonth = now()->subMonth()->month;
        $lastMonthYear = now()->subMonth()->year;
        
        $skillsThisMonth = Skill::where('user_id', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $skillsLastMonth = Skill::where('user_id', $userId)
            ->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
        $skillsGrowth = $skillsLastMonth > 0 
            ? round((($skillsThisMonth - $skillsLastMonth) / $skillsLastMonth) * 100, 1)
            : ($skillsThisMonth > 0 ? 100 : 0);
        
        $projectsThisMonth = Project::where('user_id', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $projectsLastMonth = Project::where('user_id', $userId)
            ->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
        $projectsGrowth = $projectsLastMonth > 0 
            ? round((($projectsThisMonth - $projectsLastMonth) / $projectsLastMonth) * 100, 1)
            : ($projectsThisMonth > 0 ? 100 : 0);
        
        // Completion rate
        $completionRate = $totalProjects > 0 
            ? round(($completedProjects / $totalProjects) * 100, 1)
            : 0;
        
        // Recent skills - FILTER BY USER
        $recentSkills = Skill::where('user_id', $userId)->latest()->take(5)->get();
        
        // Recent projects - FILTER BY USER
        $recentProjects = Project::where('user_id', $userId)->latest()->take(5)->get();
        
        // Skills by proficiency - FILTER BY USER
        $skillsByProficiency = [
            'Expert' => Skill::where('user_id', $userId)->where('level', '>=', 80)->count(),
            'Advanced' => Skill::where('user_id', $userId)->whereBetween('level', [60, 79])->count(),
            'Intermediate' => Skill::where('user_id', $userId)->whereBetween('level', [40, 59])->count(),
            'Beginner' => Skill::where('user_id', $userId)->where('level', '<', 40)->count()
        ];
        
        // Projects by status - FILTER BY USER
        try {
            $projectsByStatus = Project::where('user_id', $userId)
                ->select('status', DB::raw('count(*) as total'))
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
        
        // Monthly project growth - FILTER BY USER
        $monthlyProjects = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M');
            $count = Project::where('user_id', $userId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyProjects[$month] = $count;
        }
       
        // Profile views - TEMPORARY FIX: tidak filter by user dulu
        $profileViews = Visitor::sum('visit_count');
        $todayViews = Visitor::whereDate('created_at', today())->sum('visit_count');
        
        // Top Skills - FILTER BY USER
        $topSkills = Skill::where('user_id', $userId)
            ->orderBy('level', 'desc')
            ->take(4)
            ->get();
        
        // Activity log
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
                'title' => 'New project: ' . $project->title,
                'time' => $project->created_at->diffForHumans(),
                'icon' => 'fa-folder',
                'color' => 'success'
            ]);
        }
        
        $activityLog = $activityLog->sortByDesc('time')->take(10);
        
        // Skill Distribution - FILTER BY USER
        $skillDistribution = [
            'expert' => Skill::where('user_id', $userId)->where('level', '>=', 80)->count(),
            'advanced' => Skill::where('user_id', $userId)->whereBetween('level', [60, 79])->count(),
            'intermediate' => Skill::where('user_id', $userId)->whereBetween('level', [40, 59])->count(),
            'beginner' => Skill::where('user_id', $userId)->where('level', '<', 40)->count(),
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