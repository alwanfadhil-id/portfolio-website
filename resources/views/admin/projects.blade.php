<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-gray-800">Kelola Proyek</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                    <a href="{{ route('admin.settings') }}" class="text-blue-600 hover:underline">Pengaturan</a>
                    <a href="{{ route('admin.messages') }}" class="text-blue-600 hover:underline">Pesan</a>
                    <a href="{{ route('home') }}" class="text-green-600 hover:underline">Lihat Website</a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 px-4">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Projects Management Section -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Proyek</h3>
                        <p class="text-sm text-gray-600 mt-1">Kelola semua proyek portfolio Anda</p>
                    </div>
                    <div class="flex space-x-3">
                        <!-- View Toggle Buttons -->
                        <div class="flex bg-gray-100 rounded-lg p-1">
                            <button onclick="toggleView('grid')" id="grid-btn" 
                                    class="px-3 py-1 text-sm rounded-md transition-colors duration-200 bg-white text-gray-700 shadow-sm">
                                Grid
                            </button>
                            <button onclick="toggleView('table')" id="table-btn" 
                                    class="px-3 py-1 text-sm rounded-md transition-colors duration-200 text-gray-500">
                                Table
                            </button>
                        </div>
                        
                        <!-- Add Project Button -->
                        <a href="{{ route('admin.projects.create') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Proyek
                        </a>
                    </div>
                </div>
            </div>

            <!-- Projects Content -->
            <div class="p-6">
                @if($projects->count() > 0)
                    <!-- Grid View -->
                    <div id="grid-view" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($projects as $project)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200">
                                <!-- Project Image -->
                                <div class="aspect-video bg-gray-100">
                                    @if($project->image)
                                        <img src="{{ asset('storage/' . $project->image) }}" 
                                             alt="{{ $project->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Project Info -->
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $project->title }}</h4>
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($project->description, 100) }}</p>
                                    
                                    <!-- Tech Stack -->
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @php
                                            $techStack = is_array($project->tech_stack) 
                                                ? $project->tech_stack 
                                                : (is_string($project->tech_stack) 
                                                    ? array_map('trim', explode(',', $project->tech_stack)) 
                                                    : []);
                                            $displayTech = array_slice($techStack, 0, 3);
                                        @endphp
                                        @foreach($displayTech as $tech)
                                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">{{ $tech }}</span>
                                        @endforeach
                                        @if(count($techStack) > 3)
                                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">+{{ count($techStack) - 3 }}</span>
                                        @endif
                                    </div>

                                    <!-- Project Meta -->
                                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                        <span>{{ $project->created_at->format('d/m/Y') }}</span>
                                        <div class="flex space-x-2">
                                            @if($project->link_demo)
                                                <span class="text-green-600">Demo</span>
                                            @endif
                                            @if($project->link_github)
                                                <span class="text-gray-600">GitHub</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('projects.show', $project) }}" 
                                           class="flex-1 bg-green-50 text-green-700 py-2 px-3 rounded text-sm text-center hover:bg-green-100 transition-colors duration-200" 
                                           target="_blank">
                                            Lihat
                                        </a>
                                        <a href="{{ route('admin.projects.edit', $project->id) }}" 
                                           class="flex-1 bg-blue-50 text-blue-700 py-2 px-3 rounded text-sm text-center hover:bg-blue-100 transition-colors duration-200">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.projects.delete', $project->id) }}" 
                                              onsubmit="return confirm('Yakin ingin menghapus proyek \'{{ $project->title }}\'?')" 
                                              class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full bg-red-50 text-red-700 py-2 px-3 rounded text-sm hover:bg-red-100 transition-colors duration-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Table View -->
                    <div id="table-view" class="hidden overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tech Stack</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($projects as $project)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($project->image)
                                                <img src="{{ asset('storage/' . $project->image) }}" 
                                                     alt="{{ $project->title }}" 
                                                     class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $project->title }}</div>
                                            @if(isset($project->slug))
                                                <div class="text-sm text-gray-500">{{ $project->slug }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ Str::limit($project->description, 100) }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @php
                                                    $techStack = is_array($project->tech_stack) 
                                                        ? $project->tech_stack 
                                                        : (is_string($project->tech_stack) 
                                                            ? array_map('trim', explode(',', $project->tech_stack)) 
                                                            : []);
                                                @endphp
                                                @foreach($techStack as $tech)
                                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">{{ $tech }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $project->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('projects.show', $project) }}" 
                                                   class="text-green-600 hover:text-green-900" target="_blank">Lihat</a>
                                                <a href="{{ route('admin.projects.edit', $project->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900">Edit</a>
                                                <form method="POST" action="{{ route('admin.projects.delete', $project->id) }}" 
                                                      onsubmit="return confirm('Yakin ingin menghapus proyek ini?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $projects->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada proyek</h3>
                        <p class="text-gray-500 mb-6">Mulai membangun portfolio Anda dengan menambahkan proyek pertama</p>
                        <a href="{{ route('admin.projects.create') }}" 
                           class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Proyek Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleView(view) {
             const gridView = document.getElementById('grid-view');
            const tableView = document.getElementById('table-view');
            const gridBtn = document.getElementById('grid-btn');
            const tableBtn = document.getElementById('table-btn');

            // Hindari error jika elemen tidak ada (bila tidak ada proyek)
            if (!gridView || !tableView || !gridBtn || !tableBtn) return;

            if (view === 'grid') {
                gridView.classList.remove('hidden');
                tableView.classList.add('hidden');
                gridBtn.classList.add('bg-white', 'text-gray-700', 'shadow-sm');
                gridBtn.classList.remove('text-gray-500');
                tableBtn.classList.remove('bg-white', 'text-gray-700', 'shadow-sm');
                tableBtn.classList.add('text-gray-500');
                localStorage.setItem('projectViewMode', 'grid');
            } else {
                gridView.classList.add('hidden');
                tableView.classList.remove('hidden');
                tableBtn.classList.add('bg-white', 'text-gray-700', 'shadow-sm');
                tableBtn.classList.remove('text-gray-500');
                gridBtn.classList.remove('bg-white', 'text-gray-700', 'shadow-sm');
                gridBtn.classList.add('text-gray-500');
                localStorage.setItem('projectViewMode', 'table');
            }
        }

        // Load saved view mode
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('projectViewMode') || 'grid';
            toggleView(savedView);
        });

        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]');
            flashMessages.forEach(function(message) {
                setTimeout(function() {
                    message.style.transition = 'opacity 0.5s ease-out';
                    message.style.opacity = '0';
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>