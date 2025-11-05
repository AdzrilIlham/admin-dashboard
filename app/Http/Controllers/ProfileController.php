<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show profile page.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update name & email.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password.
     * Expect PUT request to route profile.password.update
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'confirmed', Password::min(8)],
        ]);

        // Periksa kecocokan password lama
        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        // Jangan izinkan new password sama persis dg old password
        if (Hash::check($validated['new_password'], $user->password)) {
            return back()->withErrors(['new_password' => 'Password baru tidak boleh sama dengan password lama.']);
        }

        // Update password (hash otomatis lewat Hash::make)
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        // Logout user agar login ulang pakai password baru
        Auth::logout();

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui. Silakan login dengan password baru.');
    }

    /**
     * Update avatar (POST)
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        return redirect()->route('profile.index')->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Delete avatar (DELETE - returns JSON)
     */
    public function destroyAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return response()->json(['success' => true]);
    }
}
