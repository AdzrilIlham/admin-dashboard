<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\SkillController;

Route::get('/skills', [SkillController::class, 'index'])->name('skills.index');
Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
Route::get('/skills/{skill}/edit', [SkillController::class, 'edit'])->name('skills.edit');
Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');
Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

use App\Http\Controllers\ProjectController;

Route::resource('projects', \App\Http\Controllers\ProjectController::class);


