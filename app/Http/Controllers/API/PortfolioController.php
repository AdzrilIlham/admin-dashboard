<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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
}
