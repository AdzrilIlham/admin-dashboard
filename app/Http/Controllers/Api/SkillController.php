<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill; // 👈 Pastikan nama Model ini benar
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all(); // Ambil semua skill
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua skill',
            'data'    => $skills  
        ], 200);
    }
}