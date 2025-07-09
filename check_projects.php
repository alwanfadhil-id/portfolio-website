
// File: database/check_projects.php
// Jalankan dengan: php artisan tinker

use App\Models\Project;

echo "=== PROJECT DATABASE CHECK ===\n";

// 1. Check total projects
$totalProjects = Project::count();
echo "Total projects in database: {$totalProjects}\n";

if ($totalProjects == 0) {
    echo "❌ No projects found in database!\n";
    echo "📝 You need to create some projects first.\n";
    
    // Create sample project
    echo "\n=== CREATING SAMPLE PROJECT ===\n";
    $sampleProject = Project::create([
        'title' => 'Sample Project',
        'slug' => 'sample-project',
        'description' => 'This is a sample project created for testing purposes.',
        'tech_stack' => ['PHP', 'Laravel', 'MySQL', 'Bootstrap'],
        'status' => 'published',
        'featured' => true,
        'link_demo' => 'https://example.com/demo',
        'link_github' => 'https://github.com/user/sample-project'
    ]);
    
    echo "✅ Sample project created: {$sampleProject->title}\n";
} else {
    echo "✅ Projects found in database\n";
}

// 2. Check projects by status
echo "\n=== PROJECTS BY STATUS ===\n";
$statuses = ['draft', 'published', 'archived'];
foreach ($statuses as $status) {
    $count = Project::where('status', $status)->count();
    echo "{$status}: {$count} projects\n";
}

// 3. Check published projects
$publishedProjects = Project::where('status', 'published')->get();
echo "\n=== PUBLISHED PROJECTS ===\n";
if ($publishedProjects->count() == 0) {
    echo "❌ No published projects found!\n";
    echo "📝 Make sure your projects have status = 'published'\n";
    
    // Update all projects to published
    echo "\n=== UPDATING ALL PROJECTS TO PUBLISHED ===\n";
    $updated = Project::where('status', '!=', 'published')->update(['status' => 'published']);
    echo "✅ Updated {$updated} projects to published status\n";
} else {
    echo "✅ Found {$publishedProjects->count()} published projects:\n";
    foreach ($publishedProjects as $project) {
        echo "  - {$project->title} (ID: {$project->id})\n";
    }
}

// 4. Check featured projects
$featuredProjects = Project::where('featured', true)->count();
echo "\n=== FEATURED PROJECTS ===\n";
echo "Featured projects: {$featuredProjects}\n";

// 5. Check tech_stack format
echo "\n=== TECH STACK FORMAT CHECK ===\n";
$allProjects = Project::all();
foreach ($allProjects as $project) {
    $techStack = $project->tech_stack;
    $type = gettype($techStack);
    echo "{$project->title}: tech_stack is {$type}\n";
    
    if (!is_array($techStack)) {
        echo "  ⚠️  Converting tech_stack to array format\n";
        if (is_string($techStack)) {
            $newTechStack = json_decode($techStack, true) ?? explode(',', $techStack);
            $project->update(['tech_stack' => $newTechStack]);
            echo "  ✅ Fixed tech_stack for {$project->title}\n";
        }
    }
}

// 6. Check CloudinaryHelper
echo "\n=== CLOUDINARY HELPER CHECK ===\n";
try {
    $cloudinaryHelper = new \App\Helpers\CloudinaryHelper();
    echo "✅ CloudinaryHelper class loaded successfully\n";
} catch (\Exception $e) {
    echo "❌ CloudinaryHelper error: {$e->getMessage()}\n";
    echo "📝 Make sure CloudinaryHelper class exists and is properly configured\n";
}

// 7. Check image URLs
echo "\n=== IMAGE URL CHECK ===\n";
foreach ($allProjects as $project) {
    try {
        $imageUrl = $project->getCardImageUrl();
        echo "✅ {$project->title}: {$imageUrl}\n";
    } catch (\Exception $e) {
        echo "❌ {$project->title}: Error getting image URL - {$e->getMessage()}\n";
    }
}

echo "\n=== CHECK COMPLETE ===\n";
echo "Now try to access your projects page again.\n";
echo "If you still have issues, check the Laravel logs in storage/logs/\n";