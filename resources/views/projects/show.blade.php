@extends('layouts.app')

@section('title', $project->title . ' - Portfolio')

@section('content')
<!-- Project Header -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-white">Projects</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $project->title }}</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-4">{{ $project->title }}</h1>
                <p class="lead">{{ $project->description }}</p>
                <div class="d-flex gap-3 mt-4">
                    @if($project->link_demo)
                        <a href="{{ $project->link_demo }}" class="btn btn-light btn-lg" target="_blank">
                            <i class="fas fa-external-link-alt"></i> Live Demo
                        </a>
                    @endif
                    @if($project->link_github)
                        <a href="{{ $project->link_github }}" class="btn btn-outline-light btn-lg" target="_blank">
                            <i class="fab fa-github"></i> View Code
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Project Details -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Project Image -->
                <div class="mb-5">
                    <div class="position-relative">
                        <img src="{{ $project->getHeroImageUrl() }}" 
                            class="img-fluid rounded shadow-lg" 
                            alt="{{ $project->title }}"
                            style="width: 100%; height: 400px; object-fit: cover;">
                        
                        @if($project->featured)
                            <span class="badge bg-warning position-absolute top-0 end-0 m-3 fs-6">
                                <i class="fas fa-star"></i> Featured Project
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Project Description -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">About This Project</h3>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <p class="mb-4" style="line-height: 1.8;">{{ $project->description }}</p>
                            
                            <!-- Key Features -->
                            <h5 class="fw-bold mb-3">Key Features:</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Responsive design for all devices</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Modern and intuitive user interface</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Optimized performance</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Cross-browser compatibility</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Clean and maintainable code</li>
                            </ul>

                            <!-- Development Process -->
                            <h5 class="fw-bold mb-3 mt-4">Development Process:</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle p-2 me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-lightbulb text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Planning & Design</h6>
                                            <small class="text-muted">Wireframing and prototyping</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle p-2 me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-database text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Backend Development</h6>
                                            <small class="text-muted">API and database design</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle p-2 me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-paint-brush text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Frontend Implementation</h6>
                                            <small class="text-muted">UI/UX development</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger rounded-circle p-2 me-3" style="width: 40px; height: 40px;">
                                            <i class="fas fa-rocket text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Testing & Deployment</h6>
                                            <small class="text-muted">Quality assurance</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Gallery -->
                @if($project->hasImage())
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Project Gallery</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <img src="{{ $project->getImageUrl(['width' => 600, 'height' => 400]) }}" 
                                class="img-fluid rounded shadow-sm" 
                                alt="{{ $project->title }} - View 1"
                                style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <img src="{{ $project->getImageUrl(['width' => 600, 'height' => 400]) }}" 
                                class="img-fluid rounded shadow-sm" 
                                alt="{{ $project->title }} - View 2"
                                style="width: 100%; height: 250px; object-fit: cover; filter: sepia(20%);">
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Project Info Sidebar -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Project Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Created:</strong><br>
                            <span class="text-muted">{{ $project->created_at->format('F d, Y') }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <strong>Last Updated:</strong><br>
                            <span class="text-muted">{{ $project->updated_at->format('F d, Y') }}</span>
                        </div>

                        <div class="mb-3">
                            <strong>Status:</strong><br>
                            <span class="badge bg-{{ $project->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>

                        @if($project->link_demo)
                        <div class="mb-3">
                            <strong>Live Demo:</strong><br>
                            <a href="{{ $project->link_demo }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> View Demo
                            </a>
                        </div>
                        @endif

                        @if($project->link_github)
                        <div class="mb-3">
                            <strong>Source Code:</strong><br>
                            <a href="{{ $project->link_github }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                <i class="fab fa-github"></i> GitHub
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Technologies Used -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-tools"></i> Technologies Used</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($project->tech_stack as $tech)
                                <span class="badge bg-primary fs-6 py-2 px-3">{{ $tech }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Share Project -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-share-alt"></i> Share This Project</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode('Check out this project: ' . $project->title) }}" 
                               target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Project Statistics -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Project Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1">{{ count($project->tech_stack) }}</h4>
                                    <small class="text-muted">Technologies</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <h4 class="text-success mb-1">{{ $project->created_at->diffInDays(now()) }}</h4>
                                    <small class="text-muted">Days Ago</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <h4 class="text-warning mb-1">{{ $project->hasImage() ? '1' : '0' }}</h4>
                                <small class="text-muted">Images</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact CTA -->
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body text-center text-white">
                        <h5 class="fw-bold mb-3">Interested in similar work?</h5>
                        <p class="mb-3">Let's discuss your project requirements</p>
                        <a href="{{ route('contact') }}" class="btn btn-light">
                            <i class="fas fa-envelope"></i> Contact Me
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Projects -->
@if($relatedProjects->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="fw-bold">Related Projects</h3>
                <p class="text-muted">You might also be interested in these projects</p>
            </div>
        </div>
        <div class="row">
            @foreach($relatedProjects as $related)
            <div class="col-md-4 mb-4">
                <div class="card project-card h-100">
                    <img src="{{ $related->getCardImageUrl() }}" 
                        class="card-img-top" 
                        alt="{{ $related->title }}"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $related->title }}</h5>
                        <p class="card-text flex-grow-1">{{ $related->getExcerpt(100) }}</p>
                        <div class="mb-3">
                            @foreach(array_slice($related->tech_stack, 0, 3) as $tech)
                                <span class="badge bg-secondary">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <div class="mt-auto">
                            <a href="{{ route('projects.show', $related) }}" class="btn btn-primary btn-sm">
                                View Project
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left"></i> Back to All Projects
                </a>
            </div>
        </div>
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
.project-card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
}

.project-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

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

.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.02);
}

.badge {
    font-size: 0.8rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.development-step {
    transition: all 0.3s ease;
}

.development-step:hover {
    transform: translateX(5px);
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<script>
// Image gallery lightbox effect
document.addEventListener('DOMContentLoaded', function() {
    const galleryImages = document.querySelectorAll('.mb-5 img');
    
    galleryImages.forEach(img => {
        img.addEventListener('click', function() {
            // Create modal for image preview
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $project->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${this.src}" class="img-fluid" alt="${this.alt}">
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.removeChild(modal);
            });
        });
    });
});
</script>
@endpush