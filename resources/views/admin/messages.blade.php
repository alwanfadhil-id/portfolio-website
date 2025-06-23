<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <h1 class="text-xl font-bold text-gray-800">Kelola Pesan</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                    <a href="{{ route('admin.settings') }}" class="text-blue-600 hover:underline">Pengaturan</a>
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

        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Pesan</h3>
            </div>
            <div class="overflow-x-auto">
                @if($messages->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($messages as $message)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $message->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $message->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($message->message, 100) }}</div>
                                        @if(strlen($message->message) > 100)
                                            <button onclick="showFullMessage('{{ $message->id }}')" 
                                                    class="text-blue-600 hover:underline text-xs">Lihat lengkap</button>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form method="POST" action="{{ route('admin.messages.delete', $message->id) }}" 
                                              onsubmit="return confirm('Yakin ingin menghapus pesan ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="px-6 py-4">
                        {{ $messages->links() }}
                    </div>
                @else
                    <div class="p-6">
                        <p class="text-gray-500 text-center">Belum ada pesan masuk.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal untuk pesan lengkap -->
    <div id="messageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Pesan Lengkap</h3>
                </div>
                <div class="p-6">
                    <div id="fullMessageContent" class="text-gray-700"></div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 text-right">
                    <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const messages = {
            @foreach($messages as $message)
                '{{ $message->id }}': {!! json_encode($message->message) !!},
            @endforeach
        };

        function showFullMessage(id) {
            document.getElementById('fullMessageContent').textContent = messages[id];
            document.getElementById('messageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('messageModal').classList.add('hidden');
        }
    </script>
</body>
</html>