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

// Admin Routes tanpa middleware
Route::prefix('admin')->group(function () {

    // Route root admin untuk redirect login/dashboard
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });

    // Login (khusus tamu)
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

    // Group dengan middleware admin
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
        Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::get('/projects/create', [AdminController::class, 'createProject'])->name('admin.projects.create');
        Route::post('/projects', [AdminController::class, 'storeProject'])->name('admin.projects.store');
        Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('admin.projects.edit');
        Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('admin.projects.update');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
        Route::delete('/message', [AdminController::class, 'deleteMessages'])->name('admin.messages.delete');
    });
});
