<?php

use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\PortfolioController;
use Illuminate\Support\Facades\Route;

// Portfolio API Routes (Public - No Auth Required)
Route::prefix('portfolio')->group(function () {
 
    // About Me
    Route::get('/about', [AboutController::class, 'show']);
    Route::post('/about/update', [AboutController::class, 'update']);
    
    // Projects
    Route::get('/projects', [PortfolioController::class, 'projects']);
    Route::get('/projects/{id}', [PortfolioController::class, 'projectDetail']);
    
    // Skills
    Route::get('/skills', [PortfolioController::class, 'skills']);

    // Certificates
    Route::get('/certificates', [CertificateController::class, 'index']);
    Route::post('/certificates', [CertificateController::class, 'store']);
    
    // Blogs
    Route::get('/blogs', [PortfolioController::class, 'blogs']);
    Route::get('/blogs/{slug}', [PortfolioController::class, 'blogDetail']);
    Route::get('/blog-categories', [PortfolioController::class, 'blogCategories']);
    Route::get('/blogs/category/{category}', [PortfolioController::class, 'blogsByCategory']);

    // Comments
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::post('/comments/reply/{id}', [CommentController::class, 'reply']);
    
    // Contact
    Route::post('/contact', [ContactController::class, 'store']);
});