<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

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
            'status'      => 'required|in:ongoing,completed,paused',
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
            'status'      => 'required|in:ongoing,completed,paused',
            'link'        => 'nullable|url',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'status', 'link']);

        // Jika user upload gambar baru
        if ($request->hasFile('image')) {
            // hapus gambar lama jika ada
            if ($project->image && \Storage::exists('public/'.$project->image)) {
                \Storage::delete('public/'.$project->image);
            }

            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = $path;
        }

        $project->update($data);

        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil diupdate!');
    }

    /**
     * Hapus project
     */
    public function destroy(Project $project)
    {
        // Hapus gambar jika ada
        if ($project->image && \Storage::exists('public/'.$project->image)) {
            \Storage::delete('public/'.$project->image);
        }

        $project->delete();
        
        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil dihapus!');
    }
}