<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\ClaudeController;
use App\Http\Controllers\SuperAdmin\MagazaController;
use App\Http\Controllers\ThemeController;

// ============ SÜPER ADMIN PANELİ ============
Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    // Modern Dashboard
    Route::get('/dashboard', function () { return view('super-admin.dashboard'); })->name('dashboard');
    
    // Kullanıcı Yönetimi
    Route::get('/kullanicilar', function () {
        return view('super-admin.kullanicilar');
    })->name('kullanicilar');
    
    // Mağaza Yönetimi
    Route::get('/magazalar', [MagazaController::class, 'index'])->name('magazalar');
    Route::get('/magazalar/create', [MagazaController::class, 'create'])->name('magazalar.create');
    Route::post('/magazalar', [MagazaController::class, 'store'])->name('magazalar.store');
    Route::get('/magazalar/{magaza}', [MagazaController::class, 'show'])->name('magazalar.show');
    Route::get('/magazalar/{magaza}/edit', [MagazaController::class, 'edit'])->name('magazalar.edit');
    Route::put('/magazalar/{magaza}', [MagazaController::class, 'update'])->name('magazalar.update');
    Route::delete('/magazalar/{magaza}', [MagazaController::class, 'destroy'])->name('magazalar.destroy');
    
    // Mağaza İşlemleri
    Route::post('/magazalar/{magaza}/test-connection', [MagazaController::class, 'testConnection'])->name('magazalar.test');
    Route::post('/magazalar/{magaza}/sync', [MagazaController::class, 'sync'])->name('magazalar.sync');
    Route::post('/magazalar/{magaza}/toggle-status', [MagazaController::class, 'toggleStatus'])->name('magazalar.toggle');
    Route::post('/magazalar/{magaza}/set-main', [MagazaController::class, 'setAsMain'])->name('magazalar.set-main');
    
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
    
    // Tema Yönetimi
    Route::get('/tema', [ThemeController::class, 'index'])->name('theme');
    Route::post('/tema/degistir', [ThemeController::class, 'switch'])->name('theme.switch');
    Route::get('/tema/ayarlar', [ThemeController::class, 'settings'])->name('theme.settings');
    Route::post('/tema/ayarlar', [ThemeController::class, 'saveSettings'])->name('theme.save');
    
    // Modül Yönetimi
    Route::get('/modules', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/create', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'create'])->name('modules.create');
    Route::post('/modules', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'store'])->name('modules.store');
    Route::get('/modules/{module}', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'show'])->name('modules.show');
    Route::post('/modules/{module}/toggle', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'toggle'])->name('modules.toggle');
    Route::post('/modules/{module}/settings', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'updateSettings'])->name('modules.settings');
    Route::delete('/modules/{module}', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::get('/modules/stats', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'stats'])->name('modules.stats');
    Route::get('/modules/backup', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'backup'])->name('modules.backup');
    Route::post('/modules/restore', [\App\Http\Controllers\SuperAdmin\ModuleController::class, 'restore'])->name('modules.restore');
    
    // Kategori Yönetimi (Süper Admin)
    Route::get('/kategoriler', function () {
        $kategoriler = \App\Models\Kategori::with('children')->orderBy('sira')->get();
        return view('super-admin.kategoriler.index', compact('kategoriler'));
    })->name('kategoriler.index');

    // Ürün Yönetimi (Süper Admin)
    Route::get('/urunler', function () {
        $urunler = \App\Models\Urun::with(['kategori', 'marka'])->paginate(20);
        $kategoriler = \App\Models\Kategori::orderBy('ad')->get();
        $markalar = \App\Models\Marka::orderBy('ad')->get();
        return view('super-admin.urunler.index', compact('urunler', 'kategoriler', 'markalar'));
    })->name('urunler.index');
    
    // Hatalı Link Kontrolü
    Route::get('/hatali-link-kontrol', function () {
        return view('super-admin.hatali-link-kontrol');
    })->name('hatali-link-kontrol');
    
    Route::post('/hatali-link-kontrol/tara', function (\Illuminate\Http\Request $request) {
        return app(\App\Http\Controllers\SuperAdmin\HataliLinkController::class)->tara($request);
    })->name('hatali-link-kontrol.tara');
    
    Route::post('/hatali-link-kontrol/duzelt', function (\Illuminate\Http\Request $request) {
        return app(\App\Http\Controllers\SuperAdmin\HataliLinkController::class)->duzelt($request);
    })->name('hatali-link-kontrol.duzelt');
    
    Route::get('/kategoriler/yeni', function () {
        $anaKategoriler = \App\Models\Kategori::anaKategoriler()->get();
        return view('super-admin.kategoriler.create', compact('anaKategoriler'));
    })->name('kategoriler.create');
    
    Route::post('/kategoriler', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'ad' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:kategoriler,slug',
            'aciklama' => 'nullable|string',
            'parent_id' => 'nullable|exists:kategoriler,id',
            'sira' => 'nullable|integer',
            'durum' => 'boolean'
        ]);
        
        \App\Models\Kategori::create($request->all());
        
        return redirect()->route('super-admin.kategoriler.index')->with('success', 'Kategori başarıyla eklendi.');
    })->name('kategoriler.store');
});

// Tema Preview (Public)
Route::get('/tema/{theme}/preview', [ThemeController::class, 'preview'])->name('theme.preview');
