<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
        ]);

        $this->saveSettings($validated);

        return redirect()->route('settings')->with('success', 'General settings updated successfully!');
    }

    public function updateSocial(Request $request)
    {
        $validated = $request->validate([
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
        ]);

        $this->saveSettings($validated);

        return redirect()->route('settings')->with('success', 'Social media links updated successfully!');
    }

    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'about_me' => 'nullable|string',
        ]);

        $this->saveSettings($validated);

        return redirect()->route('settings')->with('success', 'About me section updated successfully!');
    }

    private function getSettings()
    {
        return Cache::remember('site_settings', 3600, function () {
            // Anda bisa mengambil dari database atau file config
            // Untuk sekarang, kita gunakan array default
            return [
                'site_name' => config('app.name', 'My Portfolio'),
                'site_description' => '',
                'contact_email' => '',
                'phone' => '',
                'github_url' => '',
                'linkedin_url' => '',
                'twitter_url' => '',
                'instagram_url' => '',
                'about_me' => '',
            ];
        });
    }

    private function saveSettings(array $settings)
    {
        $currentSettings = $this->getSettings();
        $mergedSettings = array_merge($currentSettings, $settings);
        
        // Simpan ke cache (atau database jika Anda punya tabel settings)
        Cache::put('site_settings', $mergedSettings, 3600);
        
        // Opsional: Simpan ke database
        // Setting::updateOrCreate(['key' => 'site_settings'], ['value' => json_encode($mergedSettings)]);
    }
}