<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $skillsCount = Skill::count();
        $projectsCount = Project::count();

        return view('dashboard', compact('skillsCount', 'projectsCount'));
    }
}
