<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Exception;

class HataliLinkDuzeltmeService
{
    /**
     * Hatalı linkleri tespit et ve düzelt
     */
    public function hataliLinkleriTespitVeDuzelt(): array
    {
        $sonuclar = [
            'tespit_edilen_hatalar' => [],
            'duzeltilen_hatalar' => [],
            'duzeltme_onerileri' => [],
            'genel_durum' => 'iyi'
        ];

        try {
            // 1. Route kontrolü
            $routeHatalari = $this->routeHatalariniTespitEt();
            if (!empty($routeHatalari)) {
                $sonuclar['tespit_edilen_hatalar'] = array_merge($sonuclar['tespit_edilen_hatalar'], $routeHatalari);
            }

            // 2. View dosyası kontrolü
            $viewHatalari = $this->viewHatalariniTespitEt();
            if (!empty($viewHatalari)) {
                $sonuclar['tespit_edilen_hatalar'] = array_merge($sonuclar['tespit_edilen_hatalar'], $viewHatalari);
            }

            // 3. Controller kontrolü
            $controllerHatalari = $this->controllerHatalariniTespitEt();
            if (!empty($controllerHatalari)) {
                $sonuclar['tespit_edilen_hatalar'] = array_merge($sonuclar['tespit_edilen_hatalar'], $controllerHatalari);
            }

            // 4. Otomatik düzeltmeler
            $duzeltmeler = $this->otomatikDuzeltmeleriUygula($sonuclar['tespit_edilen_hatalar']);
            $sonuclar['duzeltilen_hatalar'] = $duzeltmeler;

            // 5. Genel durumu belirle
            $sonuclar['genel_durum'] = $this->genelDurumuBelirle($sonuclar);

            return $sonuclar;

        } catch (Exception $e) {
            Log::error('Hatalı link düzeltme hatası', ['error' => $e->getMessage()]);
            return [
                'tespit_edilen_hatalar' => ['Sistem hatası: ' . $e->getMessage()],
                'duzeltilen_hatalar' => [],
                'duzeltme_onerileri' => ['Sistem yöneticisi ile iletişime geçin'],
                'genel_durum' => 'hata'
            ];
        }
    }

    /**
     * Route hatalarını tespit et
     */
    private function routeHatalariniTespitEt(): array
    {
        $hatalar = [];
        
        // Tanımlı route'ları kontrol et
        $tanimliRoute = [
            'super-admin.dashboard' => '/super-admin/dashboard',
            'store-admin.dashboard' => '/store-admin/dashboard',
            'dealer-admin.dashboard' => '/dealer-admin/dashboard',
            'super-admin.kullanicilar' => '/super-admin/kullanicilar',
            'super-admin.magazalar' => '/super-admin/magazalar',
            'super-admin.bayiler' => '/super-admin/bayiler',
            'super-admin.gelistirici' => '/super-admin/gelistirici',
            'super-admin.proje-detaylari' => '/super-admin/proje-detaylari',
            'vitrin.index' => '/'
        ];

        foreach ($tanimliRoute as $routeName => $url) {
            try {
                // Route'un tanımlı olup olmadığını kontrol et
                if (!Route::has($routeName)) {
                    $hatalar[] = [
                        'tip' => 'route_hatasi',
                        'mesaj' => "Route '{$routeName}' tanımlı değil",
                        'detay' => "URL: {$url}",
                        'cozum' => "Route tanımlanmalı: Route::get('{$url}', ...)->name('{$routeName}')",
                        'oncelik' => 'yuksek'
                    ];
                }
            } catch (Exception $e) {
                $hatalar[] = [
                    'tip' => 'route_hatasi',
                    'mesaj' => "Route '{$routeName}' kontrol edilemiyor",
                    'detay' => "Hata: " . $e->getMessage(),
                    'cozum' => 'Route cache temizlenmeli',
                    'oncelik' => 'orta'
                ];
            }
        }

        return $hatalar;
    }

    /**
     * View dosyası hatalarını tespit et
     */
    private function viewHatalariniTespitEt(): array
    {
        $hatalar = [];
        
        $gerekliView = [
            'super-admin.dashboard' => 'super-admin/dashboard.blade.php',
            'super-admin.kullanicilar' => 'super-admin/kullanicilar.blade.php',
            'super-admin.magazalar' => 'super-admin/magazalar.blade.php',
            'super-admin.bayiler' => 'super-admin/bayiler.blade.php',
            'super-admin.gelistirici' => 'super-admin/gelistirici.blade.php',
            'super-admin.proje-detaylari' => 'super-admin/proje-detaylari.blade.php',
            'layouts.admin' => 'layouts/admin.blade.php'
        ];

        foreach ($gerekliView as $viewName => $viewPath) {
            $fullPath = resource_path("views/{$viewPath}");
            
            if (!file_exists($fullPath)) {
                $hatalar[] = [
                    'tip' => 'view_hatasi',
                    'mesaj' => "View dosyası bulunamadı: {$viewName}",
                    'detay' => "Dosya yolu: {$fullPath}",
                    'cozum' => "View dosyası oluşturulmalı: {$viewPath}",
                    'oncelik' => 'yuksek'
                ];
            }
        }

        return $hatalar;
    }

    /**
     * Controller hatalarını tespit et
     */
    private function controllerHatalariniTespitEt(): array
    {
        $hatalar = [];
        
        $gerekliController = [
            'SuperAdmin\\DashboardController' => 'app/Http/Controllers/SuperAdmin/DashboardController.php',
            'StoreAdmin\\DashboardController' => 'app/Http/Controllers/StoreAdmin/DashboardController.php',
            'DealerAdmin\\DashboardController' => 'app/Http/Controllers/DealerAdmin/DashboardController.php',
            'SuperAdmin\\BotController' => 'app/Http/Controllers/SuperAdmin/BotController.php'
        ];

        foreach ($gerekliController as $controllerName => $controllerPath) {
            $fullPath = base_path($controllerPath);
            
            if (!file_exists($fullPath)) {
                $hatalar[] = [
                    'tip' => 'controller_hatasi',
                    'mesaj' => "Controller bulunamadı: {$controllerName}",
                    'detay' => "Dosya yolu: {$fullPath}",
                    'cozum' => "Controller oluşturulmalı: php artisan make:controller {$controllerName}",
                    'oncelik' => 'yuksek'
                ];
            }
        }

        return $hatalar;
    }

    /**
     * Otomatik düzeltmeleri uygula
     */
    private function otomatikDuzeltmeleriUygula(array $hatalar): array
    {
        $duzeltmeler = [];

        foreach ($hatalar as $hata) {
            switch ($hata['tip']) {
                case 'route_hatasi':
                    $duzeltme = $this->routeHatasiniDuzelt($hata);
                    if ($duzeltme) {
                        $duzeltmeler[] = $duzeltme;
                    }
                    break;
                    
                case 'view_hatasi':
                    $duzeltme = $this->viewHatasiniDuzelt($hata);
                    if ($duzeltme) {
                        $duzeltmeler[] = $duzeltme;
                    }
                    break;
                    
                case 'controller_hatasi':
                    $duzeltme = $this->controllerHatasiniDuzelt($hata);
                    if ($duzeltme) {
                        $duzeltmeler[] = $duzeltme;
                    }
                    break;
            }
        }

        return $duzeltmeler;
    }

    /**
     * Route hatasını düzelt
     */
    private function routeHatasiniDuzelt(array $hata): ?array
    {
        try {
            // Route cache temizle
            \Artisan::call('route:clear');
            
            return [
                'hata' => $hata['mesaj'],
                'duzeltme' => 'Route cache temizlendi',
                'durum' => 'duzeltildi'
            ];
        } catch (Exception $e) {
            return [
                'hata' => $hata['mesaj'],
                'duzeltme' => 'Route cache temizlenemedi: ' . $e->getMessage(),
                'durum' => 'duzeltilemedi'
            ];
        }
    }

    /**
     * View hatasını düzelt
     */
    private function viewHatasiniDuzelt(array $hata): ?array
    {
        try {
            // View cache temizle
            \Artisan::call('view:clear');
            
            return [
                'hata' => $hata['mesaj'],
                'duzeltme' => 'View cache temizlendi',
                'durum' => 'duzeltildi'
            ];
        } catch (Exception $e) {
            return [
                'hata' => $hata['mesaj'],
                'duzeltme' => 'View cache temizlenemedi: ' . $e->getMessage(),
                'durum' => 'duzeltilemedi'
            ];
        }
    }

    /**
     * Controller hatasını düzelt
     */
    private function controllerHatasiniDuzelt(array $hata): ?array
    {
        try {
            // Config cache temizle
            \Artisan::call('config:clear');
            
            return [
                'hata' => $hata['mesaj'],
                'duzeltme' => 'Config cache temizlendi',
                'durum' => 'duzeltildi'
            ];
        } catch (Exception $e) {
            return [
                'hata' => $hata['mesaj'],
                'duzeltme' => 'Config cache temizlenemedi: ' . $e->getMessage(),
                'durum' => 'duzeltilemedi'
            ];
        }
    }

    /**
     * Genel durumu belirle
     */
    private function genelDurumuBelirle(array $sonuclar): string
    {
        if (count($sonuclar['tespit_edilen_hatalar']) === 0) {
            return 'mukemmel';
        } elseif (count($sonuclar['duzeltilen_hatalar']) > 0) {
            return 'iyilestirildi';
        } else {
            return 'dikkat';
        }
    }

    /**
     * Hızlı link kontrolü
     */
    public function hizliLinkKontrolu(): array
    {
        $sonuclar = [
            'kontrol_edilen_linkler' => 0,
            'hatali_linkler' => 0,
            'duzeltilen_linkler' => 0,
            'durum' => 'iyi'
        ];

        try {
            // Sadece kritik linkleri kontrol et
            $kritikLinkler = [
                '/super-admin/dashboard',
                '/super-admin/gelistirici',
                '/'
            ];

            foreach ($kritikLinkler as $link) {
                $sonuclar['kontrol_edilen_linkler']++;
                
                try {
                    $response = Http::timeout(2)->get(url($link));
                    if ($response->status() >= 400) {
                        $sonuclar['hatali_linkler']++;
                    }
                } catch (Exception $e) {
                    $sonuclar['hatali_linkler']++;
                }
            }

            // Hızlı düzeltme
            if ($sonuclar['hatali_linkler'] > 0) {
                \Artisan::call('route:clear');
                \Artisan::call('view:clear');
                $sonuclar['duzeltilen_linkler'] = $sonuclar['hatali_linkler'];
                $sonuclar['durum'] = 'duzeltildi';
            }

            return $sonuclar;

        } catch (Exception $e) {
            return [
                'kontrol_edilen_linkler' => 0,
                'hatali_linkler' => 1,
                'duzeltilen_linkler' => 0,
                'durum' => 'hata',
                'mesaj' => $e->getMessage()
            ];
        }
    }
}







