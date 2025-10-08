<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // Menampilkan daftar skill milik user yang login
    public function index()
    {
        // PERBAIKAN: Filter berdasarkan user yang login
        $skills = Skill::where('user_id', auth()->id())->get();
        
        // Hitung distribusi langsung di controller
        $distribution = [
            'expert' => 0,
            'advanced' => 0,
            'intermediate' => 0,
            'beginner' => 0
        ];
        
        foreach ($skills as $skill) {
            // PENTING: Cast ke integer untuk memastikan perbandingan benar
            $level = (int) $skill->level;
            
            if ($level >= 80) {
                $distribution['expert']++;
            } elseif ($level >= 60) {
                $distribution['advanced']++;
            } elseif ($level >= 40) {
                $distribution['intermediate']++;
            } else {
                $distribution['beginner']++;
            }
        }
        
        return view('skills.index', compact('skills', 'distribution'));
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
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
        ]);
        
        // PERBAIKAN: Tambahkan user_id otomatis
        Skill::create([
            'user_id' => auth()->id(), // AUTO-ASSIGN user yang login
            'name' => $request->name,
            'level' => (int) $request->level
        ]);
        
        return redirect()->route('skills.index')->with('success', 'Skill berhasil ditambahkan!');
    }
    
    // Menampilkan form edit
    public function edit(Skill $skill)
    {
        // PERBAIKAN: Pastikan user hanya bisa edit skill miliknya sendiri
        if ($skill->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('skills.edit', compact('skill'));
    }
    
    // Update skill
    public function update(Request $request, Skill $skill)
    {
        // PERBAIKAN: Pastikan user hanya bisa update skill miliknya sendiri
        if ($skill->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
        ]);
        
        $skill->update([
            'name' => $request->name,
            'level' => (int) $request->level
        ]);
        
        return redirect()->route('skills.index')->with('success', 'Skill berhasil diupdate!');
    }
    
    // Hapus skill
    public function destroy(Skill $skill)
    {
        // PERBAIKAN: Pastikan user hanya bisa hapus skill miliknya sendiri
        if ($skill->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill berhasil dihapus!');
    }
}