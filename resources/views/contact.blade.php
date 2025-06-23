@extends('layouts.app')

@section('title', 'Contact - Portfolio')

@section('content')
<!-- Contact Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-4">Get In Touch</h1>
                <p class="lead">Let's discuss your project and bring your ideas to life</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Info -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5">
                <!-- Success Message -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Contact Form -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-envelope"></i> Send Message</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="6" required 
                                          placeholder="Tell me about your project, ideas, or just say hello...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane"></i> Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Info Cards -->
                <div class="row mt-5">
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-primary mb-3">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </div>
                                <h6 class="fw-bold">Email</h6>
                                <p class="text-muted mb-0">your.email@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-success mb-3">
                                    <i class="fas fa-phone fa-2x"></i>
                                </div>
                                <h6 class="fw-bold">Phone</h6>
                                <p class="text-muted mb-0">+62 812-3456-7890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center h-100 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="text-warning mb-3">
                                    <i class="fas fa-map-marker-alt fa-2x"></i>
                                </div>
                                <h6 class="fw-bold">Location</h6>
                                <p class="text-muted mb-0">Pekanbaru, Riau</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Social Media Links -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-share-alt"></i> Connect With Me</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-outline-dark">
                                <i class="fab fa-github"></i> GitHub
                            </a>
                            <a href="#" class="btn btn-outline-primary">
                                <i class="fab fa-linkedin"></i> LinkedIn
                            </a>
                            <a href="#" class="btn btn-outline-info">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="#" class="btn btn-outline-danger">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Availability Status -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-clock"></i> Availability</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-success me-2">Available for projects</span>
                        </div>
                        <p class="text-muted mb-3">I'm currently available for new projects and collaborations.</p>
                        <small class="text-muted">
                            <strong>Response time:</strong> Usually within 24 hours<br>
                            <strong>Working hours:</strong> Mon-Fri, 9 AM - 6 PM (WIB)
                        </small>
                    </div>
                </div>

                <!-- Services -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Services I Offer</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Web Application Development
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                API Development & Integration
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Database Design & Optimization
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Website Maintenance
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Technical Consultation
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-question-circle"></i> Quick FAQ</h5>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        How long does a project take?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Project timeline varies depending on complexity. Simple websites: 1-2 weeks, complex web applications: 4-8 weeks.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        What's your preferred tech stack?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        I primarily work with Laravel/PHP for backend, React/Vue.js for frontend, and MySQL for databases.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section (Optional) -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h3 class="fw-bold">My Location</h3>
                <p class="text-muted">Based in Pekanbaru, Riau, Indonesia</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <!-- Placeholder for map - you can integrate Google Maps or other mapping service -->
                        <div class="bg-light text-center py-5">
                            <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Interactive Map</h5>
                            <p class="text-muted">Google Maps integration can be added here</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center text-white">
                <h3 class="fw-bold mb-4">Ready to Start Your Project?</h3>
                <p class="lead mb-4">Let's turn your ideas into reality. Get in touch today!</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="mailto:your.email@example.com" class="btn btn-light btn-lg">
                        <i class="fas fa-envelope"></i> Email Me
                    </a>
                    <a href="tel:+6281234567890" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone"></i> Call Me
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
