<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteAyar;

class SiteAyarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Site ayarlarını tüm view'larda kullanılabilir hale getir
        View::composer('*', function ($view) {
            try {
                $siteAyarlar = SiteAyar::pluck('deger', 'anahtar')->toArray();
                $view->with('siteAyarlar', $siteAyarlar);
            } catch (\Exception $e) {
                // Migration henüz çalışmamış olabilir
                $view->with('siteAyarlar', []);
            }
        });
    }
}
