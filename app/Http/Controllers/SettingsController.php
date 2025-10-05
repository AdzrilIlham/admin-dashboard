<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman settings
     */
    public function index()
    {
        $settings = $this->getSettings();
        return view('settings.index', compact('settings'));
    }


    public function updateAppearance(Request $request)
{
    $darkMode = $request->has('dark_mode') ? true : false;

    $this->saveSettings(['dark_mode' => $darkMode]);

    return redirect()->route('settings')->with('success', 'Appearance updated successfully!');
}

    /**
     * Update general settings + dark mode
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'dark_mode' => 'nullable|boolean',
        ]);

        // Pastikan dark_mode tersimpan sebagai boolean
        $validated['dark_mode'] = $request->has('dark_mode');

        $this->saveSettings($validated);

        return redirect()->route('settings')->with('success', 'Settings updated successfully!');
    }

    /**
     * Update social media links
     */
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

    /**
     * Update About Me
     */
    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'about_me' => 'nullable|string',
        ]);

        $this->saveSettings($validated);

        return redirect()->route('settings')->with('success', 'About me section updated successfully!');
    }

    /**
     * Ambil settings dari cache
     */
    private function getSettings()
    {
        return Cache::remember('site_settings', 3600, function () {
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
                'dark_mode' => false, // default dark mode
            ];
        });
    }

    /**
     * Simpan settings ke cache
     */
    private function saveSettings(array $settings)
    {
        $currentSettings = $this->getSettings();
        $mergedSettings = array_merge($currentSettings, $settings);

        // Simpan ke cache
        Cache::put('site_settings', $mergedSettings, 3600);

        // Opsional: simpan ke database jika mau permanen
        // Setting::updateOrCreate(['key' => 'site_settings'], ['value' => json_encode($mergedSettings)]);
    }
}
