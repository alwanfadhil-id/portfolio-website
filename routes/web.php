<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin Routes
Route::prefix('admin-panel')->name('admin.')->group(function () {
    
    // Routes yang tidak memerlukan middleware admin (login)
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    
    // Routes yang memerlukan middleware admin
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        
        Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
        Route::delete('/messages/{id}', [AdminController::class, 'deleteMessage'])->name('messages.delete');
        
        Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
        
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        // Custom Proyek Routes
        Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
        Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
        Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
        Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.delete');

    });
});