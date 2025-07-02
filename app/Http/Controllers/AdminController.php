<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Setting;
use App\Models\Contact;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;




class AdminController extends Controller
{
    public function __construct()
    {

    }

        public function login()
    {
        // Don't clear session here, let it be
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $admin = Admin::where('username', $request->username)->first();

            if ($admin && Hash::check($request->password, $admin->password)) {
                
                // Simple session setting
                session([
                    'admin_logged_in' => true,
                    'admin_id' => $admin->id,
                    'admin_name' => $admin->name
                ]);
                
                // Debug log
                Log::info('Login Success', [
                    'admin_id' => $admin->id,
                    'session_check' => session('admin_logged_in'),
                    'session_id' => session()->getId()
                ]);
                
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Login berhasil!');
            }

            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->withInput($request->only('username'));
            
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            
            return back()->withErrors([
                'username' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ])->withInput($request->only('username'));
        }
    }

    public function dashboard()
    {
        // Simple session check
        if (!session('admin_logged_in') || !session('admin_id')) {
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        try {
            $totalProjects = Project::count() ?? 0;
            $totalMessages = Message::count() ?? 0;
            $recentMessages = Message::latest()->take(5)->get() ?? collect();

            return view('admin.dashboard', compact('totalProjects', 'totalMessages', 'recentMessages'));
        } catch (\Exception $e) {
            Log::error('Dashboard Error: ' . $e->getMessage());
            
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function messages()
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $messages = Message::latest()->paginate(20);
        return view('admin.messages', compact('messages'));
    }

    public function deleteMessage($id)
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages')->with('success', 'Pesan berhasil dihapus!');
    }



    public function settings()
    {
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        try {
            // Ambil semua setting dalam format [key => value]
            $settings = Setting::pluck('value', 'key')->toArray();
            
            return view('admin.settings', compact('settings'));
        } catch (\Exception $e) {
            Log::error('Settings Error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->withErrors(['error' => 'Gagal memuat pengaturan: ' . $e->getMessage()]);
        }
    }

    public function updateSettings(Request $request)
{
    if (!Session::has('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    try {
        // Validasi
        $request->validate([
            'site_title' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'site_description' => 'nullable|string|max:1000',
            'about_me' => 'nullable|string|max:2000',
            'link_github' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file uploads dengan type
        if ($request->hasFile('favicon')) {
            // Hapus favicon lama jika ada
            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon && file_exists(storage_path('app/public/' . $oldFavicon))) {
                unlink(storage_path('app/public/' . $oldFavicon));
            }
            
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            Setting::set('favicon', $faviconPath, 'image');
        }

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            $oldLogo = Setting::get('logo');
            if ($oldLogo && file_exists(storage_path('app/public/' . $oldLogo))) {
                unlink(storage_path('app/public/' . $oldLogo));
            }
            
            $logoPath = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $logoPath, 'image');
        }

        // Update settings dengan type yang sesuai
        $settingsMap = [
            'site_title' => 'text',
            'contact_email' => 'email', 
            'site_description' => 'textarea',
            'about_me' => 'textarea',
            'link_github' => 'url',
            'linkedin_url' => 'url'
        ];

        foreach ($settingsMap as $key => $type) {
            Setting::set($key, $request->input($key, ''), $type);
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan website berhasil diperbarui!');
            
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->route('admin.settings')
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        Log::error('Update Settings Error: ' . $e->getMessage());
        return redirect()->route('admin.settings')
            ->withErrors(['error' => 'Gagal memperbarui pengaturan: ' . $e->getMessage()])
            ->withInput();
    }
}

    public function projects()
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $projects = Project::latest()->paginate(20);
        return view('admin.projects', compact('projects'));
    }

    public function createProject()
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.projects.create');
    }

    public function storeProject(Request $request)
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tech_stack' => 'nullable|array',
            'link_demo' => 'nullable|url',
            'link_github' => 'nullable|url',
            
        ]);

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->tech_stack = $request->tech_stack;
        $project->link_demo = $request->link_demo;
        $project->link_github = $request->link_github;
        $project->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
            $project->image = $imagePath;
        }

        $project->save();

        return redirect()->route('admin.projects')->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function editProject(Project $project)
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.projects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tech_stack' => 'nullable|array',
            'link_demo' => 'nullable|url',
            'link_github' => 'nullable|url',
        ]);

        $project->title = $request->title;
        $project->description = $request->description;
        $project->tech_stack = $request->tech_stack;
        $project->link_demo = $request->link_demo;
        $project->link_github = $request->link_github;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($project->image && file_exists(storage_path('app/public/' . $project->image))) {
                unlink(storage_path('app/public/' . $project->image));
            }
            
            $imagePath = $request->file('image')->store('projects', 'public');
            $project->image = $imagePath;
        }

        $project->save();

        return redirect()->route('admin.projects')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function deleteProject(Project $project)
    {
        // Cek session admin
        if (!Session::has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Hapus gambar jika ada
        if ($project->image && file_exists(storage_path('app/public/' . $project->image))) {
            unlink(storage_path('app/public/' . $project->image));
        }
        
        $project->delete();

        return redirect()->route('admin.projects')->with('success', 'Proyek berhasil dihapus!');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Logout berhasil!');
    }
}