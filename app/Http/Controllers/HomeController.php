<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
{
    // Ambil data untuk homepage
    $projects = Project::with('skills')
        ->where('status', 'completed')
        ->latest()
        ->take(6)
        ->get();

    $skills = Skill::withCount('projects')
        ->take(8)
        ->get();

    // Tampilkan ke view yang kamu mau (misalnya 'dashboard' atau 'welcome')
    return view('dashboard', compact('projects', 'skills'));
}


    public function about()
    {
        $skills = Skill::withCount('projects')->get();
        
        return view('about', compact('skills'));
    }

    public function portfolio()
{
    // Ambil user dengan role admin (pemilik portofolio)
    $admin = \App\Models\User::where('role', 'admin')->first();

    // Jika admin ditemukan, ambil project miliknya
    $projects = $admin
        ? $admin->projects()->with('skills')->latest()->get()
        : collect(); // kalau tidak ada admin, kosongkan

    return view('portfolio', compact('projects'));


    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $projects = Project::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('skills')
            ->get();
        
        $skills = Skill::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->withCount('projects')
            ->get();
        
        return view('search', compact('projects', 'skills', 'query'));
    }

    public function dashboard()
{
    // Hitung total data
    $totalSkills = \App\Models\Skill::count();
    $totalProjects = \App\Models\Project::count();

    // Hitung pertumbuhan (contoh: dibandingkan bulan lalu)
    $skillsLastMonth = \App\Models\Skill::whereMonth('created_at', now()->subMonth()->month)->count();
    $projectsLastMonth = \App\Models\Project::whereMonth('created_at', now()->subMonth()->month)->count();

    $skillsGrowth = $skillsLastMonth > 0 
        ? round((($totalSkills - $skillsLastMonth) / $skillsLastMonth) * 100, 1)
        : 100;

    $projectsGrowth = $projectsLastMonth > 0 
        ? round((($totalProjects - $projectsLastMonth) / $projectsLastMonth) * 100, 1)
        : 100;

    // Status project
    $completedProjects = \App\Models\Project::where('status', 'completed')->count();
    $ongoingProjects = \App\Models\Project::where('status', 'ongoing')->count();
    $pausedProjects = \App\Models\Project::where('status', 'paused')->count();

    $completionRate = $totalProjects > 0
        ? round(($completedProjects / $totalProjects) * 100, 1)
        : 0;

    // Statistik dummy untuk tampilan (bisa diganti data asli)
    $profileViews = 1324;
    $todayViews = 48;

    // Data tambahan untuk tabel dan grafik
    $recentProjects = \App\Models\Project::latest()->take(5)->get();
    $topSkills = \App\Models\Skill::orderByDesc('level')->take(5)->get();

    // Distribusi skill (berdasarkan level)
    $skillDistribution = [
        'expert' => \App\Models\Skill::where('level', '>=', 80)->count(),
        'advanced' => \App\Models\Skill::whereBetween('level', [60, 79])->count(),
        'intermediate' => \App\Models\Skill::whereBetween('level', [40, 59])->count(),
        'beginner' => \App\Models\Skill::where('level', '<', 40)->count(),
    ];

    return view('dashboard', compact(
        'totalSkills',
        'skillsGrowth',
        'totalProjects',
        'projectsGrowth',
        'completionRate',
        'completedProjects',
        'ongoingProjects',
        'pausedProjects',
        'profileViews',
        'todayViews',
        'recentProjects',
        'topSkills',
        'skillDistribution'
    ));
}

}