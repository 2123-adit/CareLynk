<?php
// config/auth.php - PERBAIKAN

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'sanctum',
            'provider' => 'users',
            'hash' => false,
        ],

        // ✅ FIX: Guard admin menggunakan provider 'users', bukan 'admin'
        'admin' => [
            'driver' => 'session',
            'provider' => 'users', // ← PENTING: gunakan provider 'users'
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // ← Model User, bukan Admin
        ],
        
        // JANGAN tambahkan provider 'admin' karena kita pakai model User
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];