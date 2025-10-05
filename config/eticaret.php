<?php

return [
    /*
    |--------------------------------------------------------------------------
    | E-Ticaret Platform Ayarları
    |--------------------------------------------------------------------------
    |
    | Desteklenen e-ticaret platformlarının API bilgileri ve ayarları
    |
    */

    'platformlar' => [
        'trendyol' => [
            'name' => 'Trendyol',
            'base_url' => 'https://api.trendyol.com/sapigw',
            'webhook_events' => [
                'ORDER_CREATED',
                'ORDER_CANCELLED',
                'ORDER_SHIPPED',
                'STOCK_UPDATE'
            ],
            'komisyon_orani' => 0.15, // %15
            'minimum_fiyat' => 1.0,
            'maximum_baslik_uzunlugu' => 100,
            'maximum_aciklama_uzunlugu' => 3000,
            'desteklenen_resim_formatlari' => ['jpg', 'jpeg', 'png'],
            'maksimum_resim_boyutu' => 2048, // KB
        ],

        'hepsiburada' => [
            'name' => 'Hepsiburada',
            'base_url' => 'https://listing-external.hepsiburada.com/listings/merchantid',
            'webhook_events' => [
                'OrderUpdate',
                'StockUpdate',
                'ProductUpdate'
            ],
            'komisyon_orani' => 0.12, // %12
            'minimum_fiyat' => 1.0,
            'maximum_baslik_uzunlugu' => 150,
            'maximum_aciklama_uzunlugu' => 5000,
            'desteklenen_resim_formatlari' => ['jpg', 'jpeg', 'png'],
            'maksimum_resim_boyutu' => 5120, // KB
        ],

        'n11' => [
            'name' => 'N11',
            'base_url' => 'https://api.n11.com/ws',
            'webhook_events' => [
                'OrderStatusChanged',
                'ProductStockUpdated'
            ],
            'komisyon_orani' => 0.10, // %10
            'minimum_fiyat' => 0.1,
            'maximum_baslik_uzunlugu' => 100,
            'maximum_aciklama_uzunlugu' => 2000,
            'desteklenen_resim_formatlari' => ['jpg', 'jpeg', 'png', 'gif'],
            'maksimum_resim_boyutu' => 1024, // KB
        ],

        'amazon' => [
            'name' => 'Amazon',
            'base_url' => 'https://sellingpartnerapi-eu.amazon.com',
            'webhook_events' => [
                'ORDER_STATUS_CHANGE',
                'LISTINGS_ITEM_STATUS_CHANGE'
            ],
            'komisyon_orani' => 0.15, // %15
            'minimum_fiyat' => 1.0,
            'maximum_baslik_uzunlugu' => 200,
            'maximum_aciklama_uzunlugu' => 2000,
            'desteklenen_resim_formatlari' => ['jpg', 'jpeg', 'png'],
            'maksimum_resim_boyutu' => 10240, // KB
        ],

        'pazarama' => [
            'name' => 'Pazarama',
            'base_url' => 'https://isortagimapi.pazarama.com',
            'webhook_events' => [
                'ORDER_CREATED',
                'ORDER_UPDATED'
            ],
            'komisyon_orani' => 0.08, // %8
            'minimum_fiyat' => 1.0,
            'maximum_baslik_uzunlugu' => 120,
            'maximum_aciklama_uzunlugu' => 4000,
            'desteklenen_resim_formatlari' => ['jpg', 'jpeg', 'png'],
            'maksimum_resim_boyutu' => 2048, // KB
        ],

        'gittigidiyor' => [
            'name' => 'GittiGidiyor',
            'base_url' => 'https://dev.gittigidiyor.com:8443/listingapi/rldb',
            'webhook_events' => [
                'ORDER_CHANGED',
                'PRODUCT_CHANGED'
            ],
            'komisyon_orani' => 0.13, // %13
            'minimum_fiyat' => 1.0,
            'maximum_baslik_uzunlugu' => 60,
            'maximum_aciklama_uzunlugu' => 50000,
            'desteklenen_resim_formatlari' => ['jpg', 'jpeg', 'png', 'gif'],
            'maksimum_resim_boyutu' => 1024, // KB
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | XML Feed Ayarları
    |--------------------------------------------------------------------------
    |
    | XML feed'lerinin cache süreleri ve diğer ayarları
    |
    */

    'xml' => [
        'cache_suresi' => [
            'urunler' => 3600, // 1 saat
            'stok' => 300,     // 5 dakika
            'fiyat' => 1800,   // 30 dakika
        ],
        'maksimum_urun_sayisi' => 10000,
        'encoding' => 'UTF-8',
        'version' => '1.0',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sipariş Durumları
    |--------------------------------------------------------------------------
    |
    | Sistem genelinde kullanılan sipariş durumları
    |
    */

    'siparis_durumlari' => [
        'yeni' => 'Yeni Sipariş',
        'onaylandi' => 'Onaylandı',
        'hazirlandi' => 'Hazırlandı',
        'kargolandi' => 'Kargoya Verildi',
        'teslim_edildi' => 'Teslim Edildi',
        'iptal_edildi' => 'İptal Edildi',
        'iade_edildi' => 'İade Edildi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ödeme Durumları
    |--------------------------------------------------------------------------
    */

    'odeme_durumlari' => [
        'bekliyor' => 'Ödeme Bekliyor',
        'odendi' => 'Ödendi',
        'iade_edildi' => 'İade Edildi',
        'iptal_edildi' => 'İptal Edildi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Kargo Firmaları
    |--------------------------------------------------------------------------
    */

    'kargo_firmalari' => [
        'yurtici' => 'Yurtiçi Kargo',
        'mng' => 'MNG Kargo',
        'aras' => 'Aras Kargo',
        'ptt' => 'PTT Kargo',
        'ups' => 'UPS Kargo',
        'dhl' => 'DHL',
        'fedex' => 'FedEx',
        'surat' => 'Sürat Kargo',
    ],

    /*
    |--------------------------------------------------------------------------
    | B2B Ayarları
    |--------------------------------------------------------------------------
    */

    'b2b' => [
        'minimum_siparis_tutari' => 100.0,
        'maksimum_siparis_tutari' => 50000.0,
        'varsayilan_bayi_indirim_orani' => 0.10, // %10
        'maksimum_bayi_indirim_orani' => 0.30,   // %30
        'kredi_limiti_varsayilan' => 10000.0,
        'odeme_vadeleri' => [30, 60, 90], // gün
    ],

    /*
    |--------------------------------------------------------------------------
    | Stok Ayarları
    |--------------------------------------------------------------------------
    */

    'stok' => [
        'kritik_stok_seviyesi' => 5,
        'otomatik_stok_guncelleme' => true,
        'stok_senkron_araligi' => 300, // 5 dakika (saniye)
        'sifir_stok_durumu' => 'pasif', // pasif veya aktif
    ],

    /*
    |--------------------------------------------------------------------------
    | Resim Ayarları
    |--------------------------------------------------------------------------
    */

    'resim' => [
        'maksimum_boyut' => 5120, // KB
        'desteklenen_formatlar' => ['jpg', 'jpeg', 'png', 'webp'],
        'thumbnail_boyutlari' => [
            'small' => [150, 150],
            'medium' => [300, 300],
            'large' => [800, 800],
        ],
        'kalite' => 85, // JPEG kalitesi
    ],

    /*
    |--------------------------------------------------------------------------
    | API Rate Limiting
    |--------------------------------------------------------------------------
    */

    'rate_limiting' => [
        'genel' => [
            'istek_sayisi' => 1000,
            'sure' => 3600, // 1 saat
        ],
        'platform_specific' => [
            'trendyol' => [
                'istek_sayisi' => 100,
                'sure' => 60, // 1 dakika
            ],
            'hepsiburada' => [
                'istek_sayisi' => 200,
                'sure' => 60,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Senkronizasyon Ayarları
    |--------------------------------------------------------------------------
    */

    'senkronizasyon' => [
        'otomatik_senkron' => true,
        'senkron_araliklari' => [
            'urun' => 3600,    // 1 saat
            'stok' => 300,     // 5 dakika
            'fiyat' => 1800,   // 30 dakika
            'siparis' => 60,   // 1 dakika
        ],
        'maksimum_yeniden_deneme' => 3,
        'hata_bekleme_suresi' => 300, // 5 dakika
    ],
];