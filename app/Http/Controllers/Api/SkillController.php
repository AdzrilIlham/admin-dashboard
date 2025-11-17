<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillAdminController extends Controller
{
    public function index()
    {
        $skills = Skill::latest()->get();
        return view('admin.portfolio.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.portfolio.skills.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'level' => 'required|string',
            'icon'  => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('skills', 'public');
        }

        Skill::create([
            'name'  => $request->name,
            'level' => $request->level,
            'icon'  => $iconPath
        ]);

        return redirect()->route('admin.portfolio.skills.index')
            ->with('success', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.portfolio.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'level' => 'required|string',
            'icon'  => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        $iconPath = $skill->icon;
        if ($request->hasFile('icon')) {
            if ($iconPath && Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->delete($iconPath);
            }
            $iconPath = $request->file('icon')->store('skills', 'public');
        }

        $skill->update([
            'name'  => $request->name,
            'level' => $request->level,
            'icon'  => $iconPath
        ]);

        return redirect()->route('admin.portfolio.skills.index')
            ->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        if ($skill->icon && Storage::disk('public')->exists($skill->icon)) {
            Storage::disk('public')->delete($skill->icon);
        }

        $skill->delete();

        return redirect()->route('admin.portfolio.skills.index')
            ->with('success', 'Skill deleted.');
    }
}
