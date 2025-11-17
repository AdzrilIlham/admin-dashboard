<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectAdminController extends Controller
{
    public function index()
    {
        $projects = Project::with('skill')->latest()->get();
        return view('admin.portfolio.projects.index', compact('projects'));
    }

    public function create()
    {
        $skills = Skill::all();
        return view('admin.portfolio.projects.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'skill_id'    => 'nullable|exists:skills,id',
            'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
            'url'         => 'nullable|url'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        Project::create([
            'name'        => $request->name,
            'description' => $request->description,
            'skill_id'    => $request->skill_id,
            'image'       => $imagePath,
            'url'         => $request->url
        ]);

        return redirect()->route('admin.portfolio.projects.index')
            ->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $skills = Skill::all();
        return view('admin.portfolio.projects.edit', compact('project', 'skills'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'skill_id'    => 'nullable|exists:skills,id',
            'image'       => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
            'url'         => 'nullable|url'
        ]);

        $imagePath = $project->image;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        $project->update([
            'name'        => $request->name,
            'description' => $request->description,
            'skill_id'    => $request->skill_id,
            'image'       => $imagePath,
            'url'         => $request->url
        ]);

        return redirect()->route('admin.portfolio.projects.index')
            ->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->image && Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.portfolio.projects.index')
            ->with('success', 'Project deleted.');
    }
}
