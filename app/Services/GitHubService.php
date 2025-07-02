<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GitHubService
{
    protected $token;
    protected $baseUrl = 'https://api.github.com';

    public function __construct()
    {
        $this->token = config('services.github.token');
    }

    public function getRepositories()
    {
        return Http::withToken($this->token)
            ->get("{$this->baseUrl}/user/repos")
            ->json();
    }

    public function getContributions()
    {
        return Http::withToken($this->token)
            ->get("{$this->baseUrl}/users/alwanfadhil-id/events")
            ->json();
    }
}