<?php

use Illuminate\Support\Facades\Route;

// ============ MÜŞTERİ PANELİ ============
Route::middleware(['auth'])->prefix('musteri')->name('musteri.')->group(function () {
    // Modern Dashboard
    Route::get('/panel', function () {
        return view('musteri.modern-dashboard');
    })->name('panel');
    
    // Müşteri siparişleri
    Route::get('/siparisler', function () {
        return view('musteri.siparisler');
    })->name('siparisler');
    
    // Müşteri profili
    Route::get('/profil', function () {
        return view('musteri.profil');
    })->name('profil');
    
    // Müşteri adresleri
    Route::get('/adresler', function () {
        return view('musteri.adresler');
    })->name('adresler');
    
    // Müşteri favorileri
    Route::get('/favoriler', function () {
        return view('musteri.favoriler');
    })->name('favoriler');
});

