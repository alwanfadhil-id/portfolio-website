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
                    <!-- Project Image -->
                    <div class="card-img-container position-relative overflow-hidden">
                        @if($project->image)
                            <img src="{{ \App\Helpers\ImageOptimizer::getOptimizedImageUrl($project->image, 400, 250) }}" 
                                 class="card-img-top" 
                                 alt="{{ $project->title }}"
                                 style="height: 250px; object-fit: cover; width: 100%;"
                                 loading="lazy">
                        @else
                            <img src="https://via.placeholder.com/400x250/667eea/ffffff?text={{ urlencode($project->title) }}" 
                                 class="card-img-top" 
                                 alt="{{ $project->title }}"
                                 style="height: 250px; object-fit: cover; width: 100%;"
                                 loading="lazy">
                        @endif
                        
                        <!-- Hover Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 opacity-0 project-overlay d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fas fa-eye fa-2x mb-2"></i>
                                <p class="mb-0">View Project</p>
                            </div>
                        </div>
                        
                        @if($project->featured)
                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($project->description, 120) }}</p>
                        
                        <!-- Tech Stack -->
                        <div class="mb-3">
                            @if($project->tech_stack && is_array($project->tech_stack))
                                @foreach($project->tech_stack as $tech)
                                    <span class="tech-badge">{{ $tech }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No tech stack</span>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-auto">
                            <div class="d-flex gap-2">
                                @if($project->link_demo)
                                    <a href="{{ $project->link_demo }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener">
                                        <i class="fas fa-external-link-alt"></i> Demo
                                    </a>
                                @endif
                                @if($project->link_github)
                                    <a href="{{ $project->link_github }}" class="btn btn-outline-secondary btn-sm" target="_blank" rel="noopener">
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
                    <h3 class="text-muted mb-3">No Projects Found</h3>
                    <p class="text-muted mb-4">No published projects available.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection

@push('styles')
<style>
.project-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    overflow: hidden;
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.project-card:hover .project-overlay {
    opacity: 1 !important;
}

.card-img-container {
    overflow: hidden;
    position: relative;
}

.project-overlay {
    transition: opacity 0.3s ease;
}

.tech-badge {
    display: inline-block;
    background: #f8f9fa;
    color: #6c757d;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
    margin-right: 0.25rem;
    margin-bottom: 0.25rem;
    border: 1px solid #dee2e6;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.project-card:hover .card-img-top {
    transform: scale(1.05);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hover effect untuk project cards
    const projectCards = document.querySelectorAll('.project-card');
    projectCards.forEach(card => {
        const overlay = card.querySelector('.project-overlay');
        if (overlay) {
            card.addEventListener('mouseenter', function() {
                overlay.style.opacity = '1';
            });
            card.addEventListener('mouseleave', function() {
                overlay.style.opacity = '0';
            });
        }
    });

    // Error handling untuk gambar yang gagal dimuat
    const projectImages = document.querySelectorAll('.project-card img');
    projectImages.forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'https://via.placeholder.com/400x250/667eea/ffffff?text=' + encodeURIComponent('Project Image');
        });
    });
});
</script>
@endpush