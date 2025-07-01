<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Admin Login</h2>
        
        <!-- DEBUG INFO - HAPUS SETELAH FIXED -->
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 text-xs">
            <strong>Debug Info:</strong><br>
            Session ID: {{ Session::getId() }}<br>
            Admin Logged In: {{ Session::get('admin_logged_in') ? 'Yes' : 'No' }}<br>
            Admin ID: {{ Session::get('admin_id', 'None') }}<br>
            App Env: {{ app()->environment() }}<br>
            Session Driver: {{ config('session.driver') }}<br>
            HTTPS: {{ request()->secure() ? 'Yes' : 'No' }}<br>
            Domain: {{ request()->getHost() }}<br>
            URL: {{ request()->url() }}
        </div>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Login
            </button>
        </form>
        
        <div class="mt-4 text-center">
            <a href="{{ route('home') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke Website</a>
        </div>
    </div>
</body>
</html>