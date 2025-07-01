<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
Route::prefix('admin')->group(function () {
    // Route root admin untuk redirect login/dashboard
    Route::get('/', function () {
        if (Session::has('admin_logged_in') && Session::get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    })->name('admin.root');

    // Login Routes (outside middleware)
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login.submit');

    // Protected Admin Routes (require admin session)
    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Messages
        Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
        Route::delete('/message/{id}', [AdminController::class, 'deleteMessage'])->name('admin.messages.delete');
        
        // Projects
        Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
        Route::get('/projects/create', [AdminController::class, 'createProject'])->name('admin.projects.create');
        Route::post('/projects', [AdminController::class, 'storeProject'])->name('admin.projects.store');
        Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('admin.projects.edit');
        Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('admin.projects.update');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
        
        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        
        // Logout
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});