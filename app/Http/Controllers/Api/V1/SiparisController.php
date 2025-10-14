<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Siparis;
use App\Models\SiparisUrunu;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SiparisController extends Controller
{
    /**
     * Sipariş detayı
     */
    public function show(Request $request, $id): JsonResponse
    {
        $siparis = Siparis::with(['siparisUrunleri.urun', 'kullanici'])
            ->find($id);
        
        if (!$siparis) {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş bulunamadı'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $siparis
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
     * Toplu sipariş oluştur
     */
    public function topluSiparis(Request $request): JsonResponse
    {
        $request->validate([
            'urunler' => 'required|array',
            'urunler.*.urun_id' => 'required|exists:urunler,id',
            'urunler.*.adet' => 'required|integer|min:1',
            'teslimat_adresi' => 'required|string|max:500',
            'fatura_adresi' => 'required|string|max:500'
        ]);
        
        $bayi = $request->user()->bayi;
        
        if (!$bayi) {
            return response()->json([
                'success' => false,
                'message' => 'Bayi bulunamadı'
            ], 404);
        }
        
        DB::beginTransaction();
        
        try {
            $toplamTutar = 0;
            $siparisUrunleri = [];
            
            // Ürünleri kontrol et ve toplam tutarı hesapla
            foreach ($request->urunler as $urunData) {
                $urun = \App\Models\Urun::find($urunData['urun_id']);
                
                if (!$urun || !$urun->durum) {
                    throw new \Exception("Ürün bulunamadı veya aktif değil: {$urunData['urun_id']}");
                }
                
                if ($urun->stok < $urunData['adet']) {
                    throw new \Exception("Yetersiz stok: {$urun->ad}");
                }
                
                $bayiIndirim = 0.15; // %15 bayi indirimi
                $bayiFiyat = $urun->fiyat * (1 - $bayiIndirim);
                $tutar = $bayiFiyat * $urunData['adet'];
                $toplamTutar += $tutar;
                
                $siparisUrunleri[] = [
                    'urun_id' => $urun->id,
                    'adet' => $urunData['adet'],
                    'birim_fiyat' => $bayiFiyat,
                    'toplam_tutar' => $tutar
                ];
            }
            
            // Siparişi oluştur
            $siparis = Siparis::create([
                'kullanici_id' => $request->user()->id,
                'bayi_id' => $bayi->id,
                'durum' => 'beklemede',
                'toplam_tutar' => $toplamTutar,
                'teslimat_adresi' => $request->teslimat_adresi,
                'fatura_adresi' => $request->fatura_adresi,
                'siparis_tarihi' => now()
            ]);
            
            // Sipariş ürünlerini ekle
            foreach ($siparisUrunleri as $siparisUrunu) {
                SiparisUrunu::create([
                    'siparis_id' => $siparis->id,
                    'urun_id' => $siparisUrunu['urun_id'],
                    'adet' => $siparisUrunu['adet'],
                    'birim_fiyat' => $siparisUrunu['birim_fiyat'],
                    'toplam_tutar' => $siparisUrunu['toplam_tutar']
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Toplu sipariş oluşturuldu',
                'data' => [
                    'siparis_id' => $siparis->id,
                    'toplam_tutar' => $toplamTutar,
                    'urun_sayisi' => count($siparisUrunleri)
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    /**
     * Tüm siparişler (Admin)
     */
    public function tumSiparisler(Request $request): JsonResponse
    {
        // Admin yetkisi kontrolü
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim'
            ], 403);
        }
        
        $siparisler = Siparis::with(['siparisUrunleri.urun', 'kullanici', 'bayi'])
            ->latest()
            ->paginate(50);
        
        return response()->json([
            'success' => true,
            'data' => $siparisler
        ]);
    }
    
    /**
     * Sipariş durumu güncelle (Admin)
     */
    public function durumGuncelle(Request $request, $id): JsonResponse
    {
        // Admin yetkisi kontrolü
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim'
            ], 403);
        }
        
        $request->validate([
            'durum' => 'required|in:beklemede,onaylandi,hazirlaniyor,kargoda,tamamlandi,iptal'
        ]);
        
        $siparis = Siparis::find($id);
        
        if (!$siparis) {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş bulunamadı'
            ], 404);
        }
        
        $siparis->update([
            'durum' => $request->durum,
            'guncelleme_tarihi' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Sipariş durumu güncellendi',
            'data' => $siparis
        ]);
    }
    
    /**
     * Kargo gönder (Admin)
     */
    public function kargoGonder(Request $request, $id): JsonResponse
    {
        // Admin yetkisi kontrolü
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim'
            ], 403);
        }
        
        $request->validate([
            'kargo_firmasi' => 'required|string|max:100',
            'takip_no' => 'required|string|max:100'
        ]);
        
        $siparis = Siparis::find($id);
        
        if (!$siparis) {
            return response()->json([
                'success' => false,
                'message' => 'Sipariş bulunamadı'
            ], 404);
        }
        
        $siparis->update([
            'durum' => 'kargoda',
            'kargo_firmasi' => $request->kargo_firmasi,
            'takip_no' => $request->takip_no,
            'kargo_tarihi' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Kargo bilgileri eklendi',
            'data' => $siparis
        ]);
    }
    
    /**
     * Satış raporu (Admin)
     */
    public function satisRaporu(Request $request): JsonResponse
    {
        // Admin yetkisi kontrolü
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Yetkisiz erişim'
            ], 403);
        }
        
        $baslangic = $request->get('baslangic', now()->startOfMonth());
        $bitis = $request->get('bitis', now()->endOfMonth());
        
        $rapor = Siparis::selectRaw('
            COUNT(*) as toplam_siparis,
            SUM(toplam_tutar) as toplam_tutar,
            AVG(toplam_tutar) as ortalama_tutar,
            COUNT(CASE WHEN durum = "tamamlandi" THEN 1 END) as tamamlanan_siparis,
            COUNT(CASE WHEN durum = "beklemede" THEN 1 END) as bekleyen_siparis,
            COUNT(CASE WHEN durum = "iptal" THEN 1 END) as iptal_siparis
        ')
        ->whereBetween('created_at', [$baslangic, $bitis])
        ->first();
        
        return response()->json([
            'success' => true,
            'data' => [
                'rapor' => $rapor,
                'tarih_araligi' => [
                    'baslangic' => $baslangic,
                    'bitis' => $bitis
                ]
            ]
        ]);
    }
}


