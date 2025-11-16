<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        // Ambil user dengan role admin
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found.',
                'data' => [],
            ]);
        }

        // Ambil project milik admin
        $projects = $admin->projects()->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $projects,
        ]);
    }

    // 👇 TAMBAHKAN METHOD INI
    public function projects()
    {
        try {
            $projects = Project::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Daftar semua project',
                'data' => $projects
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching projects: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    // 👇 TAMBAHKAN METHOD INI
    public function skills()
    {
        try {
            $skills = Skill::all();
            
            return response()->json([
                'success' => true,
                'message' => 'Daftar semua skill',
                'data' => $skills
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching skills: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    // Method lain yang mungkin Anda butuhkan
    public function aboutMe()
    {
        // Implementation
    }

    public function blogs()
    {
        // Implementation
    }

    public function blogDetail($slug)
    {
        // Implementation
    }

    public function blogCategories()
    {
        // Implementation
    }

    public function blogsByCategory($category)
    {
        // Implementation
    }

    public function projectDetail($id)
    {
        try {
            $project = Project::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Detail project',
                'data' => $project
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
                'data' => null
            ], 404);
        }
    }
}