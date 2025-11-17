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
     * Show admin portfolio dashboard
     */
    public function index()
    {
        $portfolio = Portfolio::first();
        $skills = Skill::all();
        $certificates = Certificate::all();
        $projects = Project::with('skills')->latest()->get();

        return view('admin.portfolio.index', compact(
            'portfolio',
            'skills',
            'certificates',
            'projects'
        ));
    }

    /**
     * Update portfolio (single record)
     */
    public function updatePortfolio(Request $request)
    {
        $portfolio = Portfolio::first();

        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('title', 'subtitle', 'description');

        if ($request->hasFile('profile_image')) {
            if ($portfolio->profile_image) {
                Storage::delete($portfolio->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('portfolio');
        }

        $portfolio->update($data);

        return back()->with('success', 'Portfolio updated successfully!');
    }

    /**
     * Store new skill
     */
    public function storeSkill(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'icon' => 'nullable|string',
            'level' => 'required|integer|min(0)|max(100)',
        ]);

        Skill::create([
            'portfolio_id' => Portfolio::first()->id,
            'name' => $request->name,
            'icon' => $request->icon,
            'level' => $request->level,
        ]);

        return back()->with('success', 'Skill added successfully!');
    }

    /**
     * Update skill
     */
    public function updateSkill(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string',
            'icon' => 'nullable|string',
            'level' => 'required|integer|min(0)|max(100)',
        ]);

        $skill->update($request->only('name', 'icon', 'level'));

        return back()->with('success', 'Skill updated successfully!');
    }

    /**
     * Delete skill
     */
    public function deleteSkill(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill deleted!');
    }

    /**
     * Store certificate
     */
    public function storeCertificate(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'issuer' => 'nullable|string',
            'issued_at' => 'nullable|date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,png|max:4096',
        ]);

        $filePath = null;

        if ($request->hasFile('certificate_file')) {
            $filePath = $request->file('certificate_file')->store('certificates');
        }

        Certificate::create([
            'portfolio_id' => Portfolio::first()->id,
            'title' => $request->title,
            'issuer' => $request->issuer,
            'issued_at' => $request->issued_at,
            'certificate_file' => $filePath
        ]);

        return back()->with('success', 'Certificate uploaded!');
    }

    /**
     * Update certificate
     */
    public function updateCertificate(Request $request, Certificate $certificate)
    {
        $request->validate([
            'title' => 'required|string',
            'issuer' => 'nullable|string',
            'issued_at' => 'nullable|date',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,png|max:4096',
        ]);

        $data = $request->only('title', 'issuer', 'issued_at');

        if ($request->hasFile('certificate_file')) {
            if ($certificate->certificate_file) {
                Storage::delete($certificate->certificate_file);
            }
            $data['certificate_file'] =
                $request->file('certificate_file')->store('certificates');
        }

        $certificate->update($data);

        return back()->with('success', 'Certificate updated!');
    }

    /**
     * Delete certificate
     */
    public function deleteCertificate(Certificate $certificate)
    {
        if ($certificate->certificate_file) {
            Storage::delete($certificate->certificate_file);
        }

        $certificate->delete();

        return back()->with('success', 'Certificate deleted!');
    }

    /**
     * Store project
     */
    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable',
            'image' => 'nullable|image|max:4096',
            'status' => 'required|string',
        ]);

        $data = $request->only('title', 'description', 'status');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects');
        }

        $project = Project::create($data);

        // attach skills if provided
        if ($request->skills) {
            $project->skills()->sync($request->skills);
        }

        return back()->with('success', 'Project created!');
    }

    /**
     * Update project
     */
    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable',
            'image' => 'nullable|image|max:4096',
            'status' => 'required|string',
        ]);

        $data = $request->only('title', 'description', 'status');

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects');
        }

        $project->update($data);

        if ($request->skills) {
            $project->skills()->sync($request->skills);
        }

        return back()->with('success', 'Project updated!');
    }

    /**
     * Delete project
     */
    public function deleteProject(Project $project)
    {
        if ($project->image) {
            Storage::delete($project->image);
        }

        $project->skills()->detach();
        $project->delete();

        return back()->with('success', 'Project deleted!');
    }
}
