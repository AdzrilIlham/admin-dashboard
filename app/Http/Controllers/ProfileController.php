<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Menampilkan semua project
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Form tambah project
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Simpan project baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link'        => 'nullable|url',
            'status'      => 'required|in:pending,in-progress,completed',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        Project::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'link'        => $request->link,
            'status'      => $request->status,
        ]);

        // ✅ Redirect ke daftar project
        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil dibuat!');
    }

    /**
     * Form edit project
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update project
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'status'      => 'required|in:pending,in-progress,completed',
            'link'        => 'nullable|url',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'status', 'link']);

        if ($request->hasFile('image')) {
            if ($project->image && Storage::exists('public/' . $project->image)) {
                Storage::delete('public/' . $project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diupdate!');
    }

    /**
     * Hapus project
     */
    public function destroy(Project $project)
    {
        if ($project->image && Storage::exists('public/' . $project->image)) {
            Storage::delete('public/' . $project->image);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success','Project berhasil dihapus!');
    }
}
