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

<!-- DEBUG INFO -->
<div class="container mt-3">
    <div class="alert alert-info">
        <strong>Debug Info:</strong> 
        Projects count: {{ $projects->count() }} | 
        Total: {{ $projects->total() }} | 
        Current page: {{ $projects->currentPage() }}
    </div>
</div>

<!-- Projects Grid -->
<section class="py-5">
    <div class="container">
        @if($projects->count() > 0)
        <div class="row">
            @foreach($projects as $project)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card project-card h-100">
                    <!-- Simple image placeholder -->
                    <div class="card-img-container position-relative">
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 
                             style="height: 250px;">
                            <i class="fas fa-code fa-3x text-muted"></i>
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
                                    <span class="badge bg-secondary me-1">{{ $tech }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No tech stack</span>
                            @endif
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
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.card-img-container {
    overflow: hidden;
}
</style>
@endpush