
// 1. Check semua project dan strukturnya
echo "=== ALL PROJECTS ===\n";
$projects = App\Models\Project::all();
foreach ($projects as $project) {
    echo "ID: {$project->id}\n";
    echo "Title: {$project->title}\n";
    echo "Status: {$project->status}\n";
    echo "Featured: " . ($project->featured ? 'Yes' : 'No') . "\n";
    echo "Tech Stack: " . print_r($project->tech_stack, true) . "\n";
    echo "Image: {$project->image}\n";
    echo "Image Public ID: {$project->image_public_id}\n";
    echo "---\n";
}

// 2. Test query yang sama dengan controller
echo "\n=== TESTING CONTROLLER QUERY ===\n";
$controllerQuery = App\Models\Project::published()->latest()->get();
echo "Controller query result count: " . $controllerQuery->count() . "\n";

// 3. Test pagination
echo "\n=== TESTING PAGINATION ===\n";
$paginatedProjects = App\Models\Project::published()->latest()->paginate(9);
echo "Paginated count: " . $paginatedProjects->count() . "\n";
echo "Paginated total: " . $paginatedProjects->total() . "\n";

// 4. Test getCardImageUrl method
echo "\n=== TESTING IMAGE URL METHOD ===\n";
foreach ($projects as $project) {
    try {
        $imageUrl = $project->getCardImageUrl();
        echo "✅ {$project->title}: {$imageUrl}\n";
    } catch (\Exception $e) {
        echo "❌ {$project->title}: Error - {$e->getMessage()}\n";
        echo "File: {$e->getFile()}:{$e->getLine()}\n";
    }
}

// 5. Test CloudinaryHelper
echo "\n=== TESTING CLOUDINARY HELPER ===\n";
try {
    $cloudinary = new App\Helpers\CloudinaryHelper();
    echo "✅ CloudinaryHelper instantiated successfully\n";
    
    // Test placeholder URL
    $placeholderUrl = $cloudinary->getPlaceholderUrl(['text' => 'Test']);
    echo "✅ Placeholder URL: {$placeholderUrl}\n";
} catch (\Exception $e) {
    echo "❌ CloudinaryHelper error: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}:{$e->getLine()}\n";
}

// 6. Test route
echo "\n=== TESTING ROUTE ===\n";
try {
    $route = route('projects.index');
    echo "✅ Projects index route: {$route}\n";
} catch (\Exception $e) {
    echo "❌ Route error: {$e->getMessage()}\n";
}

// 7. Check tech_stack format
echo "\n=== CHECKING TECH STACK FORMAT ===\n";
foreach ($projects as $project) {
    $techStack = $project->getRawOriginal('tech_stack');
    echo "{$project->title} - Raw tech_stack: {$techStack}\n";
    echo "{$project->title} - Processed tech_stack: " . print_r($project->tech_stack, true) . "\n";
}