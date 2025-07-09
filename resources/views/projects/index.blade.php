@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
<!-- Projects Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-4">My Projects</h1>
                <p class="lead">A collection of my work and personal projects</p>
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
                    <!-- Dynamic Image with Cloudinary optimization -->
                    <div class="card-img-container position-relative">
                        <img src="{{ $project->getCardImageUrl() }}" 
                            class="card-img-top lazy"
                            loading="lazy"
                            alt="{{ $project->title }}"
                            style="height: 250px; object-fit: cover;">
                        
                        @if($project->featured)
                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text flex-grow-1">{{ $project->getExcerpt(120) }}</p>
                        
                        <!-- Tech Stack -->
                        <div class="mb-3">
                            @foreach($project->tech_stack as $tech)
                                <span class="tech-badge">{{ $tech }}</span>
                            @endforeach
                        </div>
                        
                        <!-- Action Buttons -->
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

<!-- Featured Projects Section -->
@if($projects->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="fw-bold">Featured Projects</h3>
                <p class="text-muted">Highlighted projects that showcase my best work</p>
            </div>
        </div>
        <div class="row">
            @foreach($projects->where('featured', true)->take(3) as $featured)
            <div class="col-md-4 mb-4">
                <div class="card project-card h-100 border-primary">
                    <img src="{{ $featured->getCardImageUrl() }}" 
                        class="card-img-top" 
                        alt="{{ $featured->title }}"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $featured->title }}</h5>
                        <p class="card-text">{{ $featured->getExcerpt(80) }}</p>
                        <div class="mb-3">
                            @foreach(array_slice($featured->tech_stack, 0, 3) as $tech)
                                <span class="badge bg-primary">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('projects.show', $featured) }}" class="btn btn-primary btn-sm">
                            View Project
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Categories Filter -->
@if($projects->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="fw-bold">Project Categories</h3>
                <p class="text-muted">Browse projects by technology and type</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center p-3 h-100">
                    <i class="fas fa-globe fa-2x text-primary mb-2"></i>
                    <h6>Web Applications</h6>
                    <small class="text-muted">Full-stack web apps</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center p-3 h-100">
                    <i class="fas fa-mobile-alt fa-2x text-success mb-2"></i>
                    <h6>Mobile Apps</h6>
                    <small class="text-muted">iOS & Android apps</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center p-3 h-100">
                    <i class="fas fa-database fa-2x text-warning mb-2"></i>
                    <h6>API Development</h6>
                    <small class="text-muted">RESTful APIs</small>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card text-center p-3 h-100">
                    <i class="fas fa-paint-brush fa-2x text-danger mb-2"></i>
                    <h6>UI/UX Design</h6>
                    <small class="text-muted">Design projects</small>
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

@push('styles')
<style>
.tech-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    margin: 0.125rem;
    background-color: #e9ecef;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
    color: #495057;
}

.project-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-img-container {
    overflow: hidden;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.project-card:hover .card-img-top {
    transform: scale(1.05);
}

.lazy {
    opacity: 0;
    transition: opacity 0.3s;
}

.lazy.loaded {
    opacity: 1;
}
</style>
@endpush

@push('scripts')
<script>
// Lazy loading implementation
document.addEventListener('DOMContentLoaded', function() {
    const lazyImages = document.querySelectorAll('img.lazy');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.classList.add('loaded');
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => {
        imageObserver.observe(img);
    });
});
</script>
@endpush