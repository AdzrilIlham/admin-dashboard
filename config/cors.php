<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Ini adalah file konfigurasi untuk menangani CORS.
    |
    */

    'paths' => [
        'api/*', // 👈 Ini mengizinkan semua rute API Anda
        'sanctum/csrf-cookie'
    ],

    'allowed_methods' => ['*'], // Mengizinkan semua method (GET, POST, PUT, dll)

    'allowed_origins' => [
        'http://localhost:3000',    // 👈 Ini mengizinkan React (localhost:3000)
        'http://127.0.0.1:3000',  // 👈 Ini juga untuk jaga-jaga
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Mengizinkan semua header

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];