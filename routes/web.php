<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES (untuk pengunjung)
// Middleware: TrackVisitor akan otomatis track
// ============================================

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// About page
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Portfolio/Projects (Public)
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');

// Filter projects
Route::get('/projects/skill/{skillId}', [ProjectController::class, 'filterBySkill'])
    ->name('projects.filterBySkill');
Route::get('/projects/status/{status}', [ProjectController::class, 'filterByStatus'])
    ->name('projects.filterByStatus');

// Skills page (Public)
Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
Route::get('/skills/{id}', [SkillController::class, 'show'])->name('skills.show');

// Search
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Contact (optional)
Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// ============================================
// ADMIN ROUTES (perlu login)
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Export visitors data
    Route::get('/visitors/export', [DashboardController::class, 'exportVisitors'])
        ->name('visitors.export');
    
    // Projects Management
    Route::get('/projects', function () {
        $projects = auth()->user()->projects()->with('skills')->latest()->get();
        return view('admin.projects.index', compact('projects'));
    })->name('projects.index');
    
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    // Skills Management
    Route::get('/skills', function () {
        $skills = auth()->user()->skills()->withCount('projects')->get();
        return view('admin.skills.index', compact('skills'));
    })->name('skills.index');
    
    Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
    Route::get('/skills/{id}/edit', [SkillController::class, 'edit'])->name('skills.edit');
    Route::put('/skills/{id}', [SkillController::class, 'update'])->name('skills.update');
    Route::delete('/skills/{id}', [SkillController::class, 'destroy'])->name('skills.destroy');
    
    
    // Settings (optional)
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});


// ============================================
// AUTH ROUTES (jika menggunakan Breeze/Jetstream)
// ============================================
require __DIR__.'/auth.php';