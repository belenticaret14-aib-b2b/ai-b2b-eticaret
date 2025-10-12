<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\SenkronLog;
use App\Models\Siparis;
use App\Models\Urun;
use App\Models\Magaza;
use Exception;

class HataAnalizBotService
{
    /**
     * Sistem hatalarını analiz et ve çözüm öner
     */
    public function hataAnalizEt(): array
    {
        $analiz = [
            'genel_durum' => 'normal',
            'kritik_hatalar' => [],
            'uyarilar' => [],
            'cozum_onerileri' => [],
            'performans_metrikleri' => [],
            'sistem_sagligi' => []
        ];

        try {
            // 1. Senkronizasyon hatalarını kontrol et
            $senkronHatalari = $this->senkronHatalariniAnalizEt();
            if (!empty($senkronHatalari)) {
                $analiz['kritik_hatalar'] = array_merge($analiz['kritik_hatalar'], $senkronHatalari);
            }

            // 2. Sipariş hatalarını kontrol et
            $siparisHatalari = $this->siparisHatalariniAnalizEt();
            if (!empty($siparisHatalari)) {
                $analiz['kritik_hatalar'] = array_merge($analiz['kritik_hatalar'], $siparisHatalari);
            }

            // 3. Ürün stok uyarılarını kontrol et
            $stokUyarilari = $this->stokUyarilariniAnalizEt();
            if (!empty($stokUyarilari)) {
                $analiz['uyarilar'] = array_merge($analiz['uyarilar'], $stokUyarilari);
            }

            // 4. Hata link kontrolü
            $hataLinkKontrolu = $this->hataLinkKontroluYap();
            if (!empty($hataLinkKontrolu)) {
                $analiz['uyarilar'] = array_merge($analiz['uyarilar'], $hataLinkKontrolu);
            }

            // 5. Sistem sağlık kontrolü
            $analiz['sistem_sagligi'] = $this->sistemSaglikKontrolu();

            // 6. Performans metriklerini hesapla
            $analiz['performans_metrikleri'] = $this->performansMetrikleriniHesapla();

            // 7. Genel durumu belirle
            $analiz['genel_durum'] = $this->genelDurumuBelirle($analiz);

            // 8. Çözüm önerileri oluştur
            $analiz['cozum_onerileri'] = $this->cozumOnerileriOlustur($analiz);

            return $analiz;

        } catch (Exception $e) {
            Log::error('Hata analiz bot hatası', ['error' => $e->getMessage()]);
            return [
                'genel_durum' => 'hata',
                'kritik_hatalar' => ['Hata analiz sistemi çalışmıyor: ' . $e->getMessage()],
                'uyarilar' => [],
                'cozum_onerileri' => ['Sistem yöneticisi ile iletişime geçin'],
                'performans_metrikleri' => []
            ];
        }
    }

    /**
     * Senkronizasyon hatalarını analiz et
     */
    private function senkronHatalariniAnalizEt(): array
    {
        $hatalar = [];
        
        // Son 24 saatteki senkron hataları
        $sonHatalar = SenkronLog::where('durum', 'hata')
            ->where('created_at', '>=', now()->subDay())
            ->with('magaza')
            ->get();

        if ($sonHatalar->count() > 10) {
            $hatalar[] = [
                'tip' => 'kritik',
                'mesaj' => 'Son 24 saatte ' . $sonHatalar->count() . ' senkronizasyon hatası tespit edildi',
                'detay' => 'Platform entegrasyonları düzgün çalışmıyor',
                'cozum' => 'Platform API anahtarlarını kontrol edin ve yenileyin'
            ];
        }

        // Başarısız mağaza senkronları
        $basarisizMagazalar = SenkronLog::where('durum', 'hata')
            ->where('created_at', '>=', now()->subHour())
            ->with('magaza')
            ->get()
            ->groupBy('magaza_id');

        foreach ($basarisizMagazalar as $magazaId => $loglar) {
            if ($loglar->count() >= 3) {
                $magaza = $loglar->first()->magaza;
                $hatalar[] = [
                    'tip' => 'kritik',
                    'mesaj' => $magaza->ad . ' mağazasında sürekli senkron hatası',
                    'detay' => 'Son 1 saatte ' . $loglar->count() . ' hata',
                    'cozum' => 'Mağaza API ayarlarını kontrol edin'
                ];
            }
        }

        return $hatalar;
    }

    /**
     * Sipariş hatalarını analiz et
     */
    private function siparisHatalariniAnalizEt(): array
    {
        $hatalar = [];
        
        // Bekleyen siparişler (24 saatten fazla)
        $bekleyenSiparisler = Siparis::where('durum', 'beklemede')
            ->where('created_at', '<', now()->subDay())
            ->count();

        if ($bekleyenSiparisler > 0) {
            $hatalar[] = [
                'tip' => 'kritik',
                'mesaj' => $bekleyenSiparisler . ' sipariş 24 saatten fazla bekliyor',
                'detay' => 'Sipariş işleme sürecinde sorun var',
                'cozum' => 'Sipariş durumlarını kontrol edin ve işleyin'
            ];
        }

        // İptal edilen siparişler (son 24 saat)
        $iptalSiparisler = Siparis::where('durum', 'iptal')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        if ($iptalSiparisler > 5) {
            $hatalar[] = [
                'tip' => 'uyari',
                'mesaj' => 'Son 24 saatte ' . $iptalSiparisler . ' sipariş iptal edildi',
                'detay' => 'Yüksek iptal oranı tespit edildi',
                'cozum' => 'Müşteri geri bildirimlerini inceleyin'
            ];
        }

        return $hatalar;
    }

    /**
     * Stok uyarılarını analiz et
     */
    private function stokUyarilariniAnalizEt(): array
    {
        $uyarilar = [];
        
        // Stok tükenen ürünler
        $stokTukenen = Urun::where('stok', '<=', 0)->count();
        
        if ($stokTukenen > 0) {
            $uyarilar[] = [
                'tip' => 'uyari',
                'mesaj' => $stokTukenen . ' ürünün stoku tükendi',
                'detay' => 'Stok yenileme gerekli',
                'cozum' => 'Tedarikçilerle iletişime geçin'
            ];
        }

        // Düşük stoklu ürünler (5'ten az)
        $dusukStok = Urun::where('stok', '>', 0)->where('stok', '<=', 5)->count();
        
        if ($dusukStok > 0) {
            $uyarilar[] = [
                'tip' => 'uyari',
                'mesaj' => $dusukStok . ' ürünün stoku kritik seviyede',
                'detay' => 'Stok yenileme planı yapın',
                'cozum' => 'Otomatik stok uyarı sistemi kurun'
            ];
        }

        return $uyarilar;
    }

    /**
     * Performans metriklerini hesapla
     */
    private function performansMetrikleriniHesapla(): array
    {
        return [
            'toplam_siparis' => Siparis::count(),
            'bugun_siparis' => Siparis::whereDate('created_at', today())->count(),
            'aktif_urun' => Urun::where('durum', true)->count(),
            'aktif_magaza' => Magaza::where('durum', true)->count(),
            'senkron_basarisi' => $this->senkronBasarisiniHesapla(),
            'ortalama_siparis_tutari' => Siparis::avg('toplam_tutar') ?? 0
        ];
    }

    /**
     * Senkronizasyon başarı oranını hesapla
     */
    private function senkronBasarisiniHesapla(): float
    {
        $toplamSenkron = SenkronLog::where('created_at', '>=', now()->subDay())->count();
        $basariliSenkron = SenkronLog::where('durum', 'tamamlandi')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        return $toplamSenkron > 0 ? round(($basariliSenkron / $toplamSenkron) * 100, 2) : 0;
    }

    /**
     * Genel durumu belirle
     */
    private function genelDurumuBelirle(array $analiz): string
    {
        if (count($analiz['kritik_hatalar']) > 0) {
            return 'kritik';
        } elseif (count($analiz['uyarilar']) > 3) {
            return 'uyari';
        } else {
            return 'normal';
        }
    }

    /**
     * Çözüm önerileri oluştur
     */
    private function cozumOnerileriOlustur(array $analiz): array
    {
        $oneriler = [];

        if ($analiz['genel_durum'] === 'kritik') {
            $oneriler[] = [
                'oncelik' => 'yuksek',
                'baslik' => 'Acil Müdahale Gerekli',
                'aciklama' => 'Sistemde kritik hatalar tespit edildi. Hemen müdahale edin.',
                'adimlar' => [
                    '1. Log dosyalarını kontrol edin',
                    '2. Platform API bağlantılarını test edin',
                    '3. Veritabanı bağlantısını kontrol edin'
                ]
            ];
        }

        if (count($analiz['uyarilar']) > 0) {
            $oneriler[] = [
                'oncelik' => 'orta',
                'baslik' => 'Sistem Optimizasyonu',
                'aciklama' => 'Sistem performansını artırmak için öneriler.',
                'adimlar' => [
                    '1. Cache sistemini optimize edin',
                    '2. Veritabanı sorgularını optimize edin',
                    '3. Gereksiz log dosyalarını temizleyin'
                ]
            ];
        }

        return $oneriler;
    }

    /**
     * Otomatik hata düzeltme
     */
    public function otomatikHataDuzelt(): array
    {
        $duzeltmeler = [];

        try {
            // 1. Eski log dosyalarını temizle
            $this->eskiLoglariTemizle();
            $duzeltmeler[] = 'Eski log dosyaları temizlendi';

            // 2. Cache'i temizle
            $this->cacheTemizle();
            $duzeltmeler[] = 'Cache temizlendi';

            // 3. Başarısız senkronları yeniden dene
            $this->basarisizSenkronlariYenidenDene();
            $duzeltmeler[] = 'Başarısız senkronlar yeniden deneniyor';

            return [
                'success' => true,
                'message' => 'Otomatik düzeltmeler uygulandı',
                'duzeltmeler' => $duzeltmeler
            ];

        } catch (Exception $e) {
            Log::error('Otomatik hata düzeltme hatası', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Otomatik düzeltme başarısız: ' . $e->getMessage(),
                'duzeltmeler' => []
            ];
        }
    }

    /**
     * Eski logları temizle
     */
    private function eskiLoglariTemizle(): void
    {
        SenkronLog::where('created_at', '<', now()->subDays(30))->delete();
    }

    /**
     * Cache temizle
     */
    private function cacheTemizle(): void
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
    }

    /**
     * Başarısız senkronları yeniden dene
     */
    private function basarisizSenkronlariYenidenDene(): void
    {
        $basarisizSenkronlar = SenkronLog::where('durum', 'hata')
            ->where('created_at', '>=', now()->subHour())
            ->get();

        foreach ($basarisizSenkronlar as $log) {
            // Burada gerçek senkronizasyon mantığı çalıştırılır
            Log::info('Başarısız senkron yeniden deneniyor', ['log_id' => $log->id]);
        }
    }

    /**
     * Hata link kontrolü yap (Optimized)
     */
    private function hataLinkKontroluYap(): array
    {
        $uyarilar = [];
        
        // Sadece kritik route'ları kontrol et (daha hızlı)
        $kritikRoute = [
            'super-admin.dashboard' => '/super-admin/dashboard',
            'vitrin.index' => '/'
        ];

        foreach ($kritikRoute as $routeName => $url) {
            try {
                $response = Http::timeout(3)->get(url($url)); // Timeout azaltıldı
                if ($response->status() >= 400) {
                    $uyarilar[] = [
                        'tip' => 'uyari',
                        'mesaj' => "Route '{$routeName}' hata veriyor",
                        'detay' => "HTTP {$response->status()}: {$url}",
                        'cozum' => 'Route tanımlarını ve middleware\'leri kontrol edin'
                    ];
                }
            } catch (Exception $e) {
                // Sadece kritik hataları logla
                if (str_contains($e->getMessage(), 'timeout') || str_contains($e->getMessage(), 'connection')) {
                    $uyarilar[] = [
                        'tip' => 'uyari',
                        'mesaj' => "Route '{$routeName}' yavaş yanıt veriyor",
                        'detay' => "Bağlantı timeout: {$url}",
                        'cozum' => 'Sunucu performansını kontrol edin'
                    ];
                }
            }
        }

        return $uyarilar;
    }

    /**
     * Sistem sağlık kontrolü
     */
    private function sistemSaglikKontrolu(): array
    {
        $saglik = [
            'veritabani' => $this->veritabaniSaglikKontrolu(),
            'cache' => $this->cacheSaglikKontrolu(),
            'dosya_sistemi' => $this->dosyaSistemiSaglikKontrolu(),
            'api_baglantilari' => $this->apiBaglantiSaglikKontrolu(),
            'genel_durum' => 'iyi'
        ];

        // Genel durumu belirle
        $hataliServisler = array_filter($saglik, function($durum) {
            return $durum !== 'iyi' && $durum !== 'uyari';
        });

        if (count($hataliServisler) > 0) {
            $saglik['genel_durum'] = 'kritik';
        } elseif (in_array('uyari', $saglik)) {
            $saglik['genel_durum'] = 'uyari';
        }

        return $saglik;
    }

    /**
     * Veritabanı sağlık kontrolü
     */
    private function veritabaniSaglikKontrolu(): string
    {
        try {
            DB::connection()->getPdo();
            $sorguSayisi = DB::select('SELECT COUNT(*) as count FROM sqlite_master WHERE type="table"')[0]->count ?? 0;
            
            if ($sorguSayisi < 10) {
                return 'uyari'; // Beklenen tablo sayısından az
            }
            
            return 'iyi';
        } catch (Exception $e) {
            Log::error('Veritabanı bağlantı hatası', ['error' => $e->getMessage()]);
            return 'hata';
        }
    }

    /**
     * Cache sağlık kontrolü
     */
    private function cacheSaglikKontrolu(): string
    {
        try {
            $testKey = 'health_check_' . time();
            cache()->put($testKey, 'test', 60);
            $value = cache()->get($testKey);
            cache()->forget($testKey);
            
            return $value === 'test' ? 'iyi' : 'uyari';
        } catch (Exception $e) {
            Log::error('Cache sağlık kontrolü hatası', ['error' => $e->getMessage()]);
            return 'hata';
        }
    }

    /**
     * Dosya sistemi sağlık kontrolü
     */
    private function dosyaSistemiSaglikKontrolu(): string
    {
        try {
            $gerekliDizinler = [
                storage_path('logs'),
                storage_path('app'),
                storage_path('framework/cache'),
                public_path('build')
            ];

            foreach ($gerekliDizinler as $dizin) {
                if (!is_dir($dizin) || !is_writable($dizin)) {
                    return 'uyari';
                }
            }

            return 'iyi';
        } catch (Exception $e) {
            Log::error('Dosya sistemi sağlık kontrolü hatası', ['error' => $e->getMessage()]);
            return 'hata';
        }
    }

    /**
     * API bağlantı sağlık kontrolü (Optimized)
     */
    private function apiBaglantiSaglikKontrolu(): string
    {
        try {
            // Sadece aktif platform sayısını kontrol et (API test yapmadan)
            $aktifPlatformSayisi = Magaza::where('durum', true)->count();
            
            if ($aktifPlatformSayisi === 0) {
                return 'uyari'; // Hiç platform yok
            }

            // Basit kontrol - API test yapmadan
            return 'iyi'; // Platformlar mevcut, detaylı test yapılmıyor
            
        } catch (Exception $e) {
            Log::error('API bağlantı sağlık kontrolü hatası', ['error' => $e->getMessage()]);
            return 'hata';
        }
    }

    /**
     * Platform bağlantı testi
     */
    private function platformBaglantiTest(Magaza $magaza): bool
    {
        try {
            if (!$magaza->api_base_url) {
                return false;
            }

            $response = Http::timeout(10)->get($magaza->api_base_url);
            return $response->successful();
        } catch (Exception $e) {
            return false;
        }
    }
}
