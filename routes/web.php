<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    HomeController,
    ProjectController,
    SkillController,
    Auth\SocialiteController,
    SettingsController,
    ProfileController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Terstruktur: authenticated (profile, dashboard, admin), public (about, portfolio...)
|
*/

// AUTHENTICATED ROUTES (user harus login)
Route::middleware(['auth'])->group(function () {

    // PROFILE (prefix /profile, route name profile.*)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');                 // profile.index
        Route::put('/update', [ProfileController::class, 'update'])->name('update');         // profile.update
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update'); // profile.password.update
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update'); // profile.avatar.update
        Route::delete('/avatar', [ProfileController::class, 'destroyAvatar'])->name('avatar.destroy'); // profile.avatar.destroy
    });

    // DASHBOARD (user)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// PUBLIC ROUTES
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

// Redirect root ke dashboard kalau sudah login, kalau belum akan diarahkan ke login (middleware auth)
Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

// About / Portfolio / Projects / Skills / Search / Contact
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');

Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{id}', [ProjectController::class, 'show'])->name('show');
    Route::get('/skill/{skillId}', [ProjectController::class, 'filterBySkill'])->name('filterBySkill');
    Route::get('/status/{status}', [ProjectController::class, 'filterByStatus'])->name('filterByStatus');
});

Route::prefix('skills')->name('skills.')->group(function () {
    Route::get('/', [SkillController::class, 'index'])->name('index');
    Route::get('/{id}', [SkillController::class, 'show'])->name('show');
});

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::view('/contact', 'contact')->name('contact');

// ADMIN routes (prefix admin, but guarded by auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visitors/export', [DashboardController::class, 'exportVisitors'])->name('visitors.export');

    // Admin Projects
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', function () {
            $projects = auth()->user()->projects()->with('skills')->latest()->get();
            return view('admin.projects.index', compact('projects'));
        })->name('index');

        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('destroy');
    });

    // Admin Skills
    Route::prefix('skills')->name('skills.')->group(function () {
        Route::get('/', function () {
            $skills = auth()->user()->skills()->withCount('projects')->get();
            return view('admin.skills.index', compact('skills'));
        })->name('index');

        Route::get('/create', [SkillController::class, 'create'])->name('create');
        Route::post('/', [SkillController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SkillController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SkillController::class, 'update'])->name('update');
        Route::delete('/{id}', [SkillController::class, 'destroy'])->name('destroy');
    });

    Route::view('/settings', 'admin.settings')->name('settings');
});

// Auth routes (Breeze/Jetstream/etc)
require __DIR__ . '/auth.php';
