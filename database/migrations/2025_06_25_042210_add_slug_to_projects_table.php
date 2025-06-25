<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if slug column already exists
        if (!Schema::hasColumn('projects', 'slug')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });
        }

        // Populate existing records with slugs
        $projects = DB::table('projects')->whereNull('slug')->orWhere('slug', '')->get();
        
        foreach ($projects as $project) {
            $slug = !empty($project->title) ? Str::slug($project->title) : 'untitled-project';
            $originalSlug = $slug;
            $counter = 1;
            
            // Ensure unique slug
            while (DB::table('projects')->where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            DB::table('projects')->where('id', $project->id)->update(['slug' => $slug]);
        }

        // Drop existing unique constraint if it exists (to avoid errors)
        try {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropUnique('projects_slug_unique');
            });
        } catch (Exception $e) {
            // Ignore if constraint doesn't exist
        }

        // Now add the unique constraint
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};