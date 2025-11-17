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

use App\Http\Controllers\Admin\{
    PortfolioController,
    ContactController
};

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile Settings
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [ProfileController::class, 'destroyAvatar'])->name('avatar.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('dashboard'))->middleware('auth');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::view('/contact', 'contact')->name('contact');

// Public Projects
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{id}', [ProjectController::class, 'show'])->name('show');
});

// Public Skills
Route::prefix('skills')->name('skills.')->group(function () {
    Route::get('/', [SkillController::class, 'index'])->name('index');
    Route::get('/{id}', [SkillController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('portfolios', App\Http\Controllers\Admin\PortfolioController::class);


    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PORTFOLIO (ABOUT + SKILLS + CERTIFICATES + PROJECTS)
    |--------------------------------------------------------------------------
    */
    Route::prefix('portfolio')->name('portfolio.')->group(function () {

        // Portfolio Overview Page
        Route::get('/', [PortfolioController::class, 'index'])->name('index');

        // ABOUT
        Route::put('/update', [PortfolioController::class, 'updatePortfolio'])->name('update');

        // SKILLS CRUD
        Route::post('/skills/store', [PortfolioController::class, 'storeSkill'])->name('skills.store');
        Route::put('/skills/{skill}/update', [PortfolioController::class, 'updateSkill'])->name('skills.update');
        Route::delete('/skills/{skill}/delete', [PortfolioController::class, 'deleteSkill'])->name('skills.delete');

        // CERTIFICATES CRUD
        Route::post('/certificates/store', [PortfolioController::class, 'storeCertificate'])->name('certificates.store');
        Route::put('/certificates/{certificate}/update', [PortfolioController::class, 'updateCertificate'])->name('certificates.update');
        Route::delete('/certificates/{certificate}/delete', [PortfolioController::class, 'deleteCertificate'])->name('certificates.delete');

        // PROJECTS CRUD
        Route::post('/projects/store', [PortfolioController::class, 'storeProject'])->name('projects.store');
        Route::put('/projects/{project}/update', [PortfolioController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project}/delete', [PortfolioController::class, 'deleteProject'])->name('projects.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | CONTACT / INBOX (Admin Reply to User Messages)
    |--------------------------------------------------------------------------
    */
    Route::resource('contacts', ContactController::class);
    Route::post('/contacts/{id}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze / Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
