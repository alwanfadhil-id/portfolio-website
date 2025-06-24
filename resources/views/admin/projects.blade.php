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
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Proyek</h3>
            </div>
            <div class="p-6">
                @if($projects->count() > 0)
                    <div class="grid gap-4">
                        @foreach($projects as $project)
                            <div class="border rounded-lg p-4">
                                <h4 class="font-semibold">{{ $project->title }}</h4>
                                <p class="text-gray-600">{{ $project->description }}</p>
                                <small class="text-gray-500">{{ $project->created_at->format('d/m/Y') }}</small>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        {{ $projects->links() }}
                    </div>
                @else
                    <p class="text-gray-500 text-center">Belum ada proyek.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>