<?php

use Illuminate\Support\Facades\Route;

// ============ BAYİ PANELİ ============
Route::middleware(['auth', 'bayi'])->prefix('bayi')->name('bayi.')->group(function () {
    // Modern Dashboard
    Route::get('/panel', function () {
        return view('bayi.modern-dashboard');
    })->name('panel');
    
    // Bayi ürün yönetimi
    Route::get('/urunler', function () {
        return view('bayi.urunler');
    })->name('urunler');
    
    // Bayi siparişleri
    Route::get('/siparisler', function () {
        return view('bayi.siparisler');
    })->name('siparisler');
    
    // Bayi raporları
    Route::get('/raporlar', function () {
        return view('bayi.raporlar');
    })->name('raporlar');
    
    // Bayi ayarları
    Route::get('/ayarlar', function () {
        return view('bayi.ayarlar');
    })->name('ayarlar');
});



