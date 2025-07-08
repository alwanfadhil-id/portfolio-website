@extends('layouts.app')

@section('title', 'Home - Portfolio')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="display-4 fw-bold mb-4">Hi, I'm <span class="text-warning">Alwan Fadhil</span></h1>
                <p class="lead mb-4">Web Developer & Software Engineer</p>
                <p class="mb-4">Saya seorang web developer yang passionate dalam menciptakan solusi digital yang inovatif dan user-friendly. Mari berkarya bersama!</p>
                <div class="hero-buttons d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-code me-2"></i>View My Projects
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>Contact Me
                    </a>
                </div>
            </div>
            <div class="col-lg-6 hero-image text-center">
                <img src="https://res.cloudinary.com/dl0b7duqc/image/upload/v1751960548/profile_bcf9do.png" 
                        alt="Profile Alwan Fadhil" 
                        class="img-fluid rounded-circle shadow-lg" 
                        style="max-width: 350px; width: 100%;"
                        loading="lazy">
            </div>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section class="section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center section-title mb-5">
                <h2 class="fw-bold">Skills & Technologies</h2>
                <p class="text-muted lead">Technologies I work with</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="skill-card loading">
                    <i class="fab fa-html5 text-danger mb-3"></i>
                    <h5 class="fw-bold">Frontend</h5>
                    <p class="text-muted mb-0">HTML5, CSS3, JavaScript, Bootstrap, React, Vue.js</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="skill-card loading">
                    <i class="fas fa-server text-primary mb-3"></i>
                    <h5 class="fw-bold">Backend</h5>
                    <p class="text-muted mb-0">PHP, Laravel, Node.js, Express.js, Python</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="skill-card loading">
                    <i class="fas fa-database text-success mb-3"></i>
                    <h5 class="fw-bold">Database</h5>
                    <p class="text-muted mb-0">MySQL, PostgreSQL, MongoDB, Redis</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="skill-card loading">
                    <i class="fas fa-tools text-warning mb-3"></i>
                    <h5 class="fw-bold">Tools</h5>
                    <p class="text-muted mb-0">Git, Docker, VS Code, Figma, Postman</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects Section -->
<section class="section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center section-title mb-5">
                <h2 class="fw-bold">Featured Projects</h2>
                <p class="text-muted lead">Some of my recent work</p>
            </div>
        </div>
        <div class="row g-4">
            @forelse($projects as $project)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="project-card loading">
                    <div class="position-relative overflow-hidden">
                        @if($project->image)
                            <img src="{{ $project->getOptimizedImageAttribute(400, 200) }}" 
                                 class="card-img-top" 
                                 alt="{{ $project->title }}" 
                                 loading="lazy">
                        @else
                            <img src="https://via.placeholder.com/400x200/667eea/ffffff?text={{ urlencode($project->title) }}" 
                                 class="card-img-top" 
                                 alt="{{ $project->title }}"
                                 loading="lazy">
                        @endif
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 opacity-0 d-flex align-items-center justify-content-center transition-opacity" style="transition: opacity 0.3s ease;">
                            <div class="text-white text-center">
                                <i class="fas fa-eye fa-2x mb-2"></i>
                                <p class="mb-0">View Project</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-3">{{ $project->title }}</h5>
                        <p class="card-text text-muted flex-grow-1 mb-3">{{ Str::limit($project->description, 120) }}</p>
                        <div class="mb-3">
                            @if(is_array($project->tech_stack) || is_object($project->tech_stack))
                                @foreach((array)$project->tech_stack as $tech)
                                    <span class="tech-badge">{{ $tech }}</span>
                                @endforeach
                            @else
                                <span class="tech-badge">{{ $project->tech_stack }}</span>
                            @endif
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            @if($project->link_demo)
                                <a href="{{ $project->link_demo }}" class="btn btn-primary btn-sm flex-fill" target="_blank" rel="noopener">
                                    <i class="fas fa-external-link-alt me-1"></i> Demo
                                </a>
                            @endif
                            @if($project->link_github)
                                <a href="{{ $project->link_github }}" class="btn btn-outline-secondary btn-sm flex-fill" target="_blank" rel="noopener">
                                    <i class="fab fa-github me-1"></i> Code
                                </a>
                            @endif
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="fas fa-info-circle me-1"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted mb-3">Belum ada project yang ditampilkan</h4>
                    <p class="text-muted mb-4">Project akan segera ditambahkan. Stay tuned!</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Lihat Semua Project
                    </a>
                </div>
            </div>
            @endforelse
        </div>
        
        @if($projects->count() > 0)
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('projects.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-th-large me-2"></i>View All Projects
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <div class="loading">
                    <i class="fas fa-rocket fa-3x mb-4"></i>
                    <h2 class="fw-bold mb-4">Ready to work together?</h2>
                    <p class="lead mb-4">Let's discuss your project and bring your ideas to life. I'm here to help you create something amazing!</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Get In Touch
                        </a>
                        <a href="{{ route('projects.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-eye me-2"></i>View My Work
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional Scripts -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hover effect untuk project cards
        const projectCards = document.querySelectorAll('.project-card');
        projectCards.forEach(card => {
            const overlay = card.querySelector('.position-absolute');
            if (overlay) {
                card.addEventListener('mouseenter', function() {
                    overlay.style.opacity = '1';
                });
                card.addEventListener('mouseleave', function() {
                    overlay.style.opacity = '0';
                });
            }
        });

        // Counter animation
        const counters = document.querySelectorAll('[data-count]');
        const animateCounter = (counter) => {
            const target = parseInt(counter.getAttribute('data-count'));
            const increment = target / 100;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.textContent = Math.floor(current) + '+';
            }, 20);
        };

        // Trigger counter animation when in view
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    animateCounter(counter);
                    counterObserver.unobserve(counter);
                }
            });
        });

        // Add data-count attributes and observe counters
        const statNumbers = document.querySelectorAll('.text-primary, .text-success, .text-warning, .text-danger');
        statNumbers.forEach((num, index) => {
            const values = ['50', '30', '3', '10'];
            if (values[index] && num.textContent.includes('+')) {
                num.setAttribute('data-count', values[index]);
                counterObserver.observe(num);
            }
        });

        // Smooth reveal animation for elements
        const revealElements = document.querySelectorAll('.loading');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('loaded');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(el => {
            revealObserver.observe(el);
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Typing effect for hero title
        const heroTitle = document.querySelector('.hero-section h1');
        if (heroTitle) {
            const text = heroTitle.textContent;
            heroTitle.textContent = '';
            let i = 0;
            const typeWriter = () => {
                if (i < text.length) {
                    heroTitle.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 50);
                }
            };
            setTimeout(typeWriter, 500);
        }
    });
</script>
@endpush
@endsection