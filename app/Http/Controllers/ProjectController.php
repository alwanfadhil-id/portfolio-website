<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Helpers\CloudinaryHelper;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    protected $cloudinary;

    public function __construct()
    {
        // Sementara comment CloudinaryHelper untuk test
        // $this->cloudinary = $cloudinary;
    }

    /**
     * Display a listing of projects - Simple version for debugging
     */
    public function index()
    {
        try {
            
            
            // 1. Get all projects first
            $allProjects = Project::all();
            
            
            // 2. Get published projects
            $publishedProjects = Project::where('status', 'published')->get();
           
            
            // 3. Get with pagination
            $projects = Project::where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->paginate(9);
            
           
            
            // 4. Test each project
            foreach ($projects as $project) {
                
            }
            
            return view('projects.index', compact('projects'));
            
        } catch (\Exception $e) {
            
            
            // Return error view or redirect
            return view('projects.index', ['projects' => collect()->paginate(9)]);
        }
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tech_stack' => 'required|array',
            'tech_stack.*' => 'string|max:50',
            'link_demo' => 'nullable|url',
            'link_github' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'featured' => 'boolean'
        ]);

        $projectData = $validated;
        
        // Auto-generate slug from title
        $projectData['slug'] = $this->generateUniqueSlug($validated['title']);
        
        // Skip image upload for now
        // if ($request->hasFile('image')) {
        //     // Handle image upload later
        // }

        $project = Project::create($projectData);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        // Simple version without related projects for now
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tech_stack' => 'required|array',
            'tech_stack.*' => 'string|max:50',
            'link_demo' => 'nullable|url',
            'link_github' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'featured' => 'boolean'
        ]);

        $projectData = $validated;

        // Update slug if title changed
        if ($validated['title'] !== $project->title) {
            $projectData['slug'] = $this->generateUniqueSlug($validated['title'], $project->id);
        }

        $project->update($projectData);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified project
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    /**
     * Generate unique slug from title
     */
    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        
        $query = Project::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
            
            $query = Project::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        
        return $slug;
    }

    /**
     * Generate slug from title (AJAX endpoint)
     */
    public function generateSlug(Request $request)
    {
        $title = $request->input('title');
        $excludeId = $request->input('exclude_id');
        
        $slug = $this->generateUniqueSlug($title, $excludeId);
        
        return response()->json(['slug' => $slug]);
    }
}