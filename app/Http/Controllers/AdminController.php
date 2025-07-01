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
        // Jika sudah login, redirect ke dashboard
        if (Session::has('admin_logged_in') && Session::get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari admin berdasarkan username
        $admin = Admin::where('username', $request->username)->first();

        // Verifikasi admin dan password
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Set session untuk login
            Session::put('admin_logged_in', true);
            Session::put('admin_id', $admin->id);
            Session::put('admin_name', $admin->name);
            
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    public function dashboard()
    {
        try {
            // Cek apakah admin sudah login
            if (!Session::has('admin_logged_in')) {
                return redirect()->route('admin.login');
            }

            // Hitung total dengan error handling
            $totalProjects = Project::count() ?? 0;
            $totalMessages = Message::count() ?? 0;
            $recentMessages = Message::latest()->take(5)->get() ?? collect();

            return view('admin.dashboard', compact('totalProjects', 'totalMessages', 'recentMessages'));
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Dashboard Error: ' . $e->getMessage());
            
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'Terjadi kesalahan saat memuat dashboard.']);
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

    $admin = Admin::find(Session::get('admin_id'));

    // Ambil semua setting dalam format [key => value]
    $settings = Setting::pluck('value', 'key')->toArray();

    return view('admin.settings', compact('admin', 'settings'));
}


   public function updateSettings(Request $request)
{
    if (!Session::has('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    $admin = Admin::find(Session::get('admin_id'));

    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
        'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
        'current_password' => 'nullable|string',
        'new_password' => 'nullable|string|min:8|confirmed',
        'site_title' => 'nullable|string|max:255',
        'contact_email' => 'nullable|email|max:255',
        'site_description' => 'nullable|string',
        'about_me' => 'nullable|string',
        'link_github' => 'nullable|url',
        'linkedin_url' => 'nullable|url',
        'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update admin info
    $admin->name = $request->name;
    $admin->username = $request->username;
    $admin->email = $request->email;

    if ($request->filled('new_password')) {
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak benar.']);
            }
        }
        $admin->password = Hash::make($request->new_password);
    }

    $admin->save();
    Session::put('admin_name', $admin->name);

    // Handle file uploads
    if ($request->hasFile('favicon')) {
        $faviconPath = $request->file('favicon')->store('settings', 'public');
        Setting::set('favicon', $faviconPath);
    }

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('settings', 'public');
        Setting::set('logo', $logoPath);
    }

    // Update all settings
    $settingsToUpdate = [
        'site_title', 'contact_email', 'site_description', 'about_me',
        'link_github', 'linkedin_url'
    ];

    foreach ($settingsToUpdate as $setting) {
        Setting::set($setting, $request->$setting ?? '');
    }

    return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil diperbarui!');
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
            'tech_stack' => 'nullable|string',
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
            'tech_stack' => 'nullable|string',
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