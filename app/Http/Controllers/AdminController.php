<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\Project;
use App\Models\Message;

class AdminController extends Controller
{
    /**
     * Halaman Login admin
     */
    public function login()
    {
        // Redirect jika sudah login
        if (Session::get('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    /**
     * Proses login admin dengan rate limiting
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string|min:4',
        ]);

        $key = 'admin_login_attempts:' . $request->ip();
        
        // Rate limiting - maksimal 5 percobaan per 15 menit
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'username' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        // Ambil kredensial dari environment atau config
        $adminUsername = config('admin.username', 'admin');
        $adminPassword = config('admin.password_hash', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); // bcrypt dari 'password'

        // Verifikasi login
        if ($request->username === $adminUsername && Hash::check($request->password, $adminPassword)) {
            // Reset rate limiter jika berhasil
            RateLimiter::clear($key);
            
            // Set session
            Session::put([
                'admin_logged_in' => true,
                'admin_last_activity' => now(),
                'admin_login_time' => now(),
                'admin_ip' => $request->ip(),
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }

        // Increment attempts jika gagal
        RateLimiter::hit($key, 900); // 15 menit

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    /**
     * Halaman Dashboard admin
     */
    public function dashboard()
    {
        $totalProjects = Project::count();
        $totalMessages = Message::count();
        $recentMessages = Message::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProjects', 'totalMessages', 'recentMessages'));
    }

    /**
     * Halaman Pengaturan
     */
    public function settings()
    {
        $settings = [
            'site_title' => Setting::get('site_title', 'My Portfolio'),
            'site_description' => Setting::get('site_description', 'This is my portfolio website.'),
            'favicon' => Setting::get('favicon'),
            'logo' => Setting::get('logo'),
            'about_me' => Setting::get('about_me', 'Tell something about yourself'),
            'contact_email' => Setting::get('contact_email', 'your@email.com'),
            'github_url' => Setting::get('github_url'),
            'linkedin_url' => Setting::get('linkedin_url'),
        ];
        
        return view('admin.settings', compact('settings'));
    }

    /**
     * Proses update pengaturan
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:100',
            'site_description' => 'required|string|max:500',
            'contact_email' => 'required|email|max:100',
            'about_me' => 'required|string|max:2000',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'favicon' => 'nullable|image|mimes:ico,png|max:512', // 512KB max
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048', // 2MB max
        ]);

        $settings = $request->except(['_token', 'favicon', 'logo']);

        // Simpan setting text
        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        // Handle upload favicon
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('uploads', 'public');
            Setting::set('favicon', $faviconPath, 'image');
        }

        // Handle upload logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('uploads', 'public');
            Setting::set('logo', $logoPath, 'image');
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * Kelola pesan
     */
    public function messages()
    {
        $messages = Message::latest()->paginate(10);
        return view('admin.messages', compact('messages'));
    }

    /**
     * Hapus pesan
     */
    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        
        return back()->with('success', 'Pesan berhasil dihapus');
    }

    /**
     * Kelola project - List
     */
    public function projects()
    {
        $projects = Project::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Form tambah project
     */
    public function createProject()
    {
        return view('admin.projects.create');
    }

    /**
     * Simpan project baru
     */
    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tech_stack' => 'required|string',
            'link_demo' => 'nullable|url|max:255',
            'link_github' => 'nullable|url|max:255',
        ]);

        // Generate slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Upload image
        $imagePath = $request->file('image')->store('projects', 'public');

        // Convert tech_stack dari string ke array
        $techStack = array_map('trim', explode(',', $request->tech_stack));

        Project::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'tech_stack' => $techStack,
            'link_demo' => $request->link_demo,
            'link_github' => $request->link_github,
        ]);

        return redirect()->route('admin.projects')->with('success', 'Proyek berhasil ditambahkan!');
    }

    /**
     * Form edit project
     */
    public function editProject(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update project
     */
    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tech_stack' => 'required|string',
            'link_demo' => 'nullable|url|max:255',
            'link_github' => 'nullable|url|max:255',
        ]);

        // Generate slug jika title berubah
        $slug = $project->slug;
        if ($request->title !== $project->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle image upload
        $imagePath = $project->image;
        if ($request->hasFile('image')) {
            // Hapus image lama
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        // Convert tech_stack dari string ke array
        $techStack = array_map('trim', explode(',', $request->tech_stack));

        $project->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
            'tech_stack' => $techStack,
            'link_demo' => $request->link_demo,
            'link_github' => $request->link_github,
        ]);

        return redirect()->route('admin.projects')->with('success', 'Proyek berhasil diperbarui!');
    }

    /**
     * Hapus project
     */
    public function deleteProject(Project $project)
    {
        // Hapus image
        if ($project->image && Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects')->with('success', 'Proyek berhasil dihapus!');
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Session::forget([
            'admin_logged_in',
            'admin_last_activity',
            'admin_login_time',
            'admin_ip'
        ]);
        
        return redirect()->route('admin.login')->with('success', 'Logout berhasil');
    }
}