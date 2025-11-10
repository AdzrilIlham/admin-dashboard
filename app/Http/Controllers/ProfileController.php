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
     * Tampilkan halaman profil pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update nama & email pengguna.
     */
    public function update(Request $request)
{
    $user = Auth::user();
    
    $validated = $request->validate([
        'name'  => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
    ]);
    
    $user->update($validated);
    
    // ✅ TAMBAHKAN INI: Refresh session user
    auth()->setUser($user->fresh());
    
    return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
}

    /**
     * Update password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // ✅ Sesuaikan nama field dengan form di Blade
        $validated = $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        // Periksa apakah password lama benar
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        // Jangan izinkan password baru sama dengan password lama
        if (Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password lama.']);
        }

        // Hash dan simpan password baru
        $user->password = Hash::make($validated['password']);
        $user->save();

        // Logout agar pengguna harus login ulang
        Auth::logout();

        return redirect()->route('login')->with('success', 'Password berhasil diperbarui. Silakan login dengan password baru.');
    }

    /**
     * Update avatar pengguna.
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

        // Simpan avatar baru
        $path = $request->file('avatar')->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        return redirect()->route('profile.index')->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Hapus avatar pengguna.
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
