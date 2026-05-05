<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nama cookie pengenal unik pengunjung (UUID)
    |--------------------------------------------------------------------------
    */
    'cookie_name' => env('VISITOR_TRACKING_COOKIE_NAME', 'visitor_id'),

    /*
    |--------------------------------------------------------------------------
    | Umur cookie (menit). 30 hari = 43200 menit
    |--------------------------------------------------------------------------
    */
    'cookie_minutes' => (int) env('VISITOR_TRACKING_COOKIE_MINUTES', 60 * 24 * 30),

    /*
    |--------------------------------------------------------------------------
    | Hanya kirim cookie lewat HTTPS (aktifkan di production)
    |--------------------------------------------------------------------------
    */
    'cookie_secure' => env('VISITOR_TRACKING_COOKIE_SECURE'),

    /*
    |--------------------------------------------------------------------------
    | Pola path yang diabaikan (prefix path Laravel request path, tanpa slash di depan)
    | Contoh: "adminku" jika panel admin di /adminku
    |--------------------------------------------------------------------------
    */
    'excluded_path_prefixes' => [
        'admin',
        'api',
        'livewire',
        '__visitor',
        'vendor',
        'storage',
        'sanctum',
        'up',
        '_debugbar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ekstensi file yang dianggap aset statis (tidak dicatat sebagai page view)
    |--------------------------------------------------------------------------
    */
    'excluded_extensions' => [
        'css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico',
        'woff', 'woff2', 'ttf', 'eot', 'map', 'txt', 'xml', 'json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    */
    'debug' => (bool) env('VISITOR_TRACKING_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Filter berdasarkan host (opsional)
    |--------------------------------------------------------------------------
    | Default `false` supaya tracking tidak "skip" hanya karena perbedaan
    | Host header yang dikirim oleh reverse proxy.
    |--------------------------------------------------------------------------
    */
    'enable_host_filter' => (bool) env('VISITOR_TRACKING_ENABLE_HOST_FILTER', false),

    'included_hosts' => array_values(array_filter(
        array_map('trim', explode(',', env('VISITOR_TRACKING_INCLUDED_HOSTS', 'cscorp.co.id,www.cscorp.co.id'))),
        fn ($v) => $v !== ''
    )),

    'excluded_hosts' => array_values(array_filter(
        array_map('trim', explode(',', env('VISITOR_TRACKING_EXCLUDED_HOSTS', 'cscorp.bgeodev.cloud,www.cscorp.bgeodev.cloud'))),
        fn ($v) => $v !== ''
    )),

    /*
    |--------------------------------------------------------------------------
    | Pakai header proxy (X-Forwarded-Host/Proto) untuk rekonstruksi URL & host
    |--------------------------------------------------------------------------
    */
    'use_forwarded_headers' => env('VISITOR_TRACKING_USE_FORWARDED_HEADERS', true),

    /*
    |--------------------------------------------------------------------------
    | CORS khusus endpoint visitor tracking
    |--------------------------------------------------------------------------
    | Default allow origin untuk website utama.
    |--------------------------------------------------------------------------
    */
    'allowed_cors_origins' => array_values(array_filter(
        array_map('trim', explode(',', env('VISITOR_TRACKING_ALLOWED_CORS_ORIGINS', 'https://cscorp.co.id,https://www.cscorp.co.id'))),
        fn ($v) => $v !== ''
    )),

];
