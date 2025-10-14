<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VitrinController;
use App\Http\Controllers\Api\V1\SepetController as ApiSepetController;
use App\Http\Controllers\SayfaController;

// ============ ANA SAYFA VE E-TİCARET ============
// Ana sayfa (Ana mağaza - e-ticaret sitesi)
Route::get('/', [VitrinController::class, 'index'])->name('anasayfa');

// E-ticaret sayfaları
Route::get('/urunler', [VitrinController::class, 'urunler'])->name('urunler');
Route::get('/arama', [VitrinController::class, 'arama'])->name('arama');
Route::get('/urun/{id}', [VitrinController::class, 'urunDetay'])->name('urun-detay');
// Sepet ve Ödeme
Route::get('/sepet', [\App\Http\Controllers\SepetController::class, 'index'])->name('sepet');
Route::post('/sepet/ekle', [\App\Http\Controllers\SepetController::class, 'ekle'])->name('sepet.ekle');
Route::post('/sepet/guncelle', [\App\Http\Controllers\SepetController::class, 'guncelle'])->name('sepet.guncelle');
Route::post('/sepet/sil', [\App\Http\Controllers\SepetController::class, 'sil'])->name('sepet.sil');
Route::post('/sepet/bosalt', [\App\Http\Controllers\SepetController::class, 'bosalt'])->name('sepet.bosalt');

Route::get('/odeme', [\App\Http\Controllers\OdemeController::class, 'index'])->name('odeme.index');
Route::post('/odeme/islem', [\App\Http\Controllers\OdemeController::class, 'islem'])->name('odeme.islem');
Route::get('/siparis/{id}', [\App\Http\Controllers\OdemeController::class, 'siparisDetay'])->name('siparis.detay');

// ============ STATİK/İÇERİK SAYFALARI ============
Route::get('/sayfa/{slug}', [SayfaController::class, 'goster'])->name('sayfa.goster');
Route::get('/iletisim', [SayfaController::class, 'iletisim'])->name('sayfa.iletisim');
Route::post('/iletisim', [SayfaController::class, 'iletisimFormuGonder'])->name('sayfa.iletisim.gonder');
Route::get('/hakkimizda', [SayfaController::class, 'hakkimizda'])->name('sayfa.hakkimizda');
Route::get('/gizlilik-politikasi', [SayfaController::class, 'gizlilikPolitikasi'])->name('sayfa.gizlilik');
Route::get('/kullanim-sartlari', [SayfaController::class, 'kullanimSartlari'])->name('sayfa.kullanim');

// ============ AUTH ROUTES ============
require __DIR__.'/auth.php';

// ============ DASHBOARD ============
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ============ PROFİL YÖNETİMİ ============
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============ BAYİ LOGİN ============
Route::get('/bayi-login', function () {
    return view('auth.bayilogin');
})->name('bayi.login');

// ============ BOT WEBHOOKS (PUBLIC) ============
Route::post('/webhook/bot/{botType}', [\App\Http\Controllers\SuperAdmin\BotController::class, 'webhook'])->name('bot.webhook');

// ============ DEV LOGIN (SADECE LOCAL) ============
if (app()->environment('local')) {
    Route::get('/dev-login/{rol}', function (string $rol) {
        try {
            $email = match ($rol) {
                'super_admin' => 'superadmin@aib2b.local',
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
                'admin' => redirect()->route('admin.panel')->with('success', 'Admin olarak giriş yapıldı.'),
                'bayi' => redirect()->route('bayi.panel')->with('success', 'Bayi olarak giriş yapıldı.'),
                'musteri' => redirect()->route('musteri.panel')->with('success', 'Müşteri olarak giriş yapıldı.'),
                default => redirect()->route('anasayfa')->with('success', 'Ana sayfaya yönlendiriliyorsunuz.'),
            };
        } catch (\Exception $e) {
            \Log::error('Dev login hatası: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Giriş hatası: ' . $e->getMessage());
        }
    })->name('dev.login');

    Route::get('/dev-logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('anasayfa')->with('success', 'Çıkış yapıldı.');
    })->name('dev.logout');
}

// ============ ALT ROUTE DOSYALARI ============
// Admin routes
Route::middleware(['auth'])->group(function () {
    require __DIR__.'/admin/web.php';
});

// Super Admin routes  
Route::middleware(['auth'])->group(function () {
    require __DIR__.'/super-admin/web.php';
});

// Bayi routes
Route::middleware(['auth'])->group(function () {
    require __DIR__.'/bayi/web.php';
});

// Müşteri routes
Route::middleware(['auth'])->group(function () {
    require __DIR__.'/musteri/web.php';
});