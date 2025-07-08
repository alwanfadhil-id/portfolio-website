<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Meta tags SEO -->
    <meta name="description" content="@yield('meta_description', 'Portfolio website Alwan Fadhil - Web Developer & Software Engineer')">
    <meta name="keywords" content="@yield('meta_keywords', 'web developer, software engineer, laravel, php')">
    <meta name="author" content="Alwan Fadhil">
    <!-- Open Graph tags -->
    <meta property="og:title" content="@yield('title', 'Portfolio Website')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:image" content="@yield('meta_image', asset('images/default-og.jpg'))">
    <meta property="og:url" content="{{ request()->url() }}">
    <title>@yield('title', 'Portfolio Website')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* Root Variables */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --dark-color: #2c3e50;
            --light-gray: #f8f9fa;
            --shadow: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-hover: 0 8px 25px rgba(0,0,0,0.15);
            --border-radius: 0.5rem;
            --transition: all 0.3s ease;
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            transition: var(--transition);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background: var(--primary-gradient);
            color: white !important;
        }

        /* Hero Section */
        .hero-section {
            background: var(--primary-gradient);
            color: white;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease-out;
        }

        .hero-section .lead {
            font-size: clamp(1.1rem, 2.5vw, 1.5rem);
            margin-bottom: 1.5rem;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .hero-section p {
            font-size: clamp(1rem, 2vw, 1.2rem);
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .hero-buttons {
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .hero-image {
            animation: fadeInUp 1s ease-out 0.8s both;
        }

        /* Modern Profile Image Styling - Replace the existing .hero-image img styles */

            .hero-image img {
                max-width: 100%;
                height: auto;
                /* Remove the existing border and add new styling */
                border: none;
                
                /* Modern gradient border effect */
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 4px; /* Creates space for the gradient border */
                
                /* Fluid, organic shape with smooth curves */
                border-radius: 45% 55% 65% 35% / 35% 45% 55% 65%;
                
                /* Multi-layered shadow for depth */
                box-shadow: 
                    0 8px 32px rgba(102, 126, 234, 0.25),
                    0 16px 64px rgba(118, 75, 162, 0.15),
                    0 0 0 1px rgba(255, 255, 255, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
                
                /* Smooth transitions */
                transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                
                /* Subtle transform for initial state */
                transform: rotate(-2deg) scale(0.98);
            }

            .hero-image img:hover {
                /* Dynamic shape morphing on hover */
                border-radius: 35% 65% 45% 55% / 55% 35% 65% 45%;
                
                /* Enhanced hover effects */
                transform: rotate(1deg) scale(1.02);
                
                /* Intensified shadows */
                box-shadow: 
                    0 12px 48px rgba(102, 126, 234, 0.35),
                    0 24px 96px rgba(118, 75, 162, 0.2),
                    0 0 0 2px rgba(255, 255, 255, 0.15),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                    }

                    @keyframes floating {
            0%, 100% { 
                transform: rotate(-2deg) scale(0.98) translateY(0px);
            }
            50% { 
                transform: rotate(-1deg) scale(0.98) translateY(-8px);
            }
        }

        /* Apply floating animation on load */
        .hero-image img.animate-float {
            animation: floating 6s ease-in-out infinite;
        }

        /* Add this class via JavaScript after page load for the floating effect */
        .hero-image img.loaded {
            animation: floating 6s ease-in-out infinite;
        }

        /* Alternative modern styles you can choose from: */

        /* Option 1: Blob-like organic shape */
        .hero-image img.blob-style {
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            transform: rotate(-3deg);
        }

        .hero-image img.blob-style:hover {
            border-radius: 54% 46% 63% 37% / 45% 52% 48% 55%;
            transform: rotate(2deg) scale(1.05);
        }

        /* Option 2: Soft rounded with slight asymmetry */
        .hero-image img.soft-modern {
            border-radius: 42% 58% 48% 52% / 48% 42% 58% 52%;
            transform: rotate(-1deg);
        }

        .hero-image img.soft-modern:hover {
            border-radius: 58% 42% 52% 48% / 52% 58% 42% 48%;
            transform: rotate(1deg) scale(1.03);
        }

        /* Option 3: Liquid-like flowing shape */
        .hero-image img.liquid-style {
            border-radius: 48% 52% 68% 32% / 42% 58% 42% 58%;
            transform: rotate(-2deg);
        }

        .hero-image img.liquid-style:hover {
            border-radius: 32% 68% 52% 48% / 58% 42% 58% 42%;
            transform: rotate(3deg) scale(1.04);
        }

        /* Enhanced backdrop effect */
        .hero-image::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 50% 40% 60% 40% / 40% 50% 40% 60%;
            z-index: -1;
            transition: all 0.6s ease;
        }

        .hero-image:hover::before {
            transform: scale(1.1) rotate(5deg);
            opacity: 0.8;
        }

        /* Cards */
        .project-card {
            transition: var(--transition);
            border: none;
            box-shadow: var(--shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            height: 100%;
        }

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .project-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: var(--transition);
        }

        .project-card:hover .card-img-top {
            transform: scale(1.05);
        }

        /* Skills Cards */
        .skill-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 100%;
        }

        .skill-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .skill-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            transition: var(--transition);
        }

        .skill-card:hover i {
            transform: scale(1.1);
        }

        /* Tech Badges */
        .tech-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin: 0.2rem;
            display: inline-block;
            font-weight: 500;
            transition: var(--transition);
        }

        .tech-badge:hover {
            transform: scale(1.05);
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-outline-light {
            border: 2px solid white;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-outline-light:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Sections */
        .section {
            padding: 80px 0;
        }

        .section-title {
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        /* CTA Section */
        .cta-section {
            background: var(--primary-gradient);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,100 1000,0 1000,100"/></svg>');
            background-size: cover;
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 60px 0 20px;
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: var(--transition);
        }

        .social-links a:hover {
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 100px 0 60px;
                text-align: center;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }
            
            .hero-buttons .btn {
                width: 100%;
                max-width: 300px;
            }
            
            .hero-image {
                margin-top: 3rem;
            }
            
            .hero-image img {
                max-width: 280px;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .navbar-nav {
                text-align: center;
                padding: 1rem 0;
            }
            
            .skill-card {
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 80px 0 40px;
            }
            
            .hero-image img {
                max-width: 250px;
            }
            
            .section {
                padding: 40px 0;
            }
            
            .btn-primary,
            .btn-outline-light {
                padding: 0.6rem 1.5rem;
                font-size: 0.9rem;
            }
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .loading.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Portfolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="mb-2">Portfolio Website</h5>
                    <p class="mb-0">Dibuat dengan Laravel 10.48.22 dan Bootstrap 5</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="social-links">
                        <a href="#" class="text-decoration-none" aria-label="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="text-decoration-none" aria-label="LinkedIn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-decoration-none" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Portfolio Website. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Lazy loading untuk gambar
            const images = document.querySelectorAll('img[loading="lazy"]');
            
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src || img.src;
                            img.classList.remove('lazy');
                            observer.unobserve(img);
                        }
                    });
                });
                
                images.forEach(img => imageObserver.observe(img));
            }

            // Add loading animation
            const elements = document.querySelectorAll('.loading');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('loaded');
                    }
                });
            });

            elements.forEach(el => observer.observe(el));

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                    navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                } else {
                    navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                    navbar.style.boxShadow = 'none';
                }
            });
        });
    </script>
</body>
</html>