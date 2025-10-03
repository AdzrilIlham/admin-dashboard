<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Menampilkan daftar skill
    public function index()
    {
        $skills = Skill::all();
        return view('skills.index', compact('skills'));
    }

    // Menampilkan form tambah skill
    public function create()
    {
        return view('skills.create');
    }

    // Simpan skill baru
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
        ]);

        Skill::create($request->only('name', 'level'));

        return redirect()->route('skills.index')->with('success', 'Skill berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit(Skill $skill)
    {
        return view('skills.edit', compact('skill'));
    }

    // Update skill
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
        ]);

        $skill->update($request->only('name', 'level'));

        return redirect()->route('skills.index')->with('success', 'Skill berhasil diupdate!');
    }

    // Hapus skill
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('skills.index')->with('success', 'Skill berhasil dihapus!');
    }
}
