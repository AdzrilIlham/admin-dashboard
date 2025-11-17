<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Show Portfolio Page
     */
    public function index()
    {
        $portfolio = Portfolio::first(); // About
        $skills = Skill::latest()->get();
        $certificates = Certificate::latest()->get();
        $projects = Project::latest()->get();

        return view('admin.portfolio.index', compact(
            'portfolio',
            'skills',
            'certificates',
            'projects'
        ));
    }

    /**
     * Update ABOUT section (single record)
     */
    public function updatePortfolio(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        $portfolio = Portfolio::first();

        if (!$portfolio) {
            $portfolio = new Portfolio();
        }

        $portfolio->title = $request->title;
        $portfolio->description = $request->description;
        $portfolio->save();

        return back()->with('success', 'About updated successfully.');
    }


    /* ================================================================
       SKILLS CRUD
    ================================================================= */

    public function storeSkill(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'level' => 'required|numeric|min:1|max:100'
        ]);

        Skill::create($request->only('name', 'icon', 'level'));

        return back()->with('success', 'Skill added successfully.');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'level' => 'required|numeric|min:1|max:100'
        ]);

        $skill->update($request->only('name', 'icon', 'level'));

        return back()->with('success', 'Skill updated successfully.');
    }

    public function deleteSkill(Skill $skill)
    {
        $skill->delete();

        return back()->with('success', 'Skill deleted.');
    }


    /* ================================================================
       CERTIFICATES CRUD
    ================================================================= */

    public function storeCertificate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('certificates', 'public');

        Certificate::create([
            'title' => $request->title,
            'image' => $path
        ]);

        return back()->with('success', 'Certificate added.');
    }

    public function updateCertificate(Request $request, Certificate $certificate)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = ['title' => $request->title];

        if ($request->hasFile('image')) {
            // delete old
            Storage::disk('public')->delete($certificate->image);
            // store new
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        $certificate->update($data);

        return back()->with('success', 'Certificate updated.');
    }

    public function deleteCertificate(Certificate $certificate)
    {
        Storage::disk('public')->delete($certificate->image);
        $certificate->delete();

        return back()->with('success', 'Certificate deleted.');
    }


    /* ================================================================
       PROJECTS CRUD
    ================================================================= */

    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
            'thumbnail' => 'required|image|max:2048',
        ]);

        $path = $request->file('thumbnail')->store('projects', 'public');

        Project::create([
            'name' => $request->name,
            'url' => $request->url,
            'thumbnail' => $path
        ]);

        return back()->with('success', 'Project added.');
    }

    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'url' => $request->url
        ];

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($project->thumbnail);

            $data['thumbnail'] = $request->file('thumbnail')->store('projects', 'public');
        }

        $project->update($data);

        return back()->with('success', 'Project updated.');
    }

    public function deleteProject(Project $project)
    {
        Storage::disk('public')->delete($project->thumbnail);

        $project->delete();

        return back()->with('success', 'Project deleted.');
    }
}
