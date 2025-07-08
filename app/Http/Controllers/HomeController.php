<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 project terbaru untuk ditampilkan di home
        $projects = Project::latest()->take(3)->get();
        
        return view('home', compact('projects'));
    }
    public function about()
    {
        return view('about'); // atau nama view yang sesuai
    }
}