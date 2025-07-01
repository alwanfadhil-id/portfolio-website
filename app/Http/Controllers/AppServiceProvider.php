<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = [
                'site_title' => Setting::get('site_title', 'My Portfolio'),
                'site_description' => Setting::get('site_description', 'Welcome to my portfolio'),
                'favicon' => Setting::get('favicon'),
                'profile' => Setting::get('profile'),
                'about_me' => Setting::get('about_me', 'Tell something about yourself'),
                'contact_email' => Setting::get('contact_email', 'your@email.com'),
                'link_github' => Setting::get('link_github'),
                'linkedin_url' => Setting::get('linkedin_url'),
            ];
            
            $view->with('siteSettings', $settings);
        });
    }
}