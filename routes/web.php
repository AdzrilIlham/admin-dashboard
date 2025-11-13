<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    HomeController,
    ProjectController,
    SkillController,
    Auth\SocialiteController,
    ProfileController
};
use App\Http\Controllers\Admin\PortfolioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Struktur utama:
| - Authenticated Routes (user login)
| - Public Routes
| - Admin Routes (auth + admin middleware)
|--------------------------------------------------------------------------
*/

// ============================================================================
// AUTHENTICATED ROUTES (user harus login)
// ============================================================================
Route::middleware(['auth'])->group(function () {

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [ProfileController::class, 'destroyAvatar'])->name('avatar.destroy');
    });

    // Dashboard (User)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ============================================================================
// PUBLIC ROUTES
// ============================================================================
Route::get('/', fn() => redirect()->route('dashboard'))->middleware('auth');

// Auth Google
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

// Static Pages
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::view('/skills', 'skills')->name('skills');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::view('/contact', 'contact')->name('contact');

// Public Projects Routes
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{id}', [ProjectController::class, 'show'])->name('show');
    Route::get('/skill/{skillId}', [ProjectController::class, 'filterBySkill'])->name('filterBySkill');
    Route::get('/status/{status}', [ProjectController::class, 'filterByStatus'])->name('filterByStatus');
});

// Public Skills Routes
Route::prefix('skills')->name('skills.')->group(function () {
    Route::get('/', [SkillController::class, 'index'])->name('index');
    Route::get('/{id}', [SkillController::class, 'show'])->name('show');
});

// ============================================================================
// ADMIN ROUTES (auth + admin middleware)
// ============================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visitors/export', [DashboardController::class, 'exportVisitors'])->name('visitors.export');

    // Admin Projects
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', fn() => view('admin.projects.index', [
            'projects' => auth()->user()->projects()->with('skills')->latest()->get()
        ]))->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
    });

    // Admin Skills
    Route::prefix('skills')->name('skills.')->group(function () {
        Route::get('/', fn() => view('admin.skills.index', [
            'skills' => auth()->user()->skills()->withCount('projects')->get()
        ]))->name('index');
        Route::get('/create', [SkillController::class, 'create'])->name('create');
        Route::post('/', [SkillController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SkillController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SkillController::class, 'update'])->name('update');
        Route::delete('/{id}', [SkillController::class, 'destroy'])->name('destroy');
    });

    // Admin Portfolios (full resource controller)
    Route::resource('portfolios', PortfolioController::class);
});

// ============================================================================
// AUTH ROUTES (Laravel Breeze/Jetstream)
// ============================================================================
require __DIR__ . '/auth.php';
