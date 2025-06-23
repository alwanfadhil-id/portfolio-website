<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Hash;
use illuminate\Support\Facades\Session;
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
        return view('admin.login');
    }

    //Proses login admin
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
         // Hardcode login untuk kesederhanaan (Anda bisa ganti dengan database)
        $adminUsername = 'admin'; // Ganti dengan username Anda
        $adminPassword = 'admin'; // Ganti dengan password Anda

        if ($request ->username === $$adminUsername && $request->password === $adminPassword) {
            Session::put('admin_logged_in', true);
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }
            return back()->withErrors([
        'username' => 'Username atau password salah.',
    ]);

    }

    /**
     * Halaman Dashboard admin
     */
    public function dashboard()
    {
        if(!Session::get('admin_logged_in')){
            return redirect()->route('admin.login');
    }
    $totalProjects = Project::count();
    $totalMessages = Message::count();
    $recentMessages = Message::latest()->take(5)->get();

    return view('admin.dashboard', compact('totalProjects', 'totalMessages', 'recentMessages'));

    }

    //Halaman Pengaturan
    public function settings()
    {
        if(!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        $settings = [
            'site_title' => Setting::get('site_title', 'My Portfolio'),
            'site_description' => Setting::get('site_description', 'This is my portfolio website.'),
            'favicon' => Setting::get('favicon'),
            'Profile' => Setting::get('Profile'),
            'about_me' => Setting::get('about_me', 'Tell something about yourself'),
            'contact_email' => Setting::get('contact_email', 'your@email.com'),
            'github_url' => Setting::get('github_url'),
            'linkedin_url' => Setting::get('linkedin_url'),
        ];
        return view('admin.settings', compact('settings'));
    }

    //Proses update pengaturan
    public function updateSettings(Request $request)
    {
          if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

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

    // Kelola pesan
    public function messages()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $messages = Message::latest()->paginate(10);
        return view('admin.messages', compact('messages'));
    }

    // Hapus pesan
    public function deleteMessage($id)
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        Message::findOrFail($id)->delete();
        return back()->with('success', 'Pesan berhasil dihapus');
    }

    // Kelola project
    public function projects()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $projects = Project::latest()->paginate(10);
        return view('admin.projects', compact('projects'));
    }

    // Logout admin
    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Logout berhasil');
    }


    

}
