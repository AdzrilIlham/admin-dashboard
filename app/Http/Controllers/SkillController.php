<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SkillController extends Controller
{
    public function index()
    {
        try {
            // Hanya ambil skills milik user yang login
            $skills = Skill::where('user_id', Auth::id())
                          ->orderBy('level', 'desc')
                          ->orderBy('name')
                          ->get();
            
            // Hitung distribusi skill berdasarkan level
            $expertCount = Skill::where('user_id', Auth::id())
                               ->where('level', '>=', 80)
                               ->count();
            $advancedCount = Skill::where('user_id', Auth::id())
                                 ->whereBetween('level', [60, 79])
                                 ->count();
            $intermediateCount = Skill::where('user_id', Auth::id())
                                     ->whereBetween('level', [40, 59])
                                     ->count();
            $beginnerCount = Skill::where('user_id', Auth::id())
                                 ->where('level', '<', 40)
                                 ->count();

            return view('skills.index', compact(
                'skills', 
                'expertCount', 
                'advancedCount', 
                'intermediateCount', 
                'beginnerCount'
            ));
        } catch (\Exception $e) {
            Log::error('Error in skills index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data skills.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:skills,name,NULL,id,user_id,' . Auth::id(),
                'level' => 'required|integer|min:0|max:100'
            ]);

            // Gunakan model create dengan data lengkap
            Skill::create([
                'name' => $validated['name'],
                'level' => $validated['level'],
                'user_id' => Auth::id(),
                // proficiency akan di-set otomatis oleh model boot method
            ]);

            return redirect()->route('skills.index')
                ->with('success', 'Skill berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error storing skill: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambah skill: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $skill = Skill::where('user_id', Auth::id())->findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:skills,name,' . $id . ',id,user_id,' . Auth::id(),
                'level' => 'required|integer|min:0|max:100'
            ]);

            $skill->update([
                'name' => $validated['name'],
                'level' => $validated['level'],
                // proficiency akan di-update otomatis oleh model boot method
            ]);

            return redirect()->route('skills.index')
                ->with('success', 'Skill berhasil diupdate!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating skill: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate skill.')
                ->withInput();
        }
    }

    // SkillController.php - method destroy
public function destroy($id)
{
    $skill = Skill::findOrFail($id);
    $skillName = $skill->name;
    $skill->delete();
    
    return redirect()->route('skills.index')
        ->with('success', 'Skill berhasil dihapus!'); // Simple!
    
    // Atau dengan nama skill tanpa tanda petik:
    // ->with('success', "Skill {$skillName} berhasil dihapus!");
}
}