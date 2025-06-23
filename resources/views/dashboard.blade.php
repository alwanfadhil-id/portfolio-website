<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-gray-800">Admin Dashboard</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.settings') }}" class="text-blue-600 hover:underline">Pengaturan</a>
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

    <div class="max-w-7xl mx-auto py-6 px-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Proyek</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalProjects }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Pesan</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalMessages }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Status Website</h3>
                <p class="text-lg font-semibold text-green-600">Online</p>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Pesan Terbaru</h3>
            </div>
            <div class="p-6">
                @if($recentMessages->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentMessages as $message)
                            <div class="border-l-4 border-blue-500 pl-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $message->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $message->email }}</p>
                                        <p class="text-gray-700 mt-2">{{ Str::limit($message->message, 100) }}</p>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.messages') }}" class="text-blue-600 hover:underline">Lihat semua pesan →</a>
                    </div>
                @else
                    <p class="text-gray-500">Belum ada pesan masuk.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>