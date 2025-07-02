@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
<!-- Projects Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-4">My Projects</h1>
                <p class="lead">A collection of clearmy work and personal projects</p>
            </div>
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="py-5">
    <div class="container">
        @if($projects->count() > 0)
        <div class="row">
            @foreach($projects as $project)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card project-card h-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" 
                            class="card-img-top lazy"
                            loading="lazy"
                            alt="{{ $project->title }}"
                            width="400"
                            height="300">
                    @else
                        <img src="https://via.placeholder.com/400x200/667eea/ffffff?text={{ urlencode($project->title) }}" class="card-img-top" alt="{{ $project->title }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($project->description, 120) }}</p>
                        <div class="mb-3">
                            @foreach($project->tech_stack as $tech)
                                <span class="tech-badge">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <div class="mt-auto">
                            <div class="d-flex gap-2">
                                @if($project->link_demo)
                                    <a href="{{ $project->link_demo }}" class="btn btn-primary btn-sm" target="_blank">
                                        <i class="fas fa-external-link-alt"></i> Demo
                                    </a>
                                @endif
                                @if($project->link_github)
                                    <a href="{{ $project->link_github }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                                        <i class="fab fa-github"></i> Code
                                    </a>
                                @endif
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-code fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">No Projects Yet</h3>
                    <p class="text-muted mb-4">Projects will be displayed here once they are added.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Categories Filter (Optional Enhancement) -->
@if($projects->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="fw-bold mb-4">Project Categories</h3>
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center p-3">
                            <i class="fas fa-globe fa-2x text-primary mb-2"></i>
                            <h6>Web Applications</h6>
                            <small class="text-muted">Full-stack web apps</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center p-3">
                            <i class="fas fa-mobile-alt fa-2x text-success mb-2"></i>
                            <h6>Mobile Apps</h6>
                            <small class="text-muted">iOS & Android apps</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center p-3">
                            <i class="fas fa-database fa-2x text-warning mb-2"></i>
                            <h6>API Development</h6>
                            <small class="text-muted">RESTful APIs</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center p-3">
                            <i class="fas fa-paint-brush fa-2x text-danger mb-2"></i>
                            <h6>UI/UX Design</h6>
                            <small class="text-muted">Design projects</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h3 class="fw-bold mb-4">Have a project in mind?</h3>
                <p class="lead mb-4">Let's collaborate and create something amazing together</p>
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-envelope"></i> Start a Project
                </a>
            </div>
        </div>
    </div>
</section>
@endsection