<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Credentials
    |--------------------------------------------------------------------------
    |
    | Konfigurasi kredensial admin. Sebaiknya disimpan di file .env
    | Password hash dapat dibuat dengan: Hash::make('your_password')
    |
    */
    
    'username' => env('ADMIN_USERNAME', 'admin'),
    
    // Hash dari password default 'admin123'
    // Untuk keamanan, ganti dengan password yang kuat dan hash-nya
    'password_hash' => env('ADMIN_PASSWORD_HASH', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'),
    
    /*
    |--------------------------------------------------------------------------
    | Session Configuration
    |--------------------------------------------------------------------------
    */
    
    'session_timeout' => env('ADMIN_SESSION_TIMEOUT', 30), // menit
    
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    
    'rate_limit_attempts' => env('ADMIN_RATE_LIMIT_ATTEMPTS', 5),
    'rate_limit_duration' => env('ADMIN_RATE_LIMIT_DURATION', 900), // 15 menit dalam detik
];