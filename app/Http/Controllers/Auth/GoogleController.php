<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            Log::info('=== Google Callback Started ===');
            
            $googleUser = Socialite::driver('google')->user();
            Log::info('Google user retrieved', ['email' => $googleUser->getEmail()]);
            
            // Cari atau buat user baru
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(24)),
                ]
            );
            
            Log::info('User created/updated', ['user_id' => $user->id]);
            
            // Login user
            Auth::login($user, true);
            Log::info('User logged in', ['user_id' => $user->id, 'auth_check' => Auth::check()]);
            
            // Redirect ke dashboard
            Log::info('Redirecting to dashboard');
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            Log::error('Google callback error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')->with('error', 'Gagal login: ' . $e->getMessage());
        }
    }
}