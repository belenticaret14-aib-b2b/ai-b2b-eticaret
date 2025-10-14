<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UrunController as AdminUrunController;
use App\Http\Controllers\Admin\MagazaController as AdminMagazaController;
use App\Http\Controllers\Admin\SiteAyarController;
use App\Http\Controllers\Admin\SayfaYonetimController;
use App\Http\Controllers\Admin\XMLController;
use App\Http\Controllers\Admin\AIController;
use App\Http\Controllers\Admin\BarkodController;

// ============ ESKİ ADMIN PANELİ (GERİYE DÖNÜK UYUMLULUK) ============
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/panel', [DashboardController::class, 'index'])->name('panel');

    // AI ürün önerisi
    Route::post('/ai/urun-onerisi', [AIController::class, 'urunOnerisi'])->name('ai.urunOnerisi');

    // Barkod ile ürün çekme
    Route::post('/barkod/fetch', [BarkodController::class, 'fetchProduct'])->name('barkod.fetch');

    // Ürün Yönetimi (CRUD + Toplu İşlemler)
    Route::get('/urun', [AdminUrunController::class, 'index'])->name('urun.index');
    Route::get('/urun/yeni', [AdminUrunController::class, 'create'])->name('urun.create');
    Route::post('/urun/ekle', [AdminUrunController::class, 'store'])->name('urun.store');
    Route::get('/urun/{urun}', [AdminUrunController::class, 'show'])->name('urun.show');
    Route::get('/urun/{urun}/duzenle', [AdminUrunController::class, 'edit'])->name('urun.edit');
    Route::put('/urun/{urun}', [AdminUrunController::class, 'update'])->name('urun.update');
    Route::delete('/urun/{urun}', [AdminUrunController::class, 'destroy'])->name('urun.destroy');
    Route::post('/urun/toplu-islem', [AdminUrunController::class, 'bulkAction'])->name('urun.bulk');
    
    // Mağaza Yönetimi (CRUD + Entegrasyon)
    Route::get('/magaza', [AdminMagazaController::class, 'index'])->name('magaza.index');
    Route::get('/magaza/yeni', [AdminMagazaController::class, 'create'])->name('magaza.create');
    Route::post('/magaza/ekle', [AdminMagazaController::class, 'store'])->name('magaza.store');
    Route::get('/magaza/{magaza}', [AdminMagazaController::class, 'show'])->name('magaza.show');
    Route::get('/magaza/{magaza}/duzenle', [AdminMagazaController::class, 'edit'])->name('magaza.edit');
    Route::put('/magaza/{magaza}', [AdminMagazaController::class, 'update'])->name('magaza.update');
    Route::delete('/magaza/{magaza}', [AdminMagazaController::class, 'destroy'])->name('magaza.destroy');
    Route::post('/magaza/{magaza}/test-connection', [AdminMagazaController::class, 'testConnection'])->name('magaza.test');
    Route::post('/magaza/{magaza}/senkronize', [AdminMagazaController::class, 'senkronize'])->name('magaza.sync');
    Route::post('/magaza/toplu-islem', [AdminMagazaController::class, 'bulkAction'])->name('magaza.bulk');
    
    // Site Ayarları
    Route::get('/site-ayarlari', [SiteAyarController::class, 'index'])->name('site-ayarlari');
    Route::post('/site-ayarlari', [SiteAyarController::class, 'guncelle'])->name('site-ayarlari.guncelle');
    Route::post('/site-ayarlari/yeni', [SiteAyarController::class, 'yeniAyar'])->name('site-ayarlari.yeni');
    Route::delete('/site-ayarlari/{id}', [SiteAyarController::class, 'sil'])->name('site-ayarlari.sil');
    
    // Sayfa Yönetimi
    Route::get('/sayfalar', [SayfaYonetimController::class, 'index'])->name('sayfalar');
    Route::get('/sayfalar/yeni', [SayfaYonetimController::class, 'create'])->name('sayfalar.create');
    Route::post('/sayfalar', [SayfaYonetimController::class, 'store'])->name('sayfalar.store');
    Route::get('/sayfalar/{sayfa}/duzenle', [SayfaYonetimController::class, 'edit'])->name('sayfalar.edit');
    Route::put('/sayfalar/{sayfa}', [SayfaYonetimController::class, 'update'])->name('sayfalar.update');
    Route::delete('/sayfalar/{sayfa}', [SayfaYonetimController::class, 'destroy'])->name('sayfalar.destroy');

    // XML içe/dışa aktarma
    Route::post('/xml/import', [XMLController::class, 'import'])->name('xml.import');
    Route::get('/xml/export', [XMLController::class, 'export'])->name('xml.export');
    
    // Kategori Yönetimi (Yeni Eklendi)
    Route::get('/kategoriler', function () {
        $kategoriler = \App\Models\Kategori::with('children')->orderBy('sira')->get();
        return view('admin.kategoriler.index', compact('kategoriler'));
    })->name('kategoriler.index');
    
    Route::get('/kategoriler/yeni', function () {
        $anaKategoriler = \App\Models\Kategori::anaKategoriler()->get();
        return view('admin.kategoriler.create', compact('anaKategoriler'));
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
        
        return redirect()->route('admin.kategoriler.index')->with('success', 'Kategori başarıyla eklendi.');
    })->name('kategoriler.store');
});
