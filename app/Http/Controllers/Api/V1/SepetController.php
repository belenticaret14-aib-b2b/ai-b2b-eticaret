<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SepetController extends Controller
{
    /**
     * Sepet içeriğini getir
     */
    public function index(Request $request): JsonResponse
    {
        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        
        // Sepetteki ürünlerin güncel bilgilerini kontrol et
        $guncelSepet = $this->sepetGuncelle($sepet);

        return response()->json([
            'success' => true,
            'data' => $guncelSepet
        ]);
    }

    /**
     * Sepete ürün ekle
     */
    public function ekle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'urun_id' => 'required|integer|exists:urunler,id',
            'adet' => 'nullable|integer|min:1|max:999',
        ]);

        $urun = Urun::findOrFail($validated['urun_id']);
        
        if (!$urun->durum) {
            return response()->json([
                'success' => false,
                'message' => 'Bu ürün satışta değil'
            ], 400);
        }

        $adet = $validated['adet'] ?? 1;
        
        if ($urun->stok < $adet) {
            return response()->json([
                'success' => false,
                'message' => 'Yetersiz stok. Mevcut stok: ' . $urun->stok
            ], 400);
        }

        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        
        // Aynı ürün varsa adeti artır
        $found = false;
        foreach ($sepet['items'] as &$item) {
            if ($item['id'] === $urun->id) {
                $yeniAdet = $item['adet'] + $adet;
                
                if ($urun->stok < $yeniAdet) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Yetersiz stok. Sepette zaten ' . $item['adet'] . ' adet var. Maksimum ' . $urun->stok . ' adet ekleyebilirsiniz.'
                    ], 400);
                }
                
                $item['adet'] = $yeniAdet;
                $found = true;
                break;
            }
        }
        unset($item);

        // Yeni ürün ise sepete ekle
        if (!$found) {
            $sepet['items'][] = [
                'id' => $urun->id,
                'ad' => $urun->ad,
                'sku' => $urun->sku,
                'fiyat' => (float)$urun->fiyat,
                'adet' => $adet,
                'gorsel' => $urun->getAnaResim(),
                'stok' => $urun->stok,
            ];
        }

        // Toplam tutarı hesapla
        $sepet['total'] = $this->hesaplaToplam($sepet['items']);
        $sepet['adet_toplami'] = array_sum(array_column($sepet['items'], 'adet'));
        
        session(['sepet' => $sepet]);

        return response()->json([
            'success' => true,
            'message' => 'Ürün sepete eklendi',
            'data' => $sepet
        ]);
    }

    /**
     * Sepetteki ürün adedini güncelle
     */
    public function guncelle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'urun_id' => 'required|integer',
            'adet' => 'required|integer|min:1|max:999',
        ]);

        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        $updated = false;

        foreach ($sepet['items'] as &$item) {
            if ($item['id'] === $validated['urun_id']) {
                // Stok kontrolü
                $urun = Urun::find($item['id']);
                if (!$urun || $urun->stok < $validated['adet']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Yetersiz stok. Mevcut stok: ' . ($urun ? $urun->stok : 0)
                    ], 400);
                }

                $item['adet'] = $validated['adet'];
                $updated = true;
                break;
            }
        }
        unset($item);

        if (!$updated) {
            return response()->json([
                'success' => false,
                'message' => 'Ürün sepette bulunamadı'
            ], 404);
        }

        $sepet['total'] = $this->hesaplaToplam($sepet['items']);
        $sepet['adet_toplami'] = array_sum(array_column($sepet['items'], 'adet'));
        
        session(['sepet' => $sepet]);

        return response()->json([
            'success' => true,
            'message' => 'Sepet güncellendi',
            'data' => $sepet
        ]);
    }

    /**
     * Sepetten ürün sil
     */
    public function sil(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'urun_id' => 'required|integer',
        ]);

        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        $initialCount = count($sepet['items']);

        $sepet['items'] = array_filter($sepet['items'], function($item) use ($validated) {
            return $item['id'] !== $validated['urun_id'];
        });

        // Array'i yeniden indeksle
        $sepet['items'] = array_values($sepet['items']);

        if (count($sepet['items']) === $initialCount) {
            return response()->json([
                'success' => false,
                'message' => 'Ürün sepette bulunamadı'
            ], 404);
        }

        $sepet['total'] = $this->hesaplaToplam($sepet['items']);
        $sepet['adet_toplami'] = array_sum(array_column($sepet['items'], 'adet'));
        
        session(['sepet' => $sepet]);

        return response()->json([
            'success' => true,
            'message' => 'Ürün sepetten kaldırıldı',
            'data' => $sepet
        ]);
    }

    /**
     * Sepeti boşalt
     */
    public function bosalt(Request $request): JsonResponse
    {
        session()->forget('sepet');

        return response()->json([
            'success' => true,
            'message' => 'Sepet boşaltıldı',
            'data' => ['items' => [], 'total' => 0, 'adet_toplami' => 0]
        ]);
    }

    /**
     * Sepet toplamını hesapla
     */
    private function hesaplaToplam(array $items): float
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['fiyat'] * $item['adet'];
        }
        return round($total, 2);
    }

    /**
     * Sepetteki ürünlerin güncel bilgilerini kontrol et
     */
    private function sepetGuncelle(array $sepet): array
    {
        if (empty($sepet['items'])) {
            return $sepet;
        }

        $urunIds = array_column($sepet['items'], 'id');
        $urunler = Urun::whereIn('id', $urunIds)->get()->keyBy('id');
        
        $guncellenenItems = [];
        $degisiklikVar = false;

        foreach ($sepet['items'] as $item) {
            $urun = $urunler->get($item['id']);
            
            // Ürün bulunamadı veya pasif ise sepetten çıkar
            if (!$urun || !$urun->durum) {
                $degisiklikVar = true;
                continue;
            }

            // Stok kontrolü - mevcut adetten fazlaysa mevcut stoka düşür
            if ($item['adet'] > $urun->stok) {
                if ($urun->stok > 0) {
                    $item['adet'] = $urun->stok;
                    $degisiklikVar = true;
                } else {
                    // Stok yoksa sepetten çıkar
                    $degisiklikVar = true;
                    continue;
                }
            }

            // Fiyat güncellemesi
            if ($item['fiyat'] != $urun->fiyat) {
                $item['fiyat'] = (float)$urun->fiyat;
                $degisiklikVar = true;
            }

            // Ürün adı güncellemesi
            if ($item['ad'] != $urun->ad) {
                $item['ad'] = $urun->ad;
                $degisiklikVar = true;
            }

            $guncellenenItems[] = $item;
        }

        if ($degisiklikVar) {
            $sepet['items'] = $guncellenenItems;
            $sepet['total'] = $this->hesaplaToplam($sepet['items']);
            $sepet['adet_toplami'] = array_sum(array_column($sepet['items'], 'adet'));
            $sepet['guncellendi'] = true;
            
            session(['sepet' => $sepet]);
        }

        return $sepet;
    }
}