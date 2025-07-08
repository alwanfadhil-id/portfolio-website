<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Helpers\ImageOptimizer;
use Illuminate\Support\Facades\Storage;

class MigrateImagesToCloudinary extends Command
{
    protected $signature = 'migrate:images-to-cloudinary';
    protected $description = 'Migrate existing images to Cloudinary';

    public function handle()
    {
        $projects = Project::whereNotNull('image')
            ->where('image', 'not like', '%cloudinary.com%')
            ->get();

        $this->info("Found {$projects->count()} projects with local images");

        foreach ($projects as $project) {
            try {
                $localPath = storage_path('app/public/' . $project->image);
                
                if (file_exists($localPath)) {
                    $cloudinaryUrl = ImageOptimizer::uploadImage(
                        new \Illuminate\Http\UploadedFile($localPath, basename($localPath)),
                        'projects'
                    );
                    
                    $project->update(['image' => $cloudinaryUrl]);
                    $this->info("Migrated: {$project->title}");
                } else {
                    $this->warn("File not found: {$localPath}");
                }
            } catch (\Exception $e) {
                $this->error("Failed to migrate {$project->title}: " . $e->getMessage());
            }
        }

        $this->info('Migration completed!');
    }
}