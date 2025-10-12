<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UrunController;
use App\Http\Controllers\Api\V1\SepetController;
use App\Http\Controllers\Api\V1\SiparisController;
use App\Http\Controllers\Api\V1\KullaniciController;
use App\Http\Controllers\Api\V1\MagazaController;
use App\Http\Controllers\Api\V1\BayiController;
use App\Http\Controllers\Api\V1\XmlController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API Routes (B2C)
Route::prefix('v1')->group(function () {
    // Ürün API'leri
    Route::get('/urunler', [UrunController::class, 'index']);
    Route::get('/urun/{urun}', [UrunController::class, 'show']);
    Route::get('/urunler/arama', [UrunController::class, 'arama']);
    Route::get('/urunler/kategori/{kategori}', [UrunController::class, 'kategoriUrunleri']);
    
    // Sepet API'leri (Session-based)
    Route::post('/sepet/ekle', [SepetController::class, 'ekle']);
    Route::get('/sepet', [SepetController::class, 'index']);
    Route::put('/sepet/guncelle', [SepetController::class, 'guncelle']);
    Route::delete('/sepet/sil', [SepetController::class, 'sil']);
    Route::delete('/sepet/bosalt', [SepetController::class, 'bosalt']);
    
    // XML Feed API'leri
    Route::get('/xml/urunler', [XmlController::class, 'urunlerXml']);
    Route::get('/xml/stok', [XmlController::class, 'stokXml']);
    Route::get('/xml/fiyat', [XmlController::class, 'fiyatXml']);
});

// B2B API Routes (Authentication Required)
Route::prefix('v1/b2b')->middleware(['auth:sanctum', 'bayi'])->group(function () {
    // Bayi Özel Ürün API'leri
    Route::get('/urunler', [BayiController::class, 'urunler']);
    Route::get('/urun/{urun}/bayi-fiyat', [BayiController::class, 'bayiFiyat']);
    Route::get('/kampanyalar', [BayiController::class, 'kampanyalar']);
    
    // Toplu Sipariş API'leri
    Route::post('/siparis/toplu', [SiparisController::class, 'topluSiparis']);
    Route::get('/siparisler', [SiparisController::class, 'bayiSiparisleri']);
    Route::get('/siparis/{siparis}', [SiparisController::class, 'show']);
    
    // Bayi Profil API'leri
    Route::get('/profil', [BayiController::class, 'profil']);
    Route::put('/profil', [BayiController::class, 'profilGuncelle']);
    Route::get('/bakiye', [BayiController::class, 'bakiye']);
    Route::get('/cari-hesap', [BayiController::class, 'cariHesap']);
});

// Admin API Routes
Route::prefix('v1/admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    // Ürün Yönetimi
    Route::apiResource('urunler', UrunController::class);
    Route::post('/urunler/toplu-guncelleme', [UrunController::class, 'topluGuncelleme']);
    Route::post('/urunler/excel-import', [UrunController::class, 'excelImport']);
    
    // Mağaza Entegrasyonları
    Route::apiResource('magazalar', MagazaController::class);
    Route::post('/magaza/{magaza}/urun-esitle', [MagazaController::class, 'urunEsitle']);
    Route::post('/magaza/{magaza}/stok-senkronize', [MagazaController::class, 'stokSenkronize']);
    Route::post('/magaza/{magaza}/fiyat-senkronize', [MagazaController::class, 'fiyatSenkronize']);
    
    // XML/API Entegrasyonları
    Route::post('/xml/import', [XmlController::class, 'import']);
    Route::get('/xml/export', [XmlController::class, 'export']);
    Route::post('/api/entegrasyon/{platform}', [MagazaController::class, 'apiEntegrasyon']);
    
    // Bayi Yönetimi
    Route::apiResource('bayiler', BayiController::class);
    Route::post('/bayi/{bayi}/ozel-fiyat', [BayiController::class, 'ozelFiyatAta']);
    Route::get('/bayi/{bayi}/siparis-gecmisi', [BayiController::class, 'siparisGecmisi']);
    
    // Sipariş Yönetimi
    Route::get('/siparisler', [SiparisController::class, 'tumSiparisler']);
    Route::put('/siparis/{siparis}/durum', [SiparisController::class, 'durumGuncelle']);
    Route::post('/siparis/{siparis}/kargo', [SiparisController::class, 'kargoGonder']);
    
    // Raporlama
    Route::get('/raporlar/satis', [SiparisController::class, 'satisRaporu']);
    Route::get('/raporlar/stok', [UrunController::class, 'stokRaporu']);
    Route::get('/raporlar/bayi-performans', [BayiController::class, 'performansRaporu']);
});

// Mağaza Platform Webhook'ları
Route::prefix('webhook')->middleware('webhook.verify')->group(function () {
    Route::post('/trendyol', [MagazaController::class, 'trendyolWebhook']);
    Route::post('/hepsiburada', [MagazaController::class, 'hepsiburadaWebhook']);
    Route::post('/n11', [MagazaController::class, 'n11Webhook']);
    Route::post('/amazon', [MagazaController::class, 'amazonWebhook']);
});

// Auth API Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [KullaniciController::class, 'register']);
    Route::post('/login', [KullaniciController::class, 'login']);
    Route::post('/b2b-login', [KullaniciController::class, 'b2bLogin']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [KullaniciController::class, 'user']);
        Route::post('/logout', [KullaniciController::class, 'logout']);
        Route::put('/profil', [KullaniciController::class, 'profilGuncelle']);
        Route::post('/sifre-degistir', [KullaniciController::class, 'sifreDegistir']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Desktop API Routes (Special Authentication)
Route::prefix('v1/desktop')->middleware('desktop.verify')->group(function () {
    // Sistem sağlık kontrolü
    Route::get('/health', function () {
        return response()->json([
            'status' => 'OK',
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'version' => '1.0.0',
            'database' => 'connected',
            'cache' => 'active'
        ]);
    });
    
    // Desktop Dashboard İstatistikleri
    Route::get('/stats', function () {
        $stats = [
            'total_products' => \App\Models\Urun::count(),
            'active_products' => \App\Models\Urun::where('durum', true)->count(),
            'total_dealers' => \App\Models\Bayi::count(),
            'active_dealers' => \App\Models\Bayi::where('durum', true)->count(),
            'pending_orders' => \App\Models\Siparis::where('durum', 'beklemede')->count(),
            'low_stock_products' => \App\Models\Urun::where('stok', '<', 10)->count(),
            'total_stores' => \App\Models\Magaza::count(),
            'active_stores' => \App\Models\Magaza::where('durum', true)->count()
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    // Desktop Ürün Yönetimi
    Route::get('/urunler', function () {
        $urunler = \App\Models\Urun::with(['kategori', 'marka'])->get();
        return response()->json([
            'success' => true,
            'data' => $urunler,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    Route::get('/urunler/{urun}', function ($id) {
        $urun = \App\Models\Urun::with(['kategori', 'marka', 'resimler'])->find($id);
        if (!$urun) {
            return response()->json(['success' => false, 'message' => 'Ürün bulunamadı'], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $urun,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    // Desktop Kategori Yönetimi
    Route::get('/kategoriler', function () {
        $kategoriler = \App\Models\Kategori::with('altKategoriler')->whereNull('ust_kategori_id')->get();
        return response()->json([
            'success' => true,
            'data' => $kategoriler,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    // Desktop Marka Yönetimi
    Route::get('/markalar', function () {
        $markalar = \App\Models\Marka::all();
        return response()->json([
            'success' => true,
            'data' => $markalar,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    // Desktop Bayi Yönetimi
    Route::get('/bayiler', function () {
        $bayiler = \App\Models\Bayi::with('kullanicilar')->get();
        return response()->json([
            'success' => true,
            'data' => $bayiler,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    // Desktop Sipariş Yönetimi
    Route::get('/siparisler', function () {
        $siparisler = \App\Models\Siparis::with(['kullanici', 'siparisUrunleri.urun'])->latest()->take(50)->get();
        return response()->json([
            'success' => true,
            'data' => $siparisler,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    // Desktop Raporlar
    Route::get('/raporlar/stok', function () {
        $stokRaporu = \App\Models\Urun::selectRaw('
            COUNT(*) as toplam_urun,
            SUM(CASE WHEN stok > 0 THEN 1 ELSE 0 END) as stoklu_urun,
            SUM(CASE WHEN stok = 0 THEN 1 ELSE 0 END) as stoksuz_urun,
            SUM(CASE WHEN stok < 10 THEN 1 ELSE 0 END) as dusuk_stok,
            AVG(stok) as ortalama_stok
        ')->first();
        
        return response()->json([
            'success' => true,
            'data' => $stokRaporu,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
    
    Route::get('/raporlar/satis', function () {
        $satisRaporu = \App\Models\Siparis::selectRaw('
            COUNT(*) as toplam_siparis,
            SUM(toplam_tutar) as toplam_tutar,
            AVG(toplam_tutar) as ortalama_tutar,
            COUNT(CASE WHEN durum = "tamamlandi" THEN 1 END) as tamamlanan_siparis,
            COUNT(CASE WHEN durum = "beklemede" THEN 1 END) as bekleyen_siparis
        ')->first();
        
        return response()->json([
            'success' => true,
            'data' => $satisRaporu,
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    });
});