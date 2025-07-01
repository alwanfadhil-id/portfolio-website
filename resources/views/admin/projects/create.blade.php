<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-gray-800">Tambah Proyek Baru</h1>
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

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Proyek</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Proyek *</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                                   placeholder="Masukkan judul proyek">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Proyek *</label>
                        <textarea id="description" name="description" rows="5" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                  placeholder="Deskripsikan proyek Anda secara detail...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Proyek *</label>
                        <input type="file" id="image" name="image" accept="image/*" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image') border-red-500 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG, WEBP. Maksimal: 2MB</p>
                        
                        <!-- Preview image -->
                        <div id="imagePreview" class="mt-3 hidden">
                            <img id="previewImg" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
                        </div>
                    </div>

<div class="mb-3">
    <label class="form-label">Tech Stack</label>
    <select name="tech_stack[]" multiple class="form-select">
        @foreach(['Laravel', 'React', 'Tailwind CSS'] as $tech)
            <option value="{{ $tech }}" {{ in_array($tech, old('tech_stack', $project->tech_stack ?? [])) ? 'selected' : '' }}>
                {{ $tech }}
            </option>
        @endforeach
    </select>
</div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="link_demo" class="block text-sm font-medium text-gray-700 mb-2">Link Demo</label>
                            <input type="url" id="link_demo" name="link_demo" value="{{ old('link_demo') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('link_demo') border-red-500 @enderror"
                                   placeholder="https://demo.example.com">
                        </div>
                        
                        <div>
                            <label for="link_github" class="block text-sm font-medium text-gray-700 mb-2">Link GitHub</label>
                            <input type="url" id="link_github" name="link_github" value="{{ old('link_github') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('link_github') border-red-500 @enderror"
                                   placeholder="https://github.com/username/repository">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.projects') }}" 
                           class="bg-gray-500 text-white py-2 px-6 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Simpan Proyek
                        </button>
                    </div>
                </form>
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
            }
        });

        // Auto format tech stack
        document.getElementById('tech_stack').addEventListener('blur', function(e) {
            let value = e.target.value;
            // Hapus spasi ekstra dan format ulang
            let formatted = value.split(',').map(item => item.trim()).filter(item => item !== '').join(', ');
            e.target.value = formatted;
        });
    </script>
</body>
</html>