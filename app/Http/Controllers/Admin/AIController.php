<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function urunOnerisi(Request $request)
    {
        try {
            // Mock AI Data - Gelecekte gerçek AI entegrasyonu için hazır
            $oneriler = [
                [
                    'kategori' => 'Elektronik',
                    'urun_adi' => 'Akıllı Telefon',
                    'tahmini_fiyat' => '15000',
                    'talep_seviyesi' => 'Yüksek',
                    'neden' => 'Yeni model çıkışı yaklaşıyor'
                ],
                [
                    'kategori' => 'Bilgisayar',
                    'urun_adi' => 'Gaming Laptop',
                    'tahmini_fiyat' => '25000',
                    'talep_seviyesi' => 'Orta',
                    'neden' => 'Oyun pazarı büyüyor'
                ],
                [
                    'kategori' => 'Ev & Yaşam',
                    'urun_adi' => 'Akıllı Ev Sistemi',
                    'tahmini_fiyat' => '8000',
                    'talep_seviyesi' => 'Yüksek',
                    'neden' => 'IoT trend devam ediyor'
                ],
                [
                    'kategori' => 'Moda',
                    'urun_adi' => 'Akıllı Saat',
                    'tahmini_fiyat' => '5000',
                    'talep_seviyesi' => 'Çok Yüksek',
                    'neden' => 'Sağlık takibi talebi artıyor'
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $oneriler,
                'message' => 'AI önerileri başarıyla getirildi',
                'meta' => [
                    'generated_at' => now()->format('Y-m-d H:i:s'),
                    'source' => 'AI System v1.0'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'AI önerisi alınamadı: ' . $e->getMessage()
            ], 500);
        }
    }
}
