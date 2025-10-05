<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/test-env', function () {
    dd(env('GOOGLE_CLIENT_ID'));
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/', function () {
    return 'Homepage aktif';
});

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset (optional)
Route::get('/password/reset', function() {
    return view('auth.passwords.email');
})->name('password.request');

// Route logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard pakai controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// Settings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::put('/settings/social', [SettingsController::class, 'updateSocial'])->name('settings.social.update');
    Route::put('/settings/about', [SettingsController::class, 'updateAbout'])->name('settings.about.update');
});

// Skills Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('skills', SkillController::class);
});

// Projects Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('projects', ProjectController::class);
});

require __DIR__ . '/auth.php';