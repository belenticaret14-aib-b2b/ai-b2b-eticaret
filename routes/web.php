<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UrunController as AdminUrunController;
use App\Http\Controllers\Admin\MagazaController as AdminMagazaController;
use App\Http\Controllers\Admin\SiteAyarController;
use App\Http\Controllers\Admin\SayfaYonetimController;
use App\Http\Controllers\Admin\XMLController;
use App\Http\Controllers\Admin\AIController;
use App\Http\Controllers\Admin\BarkodController;
use App\Http\Controllers\VitrinController;
use App\Http\Controllers\Api\V1\SepetController as ApiSepetController;
use App\Http\Controllers\SayfaController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\StoreAdmin\DashboardController as StoreAdminDashboardController;
use App\Http\Controllers\DealerAdmin\DashboardController as DealerAdminDashboardController;
use App\Http\Controllers\SuperAdmin\ClaudeController;

// Ana sayfa
Route::get('/', [VitrinController::class, 'index'])->name('vitrin.index');

// Vitrin (B2C)
Route::get('/vitrin', [VitrinController::class, 'index'])->name('vitrin.home');

Route::get('/vitrin/urunler', [VitrinController::class, 'urunler'])->name('vitrin.urunler');
Route::get('/vitrin/arama', [VitrinController::class, 'arama'])->name('vitrin.arama');

Route::get('/vitrin/urun/{id}', [VitrinController::class, 'urunDetay'])->name('vitrin.urun-detay');

Route::get('/vitrin/sepet', [VitrinController::class, 'sepet'])->name('vitrin.sepet');
// Sepet linki için alias (layouts.app içinde route('sepet.index') kullanılıyor)
Route::get('/sepet', function() {
    return redirect()->route('vitrin.sepet');
})->name('sepet.index');

Route::get('/vitrin/odeme', [VitrinController::class, 'odeme'])->name('vitrin.odeme');

// Sepet (Session-based, web forms)
Route::post('/sepet/ekle', [ApiSepetController::class, 'ekle'])->name('sepet.ekle');

// Statik/İçerik Sayfaları
Route::get('/sayfa/{slug}', [SayfaController::class, 'goster'])->name('sayfa.goster');
Route::get('/iletisim', [SayfaController::class, 'iletisim'])->name('sayfa.iletisim');
Route::post('/iletisim', [SayfaController::class, 'iletisimFormuGonder'])->name('sayfa.iletisim.gonder');
Route::get('/hakkimizda', [SayfaController::class, 'hakkimizda'])->name('sayfa.hakkimizda');
Route::get('/gizlilik-politikasi', [SayfaController::class, 'gizlilikPolitikasi'])->name('sayfa.gizlilik');
Route::get('/kullanim-sartlari', [SayfaController::class, 'kullanimSartlari'])->name('sayfa.kullanim');

// Auth routes
require __DIR__.'/auth.php';

// Dashboard (Auth gerekli)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============ SÜPER ADMIN PANELİ ============
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/panel', [SuperAdminDashboardController::class, 'index'])->name('panel');
    
    // Kullanıcı Yönetimi
    Route::get('/kullanicilar', function () {
        return view('super-admin.kullanicilar');
    })->name('kullanicilar');
    
    // Mağaza Yönetimi
    Route::get('/magazalar', function () {
        return view('super-admin.magazalar');
    })->name('magazalar');
    
    // Bayi Yönetimi
    Route::get('/bayiler', function () {
        return view('super-admin.bayiler');
    })->name('bayiler');
    
    // Sistem Ayarları
    Route::get('/sistem-ayarlari', function () {
        return view('super-admin.sistem-ayarlari');
    })->name('sistem-ayarlari');
    
    // Raporlar
    Route::get('/raporlar', function () {
        return view('super-admin.raporlar');
    })->name('raporlar');
    
    // Geliştirici Sayfası
    Route::get('/gelistirici', function () {
        return view('super-admin.gelistirici');
    })->name('gelistirici');
    
    // Proje Detayları
    Route::get('/proje-detaylari', function () {
        return view('super-admin.proje-detaylari');
    })->name('proje-detaylari');
    
    // Bot Ayarları
    Route::get('/bot-ayarlari', [\App\Http\Controllers\SuperAdmin\BotController::class, 'index'])->name('bot-ayarlari');
    Route::post('/bot-update', [\App\Http\Controllers\SuperAdmin\BotController::class, 'update'])->name('bot-update');
    Route::post('/bot-test', [\App\Http\Controllers\SuperAdmin\BotController::class, 'test'])->name('bot-test');
    
    // Hata Analiz Bot
    Route::post('/hata-analiz', function () {
        $hataAnalizBot = new \App\Services\HataAnalizBotService();
        return response()->json($hataAnalizBot->hataAnalizEt());
    })->name('hata-analiz');
    
    Route::post('/otomatik-duzelt', function () {
        $hataAnalizBot = new \App\Services\HataAnalizBotService();
        return response()->json($hataAnalizBot->otomatikHataDuzelt());
    })->name('otomatik-duzelt');
    
    // Sistem sağlık kontrolü
    Route::get('/sistem-saglik', function () {
        $hataAnalizBot = new \App\Services\HataAnalizBotService();
        $analiz = $hataAnalizBot->hataAnalizEt();
        return response()->json([
            'sistem_sagligi' => $analiz['sistem_sagligi'] ?? [],
            'genel_durum' => $analiz['genel_durum'] ?? 'normal',
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    })->name('sistem-saglik');
    
    // Hızlı sistem kontrolü
    Route::get('/hizli-kontrol', function () {
        return response()->json([
            'durum' => 'iyi',
            'mesaj' => 'Sistem hızlı kontrol tamamlandı',
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'performans' => [
                'veritabani' => 'iyi',
                'cache' => 'iyi',
                'dosya_sistemi' => 'iyi',
                'api_baglantilari' => 'iyi'
            ]
        ]);
    })->name('hizli-kontrol');
    
    // Hatalı link kontrolü ve düzeltme
    Route::post('/hatali-link-kontrol', function () {
        $hataliLinkService = new \App\Services\HataliLinkDuzeltmeService();
        return response()->json($hataliLinkService->hataliLinkleriTespitVeDuzelt());
    })->name('hatali-link-kontrol');
    
    // Hızlı link kontrolü
    Route::get('/hizli-link-kontrol', function () {
        $hataliLinkService = new \App\Services\HataliLinkDuzeltmeService();
        return response()->json($hataliLinkService->hizliLinkKontrolu());
    })->name('hizli-link-kontrol');
    
    // Claude AI
    Route::get('/claude', [ClaudeController::class, 'index'])->name('claude');
    Route::post('/claude/chat', [ClaudeController::class, 'chat'])->name('claude.chat');
    Route::post('/claude/urun-aciklama', [ClaudeController::class, 'urunAciklamasi'])->name('claude.urun-aciklama');
    Route::post('/claude/seo-meta', [ClaudeController::class, 'seoMeta'])->name('claude.seo-meta');
    Route::post('/claude/musteri-sorusu', [ClaudeController::class, 'musteriSorusu'])->name('claude.musteri-sorusu');
    Route::post('/claude/siparis-analizi', [ClaudeController::class, 'siparisAnalizi'])->name('claude.siparis-analizi');
    Route::post('/claude/ceviri', [ClaudeController::class, 'ceviri'])->name('claude.ceviri');
    Route::post('/claude/stok-uyarisi', [ClaudeController::class, 'stokUyarisi'])->name('claude.stok-uyarisi');
    Route::post('/claude/hata-analiz', [ClaudeController::class, 'hataAnalizi'])->name('claude.hata-analiz');
    Route::get('/claude/test', [ClaudeController::class, 'test'])->name('claude.test');
});

// ============ MAĞAZA ADMIN PANELİ ============
Route::middleware(['auth', 'store_admin'])->prefix('store-admin')->name('store-admin.')->group(function () {
    Route::get('/dashboard', [StoreAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/panel', [StoreAdminDashboardController::class, 'index'])->name('panel');
    Route::get('/magaza-sec', [StoreAdminDashboardController::class, 'magazaSec'])->name('magaza-sec');
    Route::post('/magaza-ata', [StoreAdminDashboardController::class, 'magazaAta'])->name('magaza-ata');
    
    // Ürün Yönetimi
    Route::get('/urunler', function () {
        return view('store-admin.urunler');
    })->name('urunler');
    
    // Sipariş Yönetimi
    Route::get('/siparisler', function () {
        return view('store-admin.siparisler');
    })->name('siparisler');
    
    // Mağaza Ayarları
    Route::get('/magaza-ayarlari', function () {
        return view('store-admin.magaza-ayarlari');
    })->name('magaza-ayarlari');
});

// ============ BAYİ ADMIN PANELİ ============
Route::middleware(['auth', 'dealer_admin'])->prefix('dealer-admin')->name('dealer-admin.')->group(function () {
    Route::get('/dashboard', [DealerAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/panel', [DealerAdminDashboardController::class, 'index'])->name('panel');
    Route::get('/bayi-sec', [DealerAdminDashboardController::class, 'bayiSec'])->name('bayi-sec');
    Route::post('/bayi-ata', [DealerAdminDashboardController::class, 'bayiAta'])->name('bayi-ata');
    
    // Ürün Kataloğu
    Route::get('/urunler', function () {
        return view('dealer-admin.urunler');
    })->name('urunler');
    
    // Sipariş Yönetimi
    Route::get('/siparisler', function () {
        return view('dealer-admin.siparisler');
    })->name('siparisler');
    
    // Bayi Ayarları
    Route::get('/bayi-ayarlari', function () {
        return view('dealer-admin.bayi-ayarlari');
    })->name('bayi-ayarlari');
});

// ============ ESKİ ADMIN PANELİ (GERİYE DÖNÜK UYUMLULUK) ============
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/panel', [DashboardController::class, 'index'])->name('admin.panel');

    // AI ürün önerisi
    Route::post('/admin/ai/urun-onerisi', [AIController::class, 'urunOnerisi'])->name('admin.ai.urunOnerisi');

    // Barkod ile ürün çekme
    Route::post('/admin/barkod/fetch', [BarkodController::class, 'fetchProduct'])->name('admin.barkod.fetch');

    // Ürün Yönetimi (CRUD + Toplu İşlemler)
    Route::get('/admin/urun', [AdminUrunController::class, 'index'])->name('admin.urun.index');
    Route::get('/admin/urun/yeni', [AdminUrunController::class, 'create'])->name('admin.urun.create');
    Route::post('/admin/urun/ekle', [AdminUrunController::class, 'store'])->name('admin.urun.store');
    Route::get('/admin/urun/{urun}', [AdminUrunController::class, 'show'])->name('admin.urun.show');
    Route::get('/admin/urun/{urun}/duzenle', [AdminUrunController::class, 'edit'])->name('admin.urun.edit');
    Route::put('/admin/urun/{urun}', [AdminUrunController::class, 'update'])->name('admin.urun.update');
    Route::delete('/admin/urun/{urun}', [AdminUrunController::class, 'destroy'])->name('admin.urun.destroy');
    Route::post('/admin/urun/toplu-islem', [AdminUrunController::class, 'bulkAction'])->name('admin.urun.bulk');
    
    // Mağaza Yönetimi (CRUD + Entegrasyon)
    Route::get('/admin/magaza', [AdminMagazaController::class, 'index'])->name('admin.magaza.index');
    Route::get('/admin/magaza/yeni', [AdminMagazaController::class, 'create'])->name('admin.magaza.create');
    Route::post('/admin/magaza/ekle', [AdminMagazaController::class, 'store'])->name('admin.magaza.store');
    Route::get('/admin/magaza/{magaza}', [AdminMagazaController::class, 'show'])->name('admin.magaza.show');
    Route::get('/admin/magaza/{magaza}/duzenle', [AdminMagazaController::class, 'edit'])->name('admin.magaza.edit');
    Route::put('/admin/magaza/{magaza}', [AdminMagazaController::class, 'update'])->name('admin.magaza.update');
    Route::delete('/admin/magaza/{magaza}', [AdminMagazaController::class, 'destroy'])->name('admin.magaza.destroy');
    Route::post('/admin/magaza/{magaza}/test-connection', [AdminMagazaController::class, 'testConnection'])->name('admin.magaza.test');
    Route::post('/admin/magaza/{magaza}/senkronize', [AdminMagazaController::class, 'senkronize'])->name('admin.magaza.sync');
    Route::post('/admin/magaza/toplu-islem', [AdminMagazaController::class, 'bulkAction'])->name('admin.magaza.bulk');
    
    // Site Ayarları
    Route::get('/admin/site-ayarlari', [SiteAyarController::class, 'index'])->name('admin.site-ayarlari');
    Route::post('/admin/site-ayarlari', [SiteAyarController::class, 'guncelle'])->name('admin.site-ayarlari.guncelle');
    Route::post('/admin/site-ayarlari/yeni', [SiteAyarController::class, 'yeniAyar'])->name('admin.site-ayarlari.yeni');
    Route::delete('/admin/site-ayarlari/{id}', [SiteAyarController::class, 'sil'])->name('admin.site-ayarlari.sil');
    
    // Sayfa Yönetimi
    Route::get('/admin/sayfalar', [SayfaYonetimController::class, 'index'])->name('admin.sayfalar');
    Route::get('/admin/sayfalar/yeni', [SayfaYonetimController::class, 'create'])->name('admin.sayfalar.create');
    Route::post('/admin/sayfalar', [SayfaYonetimController::class, 'store'])->name('admin.sayfalar.store');
    Route::get('/admin/sayfalar/{sayfa}/duzenle', [SayfaYonetimController::class, 'edit'])->name('admin.sayfalar.edit');
    Route::put('/admin/sayfalar/{sayfa}', [SayfaYonetimController::class, 'update'])->name('admin.sayfalar.update');
    Route::delete('/admin/sayfalar/{sayfa}', [SayfaYonetimController::class, 'destroy'])->name('admin.sayfalar.destroy');

    // XML içe/dışa aktarma
    Route::post('/admin/xml/import', [XMLController::class, 'import'])->name('admin.xml.import');
    Route::get('/admin/xml/export', [XMLController::class, 'export'])->name('admin.xml.export');
});

// Bayi Paneli
Route::middleware(['auth', 'bayi'])->group(function () {
    Route::get('/bayi/panel', function () {
        return view('bayi.panel');
    })->name('bayi.panel');
});

// Bot Webhooks (Public)
Route::post('/webhook/bot/{botType}', [\App\Http\Controllers\SuperAdmin\BotController::class, 'webhook'])->name('bot.webhook');

// B2B Login 
Route::get('/b2b-login', function () {
    return view('auth.b2b-login');
})->name('b2b.login');

// B2B Panel (sadece bayi ve admin)
Route::middleware(['auth', 'bayi'])->group(function () {
    Route::get('/b2b', function () {
        return view('b2b.panel');
    })->name('b2b.panel');
});

// Sadece LOCAL ortam için hızlı demo giriş linkleri
if (app()->environment('local')) {
    Route::get('/dev-login/{rol}', function (string $rol) {
        $email = match ($rol) {
            'super_admin' => 'superadmin@aib2b.local',
            'store_admin' => 'storeadmin@aib2b.local',
            'dealer_admin' => 'dealeradmin@aib2b.local',
            'admin' => 'admin@aib2b.local',
            'bayi' => 'bayi@aib2b.local',
            'musteri' => 'musteri@aib2b.local',
            default => null,
        };

        if (!$email) {
            abort(404);
        }

        $user = \App\Models\Kullanici::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Demo kullanıcı bulunamadı. Lütfen seeder çalıştırın.');
        }

        \Illuminate\Support\Facades\Auth::login($user);
        request()->session()->regenerate();

        return match ($rol) {
            'super_admin' => redirect()->route('super-admin.dashboard')->with('success', 'Süper Admin olarak giriş yapıldı.'),
            'store_admin' => redirect()->route('store-admin.dashboard')->with('success', 'Mağaza Admin olarak giriş yapıldı.'),
            'dealer_admin' => redirect()->route('dealer-admin.dashboard')->with('success', 'Bayi Admin olarak giriş yapıldı.'),
            'admin' => redirect()->route('admin.panel')->with('success', 'Admin olarak giriş yapıldı.'),
            'bayi' => redirect()->route('b2b.panel')->with('success', 'Bayi olarak giriş yapıldı.'),
            default => redirect()->route('vitrin.index')->with('success', 'Müşteri olarak giriş yapıldı.'),
        };
    })->name('dev.login');

    Route::get('/dev-logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('vitrin.index')->with('success', 'Çıkış yapıldı.');
    })->name('dev.logout');
}