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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Proyek *</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                                   placeholder="Masukkan judul proyek">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Proyek *</label>
                        <textarea id="description" name="description" rows="5" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Deskripsikan proyek Anda secara detail...">{{ old('description', $project->description) }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Proyek</label>
                        
                        <!-- Current Image -->
                        @if($project->image)
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <img src="{{ asset('storage/' . $project->image) }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-32 h-32 object-cover rounded-lg border">
                            </div>
                        @endif
                        
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal: 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                        
                        <!-- Preview new image -->
                        <div id="imagePreview" class="mt-3 hidden">
                            <p class="text-sm text-gray-600 mb-2">Preview gambar baru:</p>
                            <img id="previewImg" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="tech_stack" class="block text-sm font-medium text-gray-700 mb-2">Tech Stack *</label>
                        <input type="text" id="tech_stack" name="tech_stack" 
                               value="{{ old('tech_stack', is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : $project->tech_stack) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tech_stack') border-red-500 @enderror"
                               placeholder="Laravel, Vue.js, MySQL, Tailwind CSS">
                        <p class="text-sm text-gray-500 mt-1">Pisahkan dengan koma (,) untuk setiap teknologi</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="link_demo" class="block text-sm font-medium text-gray-700 mb-2">Link Demo</label>
                            <input type="url" id="link_demo" name="link_demo" value="{{ old('link_demo', $project->link_demo) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('link_demo') border-red-500 @enderror"
                                   placeholder="https://demo.example.com">
                        </div>
                        
                        <div>
                            <label for="link_github" class="block text-sm font-medium text-gray-700 mb-2">Link GitHub</label>
                            <input type="url" id="link_github" name="link_github" value="{{ old('link_github', $project->link_github) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('link_github') border-red-500 @enderror"
                                   placeholder="https://github.com/username/repository">
                        </div>
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
        // Preview image sebelum upload
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreview').classList.add('hidden');
            }
        });

        // Auto format tech stack
        document.getElementById('tech_stack').addEventListener('blur', function(e) {
            let value = e.target.value;
            // Hapus spasi ekstra dan format ulang
            let formatted = value.split(',').map(item => item.trim()).filter(item => item !== '').join(', ');
            e.target.value = formatted;
        });

        // Auto-resize textarea
        document.getElementById('description').addEventListener('input', function(e) {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</body>
</html>