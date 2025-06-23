    <?php


    use App\Http\Controllers\ContactController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\ProjectController;
    use App\Http\Controllers\AdminAuthController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;


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

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::prefix('hidden-admin-panel')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::get('/messages', [AdminController::class, 'messages'])->name('admin.messages');
    Route::delete('/messages/{id}', [AdminController::class, 'deleteMessage'])->name('admin.messages.delete');
    Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
