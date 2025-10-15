<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Active Theme
    |--------------------------------------------------------------------------
    |
    | Bu ayar hangi temanın aktif olduğunu belirler. Varsayılan olarak 'default'
    | teması kullanılır. Session'da 'active_theme' varsa o kullanılır.
    |
    */

    'active' => env('ACTIVE_THEME', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Theme Path
    |--------------------------------------------------------------------------
    |
    | Temaların bulunduğu dizin. Varsayılan olarak resources/themes
    |
    */

    'path' => resource_path('themes'),

    /*
    |--------------------------------------------------------------------------
    | Asset Path
    |--------------------------------------------------------------------------
    |
    | Tema asset'lerinin public dizinindeki yolu
    |
    */

    'asset_path' => 'themes',

    /*
    |--------------------------------------------------------------------------
    | Cache Themes
    |--------------------------------------------------------------------------
    |
    | Tema bilgilerini cache'lemek için bu ayarı true yapın
    |
    */

    'cache' => env('THEME_CACHE', false),

    /*
    |--------------------------------------------------------------------------
    | Auto Register Views
    |--------------------------------------------------------------------------
    |
    | Tema view'lerini otomatik olarak kaydetmek için bu ayarı true yapın
    |
    */

    'auto_register' => true,

    /*
    |--------------------------------------------------------------------------
    | Theme Fallback
    |--------------------------------------------------------------------------
    |
    | Tema dosyası bulunamadığında hangi temaya geri dönüleceği
    |
    */

    'fallback' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    |
    | Sistemde mevcut olan temalar
    |
    */

    'themes' => [
        'default' => [
            'name' => 'Varsayılan Tema',
            'description' => 'Laravel Breeze varsayılan teması',
            'version' => '1.0.0',
            'author' => 'Laravel Team',
            'preview' => 'default/preview.jpg',
            'active' => true,
        ],
        'modern' => [
            'name' => 'Modern Tema',
            'description' => 'Modern ve şık tasarım',
            'version' => '1.0.0',
            'author' => 'NetMarketiniz',
            'preview' => 'modern/preview.jpg',
            'active' => true,
        ],
        'classic' => [
            'name' => 'Klasik Tema',
            'description' => 'Geleneksel ve sade tasarım',
            'version' => '1.0.0',
            'author' => 'NetMarketiniz',
            'preview' => 'classic/preview.jpg',
            'active' => true,
        ],
    ],
];



