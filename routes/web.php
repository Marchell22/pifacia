<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Landing page - Public
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes (dari Laravel Breeze)
require __DIR__.'/auth.php';

// Routes yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
     Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Role Management (dapat diakses semua user yang sudah login)
    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/audit', [RoleController::class, 'audit'])->name('roles.audit');
    
    // User Management (hanya untuk Administrator)
    Route::middleware('admin')->group(function () {
    Route::resource('users', UserController::class);
        Route::get('users/{user}/audit', [UserController::class, 'audit'])->name('users.audit');
    });

        // Projects
    Route::resource('projects', ProjectController::class);
    Route::get('projects/{project}/audit', [ProjectController::class, 'audit'])->name('projects.audit');
    Route::get('projects-export', [ProjectController::class, 'export'])->name('projects.export');
    Route::post('projects-import', [ProjectController::class, 'import'])->name('projects.import');

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::get('tasks/{task}/audit', [TaskController::class, 'audit'])->name('tasks.audit');
    Route::get('tasks/{task}/download', [TaskController::class, 'downloadLampiran'])->name('tasks.download');
    Route::get('tasks-export', [TaskController::class, 'export'])->name('tasks.export');
    Route::post('tasks-import', [TaskController::class, 'import'])->name('tasks.import');

    // Comments
    Route::post('tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('comments/{comment}/audit', [CommentController::class, 'audit'])->name('comments.audit');
    Route::get('tasks/{task}/comments-export', [CommentController::class, 'export'])->name('comments.export');
    Route::post('tasks/{task}/comments-import', [CommentController::class, 'import'])->name('comments.import');
});