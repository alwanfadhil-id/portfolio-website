<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek: {{ $project->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-gray-800">Edit Proyek: {{ $project->title }}</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                    <a href="{{ route('admin.projects') }}" class="text-blue-600 hover:underline">Kembali ke Proyek</a>
                    <a href="{{ route('home') }}" class="text-green-600 hover:underline">Lihat Website</a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 px-4">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Edit Informasi Proyek</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.projects.update', $project->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Proyek *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                               placeholder="Masukkan judul proyek">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Proyek *</label>
                        <textarea id="description" name="description" rows="5" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Deskripsikan proyek Anda secara detail...">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Proyek</label>
                        
                        <!-- Current Image -->
                        @if($project->image)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <img src="{{ asset('storage/' . $project->image) }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-32 h-32 object-cover rounded-lg border">
                                <div class="mt-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" id="remove_image" name="remove_image" class="mr-2">
                                        <span class="text-sm text-gray-600">Hapus gambar saat ini</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                        
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal: 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                        
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Preview new image -->
                        <div id="imagePreview" class="mt-3 hidden">
                            <p class="text-sm text-gray-600 mb-2">Preview gambar baru:</p>
                            <img id="previewImg" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    </div>

                    <!-- Tech Stack -->
                    <div class="mb-6">
                        <label for="tech_stack_input" class="block text-sm font-medium text-gray-700 mb-2">Tech Stack *</label>
                        <input type="text" id="tech_stack_input" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ketik teknologi dan tekan Enter">
                        <div id="tech_stack_container" class="mt-2"></div>
                        <p class="text-sm text-gray-500 mt-1">Tekan Enter untuk menambahkan teknologi baru</p>
                        @error('tech_stack')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Demo and GitHub Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="link_demo" class="block text-sm font-medium text-gray-700 mb-2">Link Demo</label>
                            <input type="url" id="link_demo" name="link_demo" value="{{ old('link_demo', $project->link_demo) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('link_demo') border-red-500 @enderror"
                                   placeholder="https://demo.example.com">
                            @error('link_demo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="link_github" class="block text-sm font-medium text-gray-700 mb-2">Link GitHub</label>
                            <input type="url" id="link_github" name="link_github" value="{{ old('link_github', $project->link_github) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('link_github') border-red-500 @enderror"
                                   placeholder="https://github.com/username/repository">
                            @error('link_github')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $project->status ?? 'draft') === 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>
                            <option value="published" {{ old('status', $project->status ?? '') === 'published' ? 'selected' : '' }}>
                                Published
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" id="featured" name="featured" value="1" 
                                   {{ old('featured', $project->featured ?? false) ? 'checked' : '' }}
                                   class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm font-medium text-gray-700">Proyek Unggulan</span>
                        </label>
                    </div>

                    <!-- Project Info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Informasi Proyek</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                            <div>
                                <span class="font-medium">ID:</span> {{ $project->id }}
                            </div>
                            <div>
                                <span class="font-medium">Dibuat:</span> {{ $project->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div>
                                <span class="font-medium">Diperbarui:</span> {{ $project->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.projects') }}" 
                           class="bg-gray-500 text-white py-2 px-6 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                            Batal
                        </a>
                        <a href="{{ route('projects.show', $project->id) }}" target="_blank"
                           class="bg-green-500 text-white py-2 px-6 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                            Lihat Proyek
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                            Perbarui Proyek
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Delete Project Section -->
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-red-600">Zona Berbahaya</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Hapus Proyek</h4>
                        <p class="text-sm text-gray-500">Setelah dihapus, proyek tidak dapat dikembalikan lagi.</p>
                    </div>
                    <form method="POST" action="{{ route('admin.projects.delete', $project->id) }}" 
                          onsubmit="return confirm('PERINGATAN: Proyek akan dihapus permanen!\\n\\nApakah Anda yakin ingin menghapus proyek \'{{ $project->title }}\'?\\n\\nTindakan ini tidak dapat dibatalkan.')" 
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                            Hapus Proyek
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tech Stack Management
            const techStackInput = document.getElementById('tech_stack_input');
            const techStackContainer = document.getElementById('tech_stack_container');
            
            // Initialize tech stack from existing project data
            let techStack = [];
            @if($project->tech_stack)
                techStack = @json(is_array($project->tech_stack) ? $project->tech_stack : explode(',', $project->tech_stack));
            @endif
            
            // Clean up tech stack array
            techStack = techStack.map(tech => tech.trim()).filter(tech => tech !== '');

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
                    badge.className = 'inline-flex items-center px-2 py-1 mr-1 mb-1 text-xs font-medium text-white bg-blue-600 rounded-full';
                    badge.innerHTML = `
                        ${tech}
                        <button type="button" class="ml-1 text-white hover:text-gray-200" onclick="removeTech(${index})">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
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

            // Image preview functionality
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.classList.add('hidden');
                }
            });

            // Auto-resize textarea
            const descriptionTextarea = document.getElementById('description');
            descriptionTextarea.addEventListener('input', function(e) {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            // Initialize textarea height
            descriptionTextarea.style.height = 'auto';
            descriptionTextarea.style.height = (descriptionTextarea.scrollHeight) + 'px';
        });
    </script>
</body>
</html>