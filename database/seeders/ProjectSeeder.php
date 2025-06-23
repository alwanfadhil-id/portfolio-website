<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'E-Commerce Website',
                'description' => 'Full-featured e-commerce platform with shopping cart, payment integration, and admin panel. Built with Laravel and Bootstrap for modern and responsive user experience.',
                'tech_stack' => ['Laravel', 'MySQL', 'Bootstrap', 'JavaScript', 'PayPal API'],
                'link_demo' => 'https://demo-ecommerce.example.com',
                'link_github' => 'https://github.com/username/ecommerce-project',
            ],
            [
                'title' => 'Task Management App',
                'description' => 'Collaborative task management application with real-time updates, team collaboration features, and project tracking capabilities.',
                'tech_stack' => ['Laravel', 'Vue.js', 'MySQL', 'Pusher', 'TailwindCSS'],
                'link_demo' => 'https://taskmanager-demo.example.com',
                'link_github' => 'https://github.com/username/task-manager',
            ],
            [
                'title' => 'Blog Platform',
                'description' => 'Modern blog platform with rich text editor, comment system, categories, and SEO optimization. Features include user authentication and admin dashboard.',
                'tech_stack' => ['Laravel', 'MySQL', 'TinyMCE', 'Bootstrap', 'jQuery'],
                'link_demo' => 'https://blog-platform.example.com',
                'link_github' => 'https://github.com/username/blog-platform',
            ],
            [
                'title' => 'Restaurant Ordering System',
                'description' => 'Online food ordering system with menu management, order tracking, and payment processing. Includes customer and admin interfaces.',
                'tech_stack' => ['Laravel', 'React', 'MySQL', 'Stripe API', 'Bootstrap'],
                'link_demo' => 'https://restaurant-ordering.example.com',
                'link_github' => 'https://github.com/username/restaurant-system',
            ],
            [
                'title' => 'Library Management System',
                'description' => 'Complete library management solution with book cataloging, member management, borrowing system, and reporting features.',
                'tech_stack' => ['Laravel', 'MySQL', 'DataTables', 'Bootstrap', 'Chart.js'],
                'link_demo' => 'https://library-management.example.com',
                'link_github' => 'https://github.com/username/library-system',
            ],
            [
                'title' => 'Weather Dashboard',
                'description' => 'Interactive weather dashboard with current conditions, forecasts, and historical data visualization using external weather APIs.',
                'tech_stack' => ['Laravel', 'Chart.js', 'OpenWeather API', 'Bootstrap', 'JavaScript'],
                'link_demo' => 'https://weather-dashboard.example.com',
                'link_github' => 'https://github.com/username/weather-dashboard',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}