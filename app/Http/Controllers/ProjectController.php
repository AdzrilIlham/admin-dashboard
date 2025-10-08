<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Menampilkan semua project milik user yang login
     */
    public function index()
    {
        // PERBAIKAN: Filter berdasarkan user yang login
        $projects = Project::where('user_id', auth()->id())->get();
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

        // PERBAIKAN: Tambahkan user_id otomatis
        Project::create([
            'user_id'     => auth()->id(), // AUTO-ASSIGN user yang login
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
        // PERBAIKAN: Pastikan user hanya bisa edit project miliknya sendiri
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('projects.edit', compact('project'));
    }

    /**
     * Update project
     */
    public function update(Request $request, Project $project)
    {
        // PERBAIKAN: Pastikan user hanya bisa update project miliknya sendiri
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
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
        // PERBAIKAN: Pastikan user hanya bisa hapus project miliknya sendiri
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Hapus gambar jika ada
        if ($project->image && \Storage::exists('public/'.$project->image)) {
            \Storage::delete('public/'.$project->image);
        }

        $project->delete();
        
        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil dihapus!');
    }
}