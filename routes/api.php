<?php

use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\PortfolioController;
use Illuminate\Support\Facades\Route;

// Portfolio API Routes (Public - No Auth Required)
Route::prefix('portfolio')->group(function () {
 
    // About Me
    Route::get('/about', [PortfolioController::class, 'aboutMe']);
    
    // Projects
    Route::get('/projects', [PortfolioController::class, 'projects']);
    Route::get('/projects/{id}', [PortfolioController::class, 'projectDetail']);
    
    // Skills
    Route::get('/skills', [PortfolioController::class, 'skills']);
    
    // Blogs
    Route::get('/blogs', [PortfolioController::class, 'blogs']);
    Route::get('/blogs/{slug}', [PortfolioController::class, 'blogDetail']);
    Route::get('/blog-categories', [PortfolioController::class, 'blogCategories']);
    Route::get('/blogs/category/{category}', [PortfolioController::class, 'blogsByCategory']);
    
    // Contact
    Route::post('/contact', [ContactController::class, 'store']);
});