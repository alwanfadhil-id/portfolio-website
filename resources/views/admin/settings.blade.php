<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-gray-800">Pengaturan Website</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                    <a href="{{ route('admin.messages') }}" class="text-blue-600 hover:underline">Pesan</a>
                    <a href="{{ route('admin.projects') }}" class="text-blue-600 hover:underline">Proyek</a>
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
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Kustomisasi Website</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="site_title" class="block text-sm font-medium text-gray-700 mb-2">Judul Website</label>
                            <input type="text" id="site_title" name="site_title" value="{{ $settings['site_title'] }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email Kontak</label>
                            <input type="email" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Website</label>
                        <textarea id="site_description" name="site_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $settings['site_description'] }}</textarea>
                    </div>

                    <!-- Images -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon (Icon Tab Browser)</label>
                            <input type="file" id="favicon" name="favicon" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if($settings['favicon'])
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Current Favicon" class="w-8 h-8">
                                    <span class="text-sm text-gray-500">Favicon saat ini</span>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo Website</label>
                            <input type="file" id="logo" name="logo" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @if($settings['logo'])
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Current Logo" class="w-20 h-auto">
                                    <span class="text-sm text-gray-500">Logo saat ini</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- About Me -->
                    <div class="mb-6">
                        <label for="about_me" class="block text-sm font-medium text-gray-700 mb-2">Tentang Saya</label>
                        <textarea id="about_me" name="about_me" rows="5"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $settings['about_me'] }}</textarea>
                    </div>

                    <!-- Social Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="github_url" class="block text-sm font-medium text-gray-700 mb-2">URL GitHub</label>
                            <input type="url" id="github_url" name="github_url" value="{{ $settings['github_url'] }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-gray-700 mb-2">URL LinkedIn</label>
                            <input type="url" id="linkedin_url" name="linkedin_url" value="{{ $settings['linkedin_url'] }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>