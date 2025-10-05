<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard pakai controller
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Skills
Route::resource('skills', SkillController::class);

// Projects
Route::resource('projects', ProjectController::class);

require __DIR__ . '/auth.php';

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

