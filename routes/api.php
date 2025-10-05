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
Route::prefix('webhook')->group(function () {
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