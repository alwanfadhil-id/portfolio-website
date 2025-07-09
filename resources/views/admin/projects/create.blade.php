@extends('layouts.app')

@section('title', 'Tambah Proyek Baru - Portfolio')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-4 text-white">Tambah Proyek Baru</h1>
                <p class="lead text-white mb-4">Buat dan tambahkan proyek baru ke dalam portfolio Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Error Messages -->
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <h6 class="alert-heading">Terjadi kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="card shadow-lg project-card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Informasi Proyek
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">
                                    <i class="fas fa-heading me-2"></i>Judul Proyek <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       class="form-control form-control-lg @error('title') is-invalid @enderror"
                                       placeholder="Masukkan judul proyek yang menarik"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi Proyek <span class="text-danger">*</span>
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="6" 
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Deskripsikan proyek Anda secara detail, termasuk fitur utama, teknologi yang digunakan, dan tujuan proyek..."
                                          required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label for="image" class="form-label fw-bold">
                                    <i class="fas fa-image me-2"></i>Gambar Proyek <span class="text-danger">*</span>
                                </label>
                                <input type="file" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*" 
                                       class="form-control @error('image') is-invalid @enderror"
                                       required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal ukuran: 2MB
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <div class="card" style="max-width: 200px;">
                                        <img id="previewImg" src="" alt="Preview" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <small class="text-muted">Preview gambar</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tech Stack -->
                            <div class="mb-4">
                                <label for="tech_stack_input" class="form-label fw-bold">
                                    <i class="fas fa-code me-2"></i>Tech Stack <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       id="tech_stack_input" 
                                       class="form-control @error('tech_stack') is-invalid @enderror"
                                       placeholder="Ketik teknologi dan tekan Enter untuk menambahkan">
                                <div id="tech_stack_container" class="mt-2"></div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ketik nama teknologi dan tekan Enter untuk menambahkan ke daftar
                                </div>
                                @error('tech_stack')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Links -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="link_demo" class="form-label fw-bold">
                                        <i class="fas fa-external-link-alt me-2"></i>Link Demo
                                    </label>
                                    <input type="url" 
                                           id="link_demo" 
                                           name="link_demo" 
                                           value="{{ old('link_demo') }}"
                                           class="form-control @error('link_demo') is-invalid @enderror"
                                           placeholder="https://demo.example.com">
                                    <div class="form-text">Link untuk melihat demo langsung proyek</div>
                                    @error('link_demo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="link_github" class="form-label fw-bold">
                                        <i class="fab fa-github me-2"></i>Link GitHub
                                    </label>
                                    <input type="url" 
                                           id="link_github" 
                                           name="link_github" 
                                           value="{{ old('link_github') }}"
                                           class="form-control @error('link_github') is-invalid @enderror"
                                           placeholder="https://github.com/username/repository">
                                    <div class="form-text">Link repository GitHub untuk source code</div>
                                    @error('link_github')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="status" class="form-label fw-bold">
                                    <i class="fas fa-toggle-on me-2"></i>Status Proyek
                                </label>
                                <select id="status" 
                                        name="status" 
                                        class="form-select @error('status') is-invalid @enderror"
                                        required>
                                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                        Draft
                                    </option>
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>
                                        Published
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Featured -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="featured" 
                                           name="featured" 
                                           value="1" 
                                           {{ old('featured') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="featured">
                                        <i class="fas fa-star me-2"></i>Proyek Unggulan
                                    </label>
                                </div>
                                <div class="form-text">Centang jika proyek ini ingin ditampilkan sebagai proyek unggulan</div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('admin.projects') }}" 
                                   class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" 
                                        class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Proyek
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Links Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.projects') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-folder me-2"></i>Kelola Proyek
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-success">
                        <i class="fas fa-globe me-2"></i>Lihat Website
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tech Stack Management
    const techStackInput = document.getElementById('tech_stack_input');
    const techStackContainer = document.getElementById('tech_stack_container');
    let techStack = @json(old('tech_stack', []));

    // Render existing tech stack
    renderTechStack();

    // Add tech on Enter key
    techStackInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const tech = this.value.trim();
            if (tech && !techStack.includes(tech)) {
                techStack.push(tech);
                renderTechStack();
                this.value = '';
            }
        }
    });

    function renderTechStack() {
        techStackContainer.innerHTML = '';
        techStack.forEach((tech, index) => {
            const badge = document.createElement('span');
            badge.className = 'badge bg-primary me-1 mb-1';
            badge.innerHTML = `
                ${tech}
                <button type="button" class="btn-close btn-close-white ms-1" style="font-size: 0.6rem;" onclick="removeTech(${index})"></button>
                <input type="hidden" name="tech_stack[]" value="${tech}">
            `;
            techStackContainer.appendChild(badge);
        });
    }

    // Make removeTech function global
    window.removeTech = function(index) {
        techStack.splice(index, 1);
        renderTechStack();
    };

    // Image Preview Functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        if (file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file');
                this.value = '';
                preview.style.display = 'none';
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                this.value = '';
                preview.style.display = 'none';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });

    // Form Validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        const image = document.getElementById('image').files[0];
        
        if (!title || !description || !image) {
            e.preventDefault();
            alert('Please fill in all required fields');
            return;
        }

        if (techStack.length === 0) {
            e.preventDefault();
            alert('Please add at least one technology to the tech stack');
            return;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    });

    // Auto-resize textarea
    document.getElementById('description').addEventListener('input', function(e) {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endsection