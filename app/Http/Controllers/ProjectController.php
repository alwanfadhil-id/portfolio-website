<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Helpers\CloudinaryHelper;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    protected $cloudinary;

    public function __construct(CloudinaryHelper $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    /**
     * Display a listing of projects
     */
    public function index()
    {
        $projects = Project::published()
            ->latest()
            ->paginate(9);

        return view('projects.index', compact('projects'));
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
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $uploadResult = $this->cloudinary->uploadImage(
                $request->file('image'),
                'projects'
            );

            if ($uploadResult['success']) {
                $projectData['image_public_id'] = $uploadResult['public_id'];
                $projectData['image'] = $uploadResult['url'];
            } else {
                return back()->with('error', 'Failed to upload image: ' . $uploadResult['message']);
            }
        }

        $project = Project::create($projectData);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        // Get related projects (same tech stack or recent)
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->where(function ($query) use ($project) {
                if ($project->tech_stack) {
                    foreach ($project->tech_stack as $tech) {
                        $query->orWhereJsonContains('tech_stack', $tech);
                    }
                }
            })
            ->latest()
            ->take(3)
            ->get();

        // If no related projects found, get latest projects
        if ($relatedProjects->count() < 3) {
            $relatedProjects = Project::published()
                ->where('id', '!=', $project->id)
                ->latest()
                ->take(3)
                ->get();
        }

        return view('projects.show', compact('project', 'relatedProjects'));
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

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($project->image_public_id) {
                $this->cloudinary->deleteImage($project->image_public_id);
            }

            $uploadResult = $this->cloudinary->uploadImage(
                $request->file('image'),
                'projects'
            );

            if ($uploadResult['success']) {
                $projectData['image_public_id'] = $uploadResult['public_id'];
                $projectData['image'] = $uploadResult['url'];
            } else {
                return back()->with('error', 'Failed to upload image: ' . $uploadResult['message']);
            }
        } elseif ($request->has('remove_image')) {
            // Remove image if requested
            if ($project->image_public_id) {
                $this->cloudinary->deleteImage($project->image_public_id);
            }
            $projectData['image_public_id'] = null;
            $projectData['image'] = null;
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
        // Delete image from Cloudinary
        if ($project->image_public_id) {
            $this->cloudinary->deleteImage($project->image_public_id);
        }

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