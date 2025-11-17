<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::latest()->get();
        return view('admin.portfolio.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('admin.portfolio.certificates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'organization'=> 'nullable|string',
            'certificate' => 'required|file|mimes:png,jpg,jpeg,pdf|max:4096'
        ]);

        $filePath = $request->file('certificate')->store('certificates', 'public');

        Certificate::create([
            'title'        => $request->title,
            'organization' => $request->organization,
            'file'         => $filePath
        ]);

        return redirect()->route('admin.portfolio.certificates.index')
            ->with('success', 'Certificate uploaded.');
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.portfolio.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'title'        => 'required|string',
            'organization' => 'nullable|string',
            'certificate'  => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:4096'
        ]);

        $filePath = $certificate->file;

        if ($request->hasFile('certificate')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('certificate')->store('certificates', 'public');
        }

        $certificate->update([
            'title'        => $request->title,
            'organization' => $request->organization,
            'file'         => $filePath
        ]);

        return redirect()->route('admin.portfolio.certificates.index')
            ->with('success', 'Certificate updated.');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->file && Storage::disk('public')->exists($certificate->file)) {
            Storage::disk('public')->delete($certificate->file);
        }

        $certificate->delete();

        return redirect()->route('admin.portfolio.certificates.index')
            ->with('success', 'Certificate deleted.');
    }
}
