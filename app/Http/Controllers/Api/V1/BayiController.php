<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Bayi;
use App\Models\Urun;
use App\Models\Siparis;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BayiController extends Controller
{
    /**
     * Bayi ürünlerini listele
     */
    public function urunler(Request $request): JsonResponse
    {
        $bayi = $request->user()->bayi;
        
        if (!$bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi bulunamadı'
            ], 404);
        }
        
        $urunler = Urun::with(['kategori', 'marka'])
            ->where('durum', true)
            ->paginate(20);
        
        return response()->json([
            'success' => true,
            'data' => $urunler
        ]);
    }
    
    /**
     * Bayi özel fiyat
     */
    public function bayiFiyat(Request $request, $urunId): JsonResponse
    {
        $bayi = $request->user()->bayi;
        $urun = Urun::find($urunId);
        
        if (!$urun || !$bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Ürün veya bayi bulunamadı'
            ], 404);
        }
        
        // Bayi indirim oranını hesapla (örnek: %15)
        $bayiIndirim = 0.15;
        $bayiFiyat = $urun->fiyat * (1 - $bayiIndirim);
        
        return response()->json([
            'success' => true,
            'data' => [
                'urun' => $urun,
                'bayi_fiyat' => round($bayiFiyat, 2),
                'indirim_orani' => $bayiIndirim * 100
            ]
        ]);
    }
    
    /**
     * Bayi kampanyaları
     */
    public function kampanyalar(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'kampanyalar' => [
                    [
                        'id' => 1,
                        'baslik' => 'Toplu Alım İndirimi',
                        'aciklama' => '50+ adet alımda %20 indirim',
                        'gecerli_tarih' => '2024-12-31'
                    ]
                ]
            ]
        ]);
    }
    
    /**
     * Bayi siparişleri
     */
    public function bayiSiparisleri(Request $request): JsonResponse
    {
        $bayi = $request->user()->bayi;
        
        if (!$bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi bulunamadı'
            ], 404);
        }
        
        $siparisler = Siparis::with(['siparisUrunleri.urun'])
            ->where('bayi_id', $bayi->id)
            ->latest()
            ->paginate(20);
        
        return response()->json([
            'success' => true,
            'data' => $siparisler
        ]);
    }
    
    /**
     * Bayi profili
     */
    public function profil(Request $request): JsonResponse
    {
        $bayi = $request->user()->bayi;
        
        if (!$bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi bulunamadı'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'bayi' => $bayi,
                'kullanici' => $request->user()
            ]
        ]);
    }
    
    /**
     * Bayi profil güncelle
     */
    public function profilGuncelle(Request $request): JsonResponse
    {
        $request->validate([
            'firma_adi' => 'string|max:255',
            'telefon' => 'string|max:20',
            'adres' => 'string|max:500'
        ]);
        
        $bayi = $request->user()->bayi;
        
        if (!$bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi bulunamadı'
            ], 404);
        }
        
        $bayi->update($request->only(['firma_adi', 'telefon', 'adres']));
        
        return response()->json([
            'success' => true,
            'message' => 'Profil güncellendi',
            'data' => $bayi
        ]);
    }
    
    /**
     * Bayi bakiyesi
     */
    public function bakiye(Request $request): JsonResponse
    {
        $bayi = $request->user()->bayi;
        
        if (!$bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi bulunamadı'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'bakiye' => 0.00, // Örnek bakiye
                'kredi_limiti' => 50000.00
            ]
        ]);
    }
    
    /**
     * Cari hesap
     */
    public function cariHesap(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'cari_hesap' => [
                    'toplam_borc' => 0.00,
                    'toplam_alacak' => 0.00,
                    'bakiye' => 0.00
                ]
            ]
        ]);
    }
    
    /**
     * Özel fiyat ata (Admin)
     */
    public function ozelFiyatAta(Request $request, $bayiId): JsonResponse
    {
        // Admin yetkisi kontrolü
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Özel fiyat atandı'
        ]);
    }
    
    /**
     * Sipariş geçmişi (Admin)
     */
    public function siparisGecmisi(Request $request, $bayiId): JsonResponse
    {
        // Admin yetkisi kontrolü
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim'
            ], 403);
        }
        
        $siparisler = Siparis::where('bayi_id', $bayiId)
            ->with(['siparisUrunleri.urun'])
            ->latest()
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $siparisler
        ]);
    }
    
    /**
     * Performans raporu (Admin)
     */
    public function performansRaporu(Request $request): JsonResponse
    {
        // Admin yetkisi kontrolü
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'performans' => [
                    'toplam_bayi' => Bayi::count(),
                    'aktif_bayi' => Bayi::where('durum', true)->count(),
                    'toplam_siparis' => Siparis::count(),
                    'toplam_tutar' => Siparis::sum('toplam_tutar')
                ]
            ]
        ]);
    }
}


