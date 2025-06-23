<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan setting ke semua view
        View::composer('*', function ($view) {
            $settings = [
                'site_title' => Setting::get('site_title', 'My Portfolio'),
                'site_description' => Setting::get('site_description', 'Welcome to my portfolio'),
                'favicon' => Setting::get('favicon'),
                'logo' => Setting::get('logo'),
                'about_me' => Setting::get('about_me', 'Tell something about yourself'),
                'contact_email' => Setting::get('contact_email', 'your@email.com'),
                'github_url' => Setting::get('github_url'),
                'linkedin_url' => Setting::get('linkedin_url'),
            ];
            
            $view->with('siteSettings', $settings);
        });
    }
}