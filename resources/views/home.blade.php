@extends('layouts.app')

@section('title', 'Home - Portfolio')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Hi, I'm Alwan Fadhil </h1>
                <p class="lead mb-4">Web Developer & Software Engineer</p>
                <p class="mb-4">Saya seorang web developer yang passionate dalam menciptakan solusi digital yang inovatif dan user-friendly.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">View My Projects</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">Contact Me</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('storage/profile.png') }}" alt="Profile" class="img-fluid rounded-circle shadow-lg" style="max-width: 350px;">
            </div>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Skills & Technologies</h2>
                <p class="text-muted">Technologies I work with</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 text-center p-4 project-card">
                    <i class="fab fa-html5 fa-3x text-danger mb-3"></i>
                    <h5>Frontend</h5>
                    <p class="text-muted">HTML, CSS, JavaScript, Bootstrap, React</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 text-center p-4 project-card">
                    <i class="fas fa-server fa-3x text-primary mb-3"></i>
                    <h5>Backend</h5>
                    <p class="text-muted">PHP, Laravel, Node.js</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 text-center p-4 project-card">
                    <i class="fas fa-database fa-3x text-success mb-3"></i>
                    <h5>Database</h5>
                    <p class="text-muted">MySQL, PostgreSQL, MongoDB</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 text-center p-4 project-card">
                    <i class="fas fa-tools fa-3x text-warning mb-3"></i>
                    <h5>Tools</h5>
                    <p class="text-muted">Git, Docker, VS Code, Figma</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold">Featured Projects</h2>
                <p class="text-muted">Some of my recent work</p>
            </div>
        </div>
        <div class="row">
            @forelse($projects as $project)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card project-card h-100">
                    @if($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="card-img-top" alt="{{ $project->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x200/667eea/ffffff?text={{ urlencode($project->title) }}" class="card-img-top" alt="{{ $project->title }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($project->description, 100) }}</p>
                        <div class="mb-3">
                            @if(is_array($project->tech_stack) || is_object($project->tech_stack))
                                @foreach((array)$project->tech_stack as $tech)
                                    <span class="tech-badge">{{ $tech }}</span>
                                @endforeach
                            @else
                                <span class="tech-badge">{{ $project->tech_stack }}</span>
                            @endif
                        </div>
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
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada project yang ditampilkan.</p>
                <a href="{{ route('projects.index') }}" class="btn btn-primary">Lihat Semua Project</a>
            </div>
            @endforelse
        </div>
        @if($projects->count() > 0)
        <div class="row">
            <div class="col-12 text-center mt-4">
                <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">View All Projects</a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h2 class="fw-bold mb-4">Ready to work together?</h2>
                <p class="lead mb-4">Let's discuss your project and bring your ideas to life.</p>
                <a href="{{ route('contact') }}" class="btn btn-light btn-lg">Get In Touch</a>
            </div>
        </div>
    </div>
</section>
@endsection