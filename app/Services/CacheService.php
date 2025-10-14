<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Kategori;
use App\Models\Marka;
use App\Models\SiteAyar;
use App\Models\Urun;

/**
 * Cache Yönetim Servisi
 * 
 * Performans için kritik verileri cache'ler.
 * Cache süreleri ve stratejileri bu servis üzerinden yönetilir.
 */
class CacheService
{
    /**
     * Cache süreleri (saniye)
     */
    const CACHE_TTL_SHORT = 600;      // 10 dakika
    const CACHE_TTL_MEDIUM = 3600;    // 1 saat
    const CACHE_TTL_LONG = 7200;      // 2 saat
    const CACHE_TTL_VERY_LONG = 86400; // 24 saat

    /**
     * Kategori ağacını cache'den getir veya oluştur
     */
    public static function kategoriler(): \Illuminate\Support\Collection
    {
        return Cache::remember('kategoriler_agaci', self::CACHE_TTL_LONG, function () {
            return Kategori::with(['altKategoriler' => function($query) {
                    $query->where('durum', true)->orderBy('sira');
                }])
                ->whereNull('ust_kategori_id')
                ->where('durum', true)
                ->orderBy('sira')
                ->get();
        });
    }

    /**
     * Tüm kategorileri (düz liste) cache'den getir
     */
    public static function tumKategoriler(): \Illuminate\Support\Collection
    {
        return Cache::remember('tumKategoriler', self::CACHE_TTL_LONG, function () {
            return Kategori::where('durum', true)
                ->orderBy('ad')
                ->get(['id', 'ad', 'slug', 'ust_kategori_id']);
        });
    }

    /**
     * Marka listesini cache'den getir
     */
    public static function markalar(): \Illuminate\Support\Collection
    {
        return Cache::remember('markalar', self::CACHE_TTL_LONG, function () {
            return Marka::where('durum', true)
                ->orderBy('ad')
                ->get(['id', 'ad', 'slug', 'logo']);
        });
    }

    /**
     * Site ayarlarını cache'den getir
     */
    public static function siteAyarlari(): array
    {
        return Cache::remember('site_ayarlari', self::CACHE_TTL_VERY_LONG, function () {
            return SiteAyar::pluck('deger', 'anahtar')->toArray();
        });
    }

    /**
     * Belirli bir site ayarını getir
     */
    public static function siteAyari(string $anahtar, $default = null)
    {
        $ayarlar = self::siteAyarlari();
        return $ayarlar[$anahtar] ?? $default;
    }

    /**
     * Vitrin için popüler ürünleri getir
     */
    public static function populerUrunler(int $limit = 10): \Illuminate\Support\Collection
    {
        return Cache::remember("populer_urunler_{$limit}", self::CACHE_TTL_MEDIUM, function () use ($limit) {
            return Urun::with(['kategori', 'marka'])
                ->where('durum', true)
                ->where('stok', '>', 0)
                ->orderBy('goruntulenme', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Yeni ürünleri getir
     */
    public static function yeniUrunler(int $limit = 10): \Illuminate\Support\Collection
    {
        return Cache::remember("yeni_urunler_{$limit}", self::CACHE_TTL_SHORT, function () use ($limit) {
            return Urun::with(['kategori', 'marka'])
                ->where('durum', true)
                ->where('stok', '>', 0)
                ->latest('id')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * İndirimli ürünleri getir
     */
    public static function indirimliler(int $limit = 10): \Illuminate\Support\Collection
    {
        return Cache::remember("indirimli_urunler_{$limit}", self::CACHE_TTL_MEDIUM, function () use ($limit) {
            return Urun::with(['kategori', 'marka'])
                ->where('durum', true)
                ->where('stok', '>', 0)
                ->whereNotNull('indirimli_fiyat')
                ->where('indirimli_fiyat', '>', 0)
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Kategori bazında ürün sayılarını getir
     */
    public static function kategoriUrunSayilari(): array
    {
        return Cache::remember('kategori_urun_sayilari', self::CACHE_TTL_MEDIUM, function () {
            return Urun::selectRaw('kategori_id, COUNT(*) as sayi')
                ->where('durum', true)
                ->groupBy('kategori_id')
                ->pluck('sayi', 'kategori_id')
                ->toArray();
        });
    }

    /**
     * Marka bazında ürün sayılarını getir
     */
    public static function markaUrunSayilari(): array
    {
        return Cache::remember('marka_urun_sayilari', self::CACHE_TTL_MEDIUM, function () {
            return Urun::selectRaw('marka_id, COUNT(*) as sayi')
                ->where('durum', true)
                ->groupBy('marka_id')
                ->pluck('sayi', 'marka_id')
                ->toArray();
        });
    }

    /**
     * Kategori ile ilgili tüm cache'leri temizle
     */
    public static function clearKategoriCache(): void
    {
        Cache::forget('kategoriler_agaci');
        Cache::forget('tumKategoriler');
        Cache::forget('kategori_urun_sayilari');
    }

    /**
     * Marka ile ilgili tüm cache'leri temizle
     */
    public static function clearMarkaCache(): void
    {
        Cache::forget('markalar');
        Cache::forget('marka_urun_sayilari');
    }

    /**
     * Site ayarları cache'ini temizle
     */
    public static function clearSiteAyarlariCache(): void
    {
        Cache::forget('site_ayarlari');
    }

    /**
     * Ürün cache'lerini temizle
     */
    public static function clearUrunCache(): void
    {
        // Popüler ürünler
        Cache::flush(); // Geçici çözüm, daha sonra daha spesifik yapılabilir
        
        // Veya belirli pattern'leri temizle:
        // Cache::tags(['urunler'])->flush();
    }

    /**
     * Tüm cache'i temizle
     */
    public static function clearAll(): void
    {
        Cache::flush();
    }

    /**
     * Cache istatistiklerini getir
     */
    public static function stats(): array
    {
        $stats = [];
        
        $cacheKeys = [
            'kategoriler_agaci',
            'tumKategoriler',
            'markalar',
            'site_ayarlari',
            'populer_urunler_10',
            'yeni_urunler_10',
            'indirimli_urunler_10',
            'kategori_urun_sayilari',
            'marka_urun_sayilari',
        ];
        
        foreach ($cacheKeys as $key) {
            $stats[$key] = Cache::has($key) ? 'CACHED' : 'EMPTY';
        }
        
        return $stats;
    }

    /**
     * Cache'i ön ısıt (warm-up)
     * 
     * Uygulama başlangıcında veya deploy sonrası çalıştırılabilir.
     */
    public static function warmUp(): array
    {
        $warmed = [];
        
        try {
            self::kategoriler();
            $warmed[] = 'kategoriler';
        } catch (\Exception $e) {
            $warmed[] = 'kategoriler:ERROR';
        }
        
        try {
            self::markalar();
            $warmed[] = 'markalar';
        } catch (\Exception $e) {
            $warmed[] = 'markalar:ERROR';
        }
        
        try {
            self::siteAyarlari();
            $warmed[] = 'site_ayarlari';
        } catch (\Exception $e) {
            $warmed[] = 'site_ayarlari:ERROR';
        }
        
        try {
            self::populerUrunler();
            $warmed[] = 'populer_urunler';
        } catch (\Exception $e) {
            $warmed[] = 'populer_urunler:ERROR';
        }
        
        try {
            self::yeniUrunler();
            $warmed[] = 'yeni_urunler';
        } catch (\Exception $e) {
            $warmed[] = 'yeni_urunler:ERROR';
        }
        
        return $warmed;
    }
}




