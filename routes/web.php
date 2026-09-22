<?php

use App\Enums\UserRoleEnum;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/teacher/gradebook', [TeacherController::class, 'gradebook'])->name('teacher.gradebook');

    Route::get('/grades', [DashboardController::class, 'grades'])->name('grades');
    Route::get('/theory', [DashboardController::class, 'theory'])->name('theory');
    Route::get('/practice', [DashboardController::class, 'practice'])->name('practice');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])->name('tasks.submit');

});

require __DIR__.'/auth.php';
