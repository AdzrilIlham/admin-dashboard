<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Impor Controller yang sudah Anda buat
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SkillController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 👇 Rute untuk mengambil data Projects
Route::get('/projects', [ProjectController::class, 'index']);

// 👇 Rute untuk mengambil data Skills
Route::get('/skills', [SkillController::class, 'index']);