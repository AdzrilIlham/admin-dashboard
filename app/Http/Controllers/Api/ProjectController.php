<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project; // 👈 Pastikan Anda sudah punya Model 'Project'
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Menampilkan semua data project.
     */
    public function index()
    {
        // Ambil semua project dari database
        $projects = Project::orderBy('created_at', 'desc')->get();

        // Kembalikan (return) data sebagai JSON
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua project',
            'data'    => $projects  
        ], 200); // 200 artinya "OK"
    }
}