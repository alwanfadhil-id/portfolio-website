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
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="img-fluid rounded shadow-lg" alt="{{ $project->title }}">
                    @else
                        <img src="https://via.placeholder.com/800x400/667eea/ffffff?text={{ urlencode($project->title) }}" class="img-fluid rounded shadow-lg" alt="{{ $project->title }}">
                    @endif
                </div>

                <!-- Project Description -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">About This Project</h3>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <p class="mb-4">{{ $project->description }}</p>
                            
                            <!-- You can add more detailed description here -->
                            <h5 class="fw-bold mb-3">Key Features:</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Responsive design</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> User authentication</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Database integration</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Modern UI/UX</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Performance optimized</li>
                            </ul>

                            <h5 class="fw-bold mb-3 mt-4">Development Process:</h5>
                            <p>This project was developed using modern web development practices including:</p>
                            <ul>
                                <li>Planning and wireframing</li>
                                <li>Database design and modeling</li>
                                <li>Backend API development</li>
                                <li>Frontend implementation</li>
                                <li>Testing and deployment</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Screenshots Section (Optional) -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-4">Screenshots</h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <img src="https://via.placeholder.com/400x300/667eea/ffffff?text=Screenshot+1" class="img-fluid rounded shadow-sm" alt="Screenshot 1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <img src="https://via.placeholder.com/400x300/764ba2/ffffff?text=Screenshot+2" class="img-fluid rounded shadow-sm" alt="Screenshot 2">
                        </div>
                    </div>
                </div>
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
                                <span class="badge bg-primary fs-6">{{ $tech }}</span>
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
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fab fa-linkedin"></i>
                            </a>
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
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="fw-bold">Other Projects</h3>
                <p class="text-muted">You might also be interested in these projects</p>
            </div>
        </div>
        <div class="row">
            <!-- This would typically show other projects, for now we'll show placeholder -->
            <div class="col-md-4 mb-4">
                <div class="card project-card h-100">
                    <img src="https://via.placeholder.com/400x200/28a745/ffffff?text=Project+A" class="card-img-top" alt="Project A">
                    <div class="card-body">
                        <h5 class="card-title">Project A</h5>
                        <p class="card-text">Another interesting project with similar technologies.</p>
                        <a href="#" class="btn btn-primary btn-sm">View Project</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card project-card h-100">
                    <img src="https://via.placeholder.com/400x200/ffc107/ffffff?text=Project+B" class="card-img-top" alt="Project B">
                    <div class="card-body">
                        <h5 class="card-title">Project B</h5>
                        <p class="card-text">A web application built with modern frameworks.</p>
                        <a href="#" class="btn btn-primary btn-sm">View Project</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card project-card h-100">
                    <img src="https://via.placeholder.com/400x200/dc3545/ffffff?text=Project+C" class="card-img-top" alt="Project C">
                    <div class="card-body">
                        <h5 class="card-title">Project C</h5>
                        <p class="card-text">Mobile-first responsive design implementation.</p>
                        <a href="#" class="btn btn-primary btn-sm">View Project</a>
                    </div>
                </div>
            </div>
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
@endsection