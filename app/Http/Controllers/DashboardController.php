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
        // Check if proficiency column exists
        try {
            $skillsByProficiency = Skill::select('proficiency', DB::raw('count(*) as total'))
                ->groupBy('proficiency')
                ->pluck('total', 'proficiency')
                ->toArray();
        } catch (\Exception $e) {
            // If proficiency column doesn't exist, use default data
            $skillsByProficiency = [
                'Beginner' => 0,
                'Intermediate' => 0,
                'Advanced' => 0,
                'Expert' => 0
            ];
        }
        
        // Projects by status for chart (Donut Chart)
        try {
            $projectsByStatus = Project::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();
        } catch (\Exception $e) {
            // If status column doesn't exist or has issues
            $projectsByStatus = [
                'ongoing' => 0,
                'completed' => 0,
                'paused' => 0
            ];
        }
        
        // Monthly project growth (for line chart) - Last 6 months
        // SQLite compatible version using strftime
        $monthlyProjects = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->format('M');
            $count = Project::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyProjects[$month] = $count;
        }
        
        // Profile views (dummy data - you can replace with actual tracking later)
        $profileViews = 0;
        $todayViews = 0;
        
        // If you have a visitors table, you can get real data:
        // $profileViews = DB::table('visitors')->count();
        // $todayViews = DB::table('visitors')->whereDate('created_at', today())->count();
        
        // Top Skills - get skills with highest proficiency or most recent
        $topSkills = Skill::latest()
    ->take(5)
    ->get()
    ->map(function($skill) {
        // Cek apakah ada kolom level, jika ada gunakan itu
        if (isset($skill->level)) {
            return $skill;
        }
        
        // Fallback ke proficiency mapping
        $skill->level = match($skill->proficiency) {
            'Expert' => 90,
            'Advanced' => 75,
            'Intermediate' => 50,
            'Beginner' => 25,
            default => 50
        };
        return $skill;
    });
        
        // Activity log - recent activities (you can customize this)
        $activityLog = collect([]);
        
        // Combine recent skills and projects into activity log
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
        
        // Sort by time and take latest 10
        $activityLog = $activityLog->sortByDesc('time')->take(10);
        
        // Skill Distribution by proficiency level
        $skillDistribution = [
            'expert' => Skill::where('proficiency', 'Expert')->count(),
            'advanced' => Skill::where('proficiency', 'Advanced')->count(),
            'intermediate' => Skill::where('proficiency', 'Intermediate')->count(),
            'beginner' => Skill::where('proficiency', 'Beginner')->count(),
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