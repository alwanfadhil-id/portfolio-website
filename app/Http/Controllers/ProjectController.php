<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->paginate(9);
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tech_stack' => 'required|array',
            'link_demo' => 'nullable|url',
            'link_github' => 'nullable|url',
        ]);

        $imagePath = null;
        
        if ($request->hasFile('image')) {
            try {
                // Upload ke Cloudinary
                $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'portfolio/projects',
                    'transformation' => [
                        'width' => 800,
                        'height' => 600,
                        'crop' => 'limit',
                        'quality' => 'auto',
                        'format' => 'auto'
                    ]
                ]);
                
                $imagePath = $uploadResult->getSecurePath();
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal upload gambar: ' . $e->getMessage()]);
            }
        }

        Project::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'tech_stack' => $validated['tech_stack'],
            'image' => $imagePath,
            'link_demo' => $validated['link_demo'],
            'link_github' => $validated['link_github'],
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan!');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }
    
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug,' . $project->id,
            'description' => 'required|string',
            'tech_stack' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link_demo' => 'nullable|url',
            'link_github' => 'nullable|url',
        ]);

        $imagePath = $project->image;
        
        if ($request->hasFile('image')) {
            try {
                // Hapus gambar lama jika ada
                if ($project->image) {
                    $publicId = $this->extractPublicId($project->image);
                    if ($publicId) {
                        Cloudinary::destroy($publicId);
                    }
                }
                
                // Upload gambar baru
                $uploadResult = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'portfolio/projects',
                    'transformation' => [
                        'width' => 800,
                        'height' => 600,
                        'crop' => 'limit',
                        'quality' => 'auto',
                        'format' => 'auto'
                    ]
                ]);
                
                $imagePath = $uploadResult->getSecurePath();
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Gagal upload gambar: ' . $e->getMessage()]);
            }
        }

        $project->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'tech_stack' => $validated['tech_stack'],
            'image' => $imagePath,
            'link_demo' => $validated['link_demo'],
            'link_github' => $validated['link_github'],
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diupdate!');
    }

    public function destroy(Project $project)
    {
        try {
            // Hapus gambar dari Cloudinary jika ada
            if ($project->image) {
                $publicId = $this->extractPublicId($project->image);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            }
            
            $project->delete();
            
            return redirect()->route('projects.index')
                ->with('success', 'Project berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus project: ' . $e->getMessage()]);
        }
    }
    
    private function extractPublicId($cloudinaryUrl)
    {
        // Extract public_id dari URL Cloudinary
        // Contoh URL: https://res.cloudinary.com/demo/image/upload/v1234567890/portfolio/projects/sample.jpg
        preg_match('/\/v\d+\/(.+)\.[^.]+$/', $cloudinaryUrl, $matches);
        return $matches[1] ?? null;
    }

    // Method untuk auto-generate slug dari title
    public function generateSlug(Request $request)
    {
        $title = $request->input('title');
        $slug = Str::slug($title);
        
        // Cek apakah slug sudah ada, jika ya tambahkan angka
        $originalSlug = $slug;
        $counter = 1;
        
        while (Project::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return response()->json(['slug' => $slug]);
    }
}