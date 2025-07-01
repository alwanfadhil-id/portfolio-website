<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ConvertTechStackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    Project::all()->each(function($project) {
        if (!is_array($project->tech_stack)) {
            $project->update([
                'tech_stack' => [$project->tech_stack] // Convert ke array
            ]);
        }
    });
    
    echo "Tech stack converted successfully!";
}
}
