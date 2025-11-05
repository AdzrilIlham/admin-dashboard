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
        
        return view('welcome', compact('projects', 'skills'));
    }

    public function about()
    {
        $skills = Skill::withCount('projects')->get();
        
        return view('about', compact('skills'));
    }

    public function portfolio()
    {
        $projects = Project::with('skills')
            ->latest()
            ->get();
        
        $skills = Skill::all();
        
        return view('portfolio', compact('projects', 'skills'));
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
}