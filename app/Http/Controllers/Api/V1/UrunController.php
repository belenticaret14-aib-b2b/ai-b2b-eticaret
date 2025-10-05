<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UrunController extends Controller
{
    /**
     * Ürün listesi (B2C)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Urun::with(['kategori', 'resimler'])
                     ->aktif()
                     ->stokta();

        // Filtreleme
        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('min_fiyat')) {
            $query->where('fiyat', '>=', $request->min_fiyat);
        }

        if ($request->has('max_fiyat')) {
            $query->where('fiyat', '<=', $request->max_fiyat);
        }

        if ($request->has('marka_id')) {
            $query->where('marka_id', $request->marka_id);
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');
        
        if (in_array($sortBy, ['ad', 'fiyat', 'created_at', 'stok'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $urunler = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $urunler->items(),
            'pagination' => [
                'current_page' => $urunler->currentPage(),
                'last_page' => $urunler->lastPage(),
                'per_page' => $urunler->perPage(),
                'total' => $urunler->total(),
            ]
        ]);
    }

    /**
     * Ürün detayı
     */
    public function show(Urun $urun): JsonResponse
    {
        if (!$urun->durum) {
            return response()->json([
                'success' => false,
                'message' => 'Ürün bulunamadı'
            ], 404);
        }

        $urun->load(['kategori', 'marka', 'resimler', 'ozellikler']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $urun->id,
                'ad' => $urun->ad,
                'sku' => $urun->sku,
                'aciklama' => $urun->aciklama,
                'fiyat' => $urun->fiyat,
                'stok' => $urun->stok,
                'barkod' => $urun->barkod,
                'kategori' => $urun->kategori ? [
                    'id' => $urun->kategori->id,
                    'ad' => $urun->kategori->ad,
                    'slug' => $urun->kategori->slug,
                ] : null,
                'marka' => $urun->marka ? [
                    'id' => $urun->marka->id,
                    'ad' => $urun->marka->ad,
                ] : null,
                'resimler' => $urun->getTumResimler(),
                'ozellikler' => $urun->ozellikler,
                'agirlik' => $urun->agirlik,
                'boyutlar' => $urun->boyutlar,
            ]
        ]);
    }

    /**
     * Ürün arama
     */
    public function arama(Request $request): JsonResponse
    {
        $arama = $request->get('q', '');
        
        if (strlen($arama) < 3) {
            return response()->json([
                'success' => false,
                'message' => 'Arama terimi en az 3 karakter olmalıdır'
            ], 400);
        }

        $urunler = Urun::with(['kategori', 'resimler'])
                       ->aktif()
                       ->arama($arama)
                       ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $urunler->items(),
            'pagination' => [
                'current_page' => $urunler->currentPage(),
                'last_page' => $urunler->lastPage(),
                'per_page' => $urunler->perPage(),
                'total' => $urunler->total(),
            ]
        ]);
    }

    /**
     * Kategoriye göre ürünler
     */
    public function kategoriUrunleri(Kategori $kategori, Request $request): JsonResponse
    {
        if (!$kategori->durum) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori bulunamadı'
            ], 404);
        }

        // Alt kategorilerdeki ürünleri de dahil et
        $kategoriIds = [$kategori->id];
        $altKategoriler = $kategori->getAllChildren();
        
        if ($altKategoriler->isNotEmpty()) {
            $kategoriIds = array_merge($kategoriIds, $altKategoriler->pluck('id')->toArray());
        }

        $urunler = Urun::with(['kategori', 'resimler'])
                       ->aktif()
                       ->stokta()
                       ->whereIn('kategori_id', $kategoriIds)
                       ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $urunler->items(),
            'kategori' => [
                'id' => $kategori->id,
                'ad' => $kategori->ad,
                'slug' => $kategori->slug,
                'aciklama' => $kategori->aciklama,
            ],
            'pagination' => [
                'current_page' => $urunler->currentPage(),
                'last_page' => $urunler->lastPage(),
                'per_page' => $urunler->perPage(),
                'total' => $urunler->total(),
            ]
        ]);
    }

    /**
     * Admin için ürün yönetimi
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:urunler,sku',
            'aciklama' => 'nullable|string',
            'fiyat' => 'required|numeric|min:0',
            'bayi_fiyat' => 'nullable|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'minimum_stok' => 'nullable|integer|min:0',
            'kategori_id' => 'nullable|exists:kategoriler,id',
            'marka_id' => 'nullable|exists:markalar,id',
            'barkod' => 'nullable|string',
            'agirlik' => 'nullable|numeric|min:0',
            'boyutlar' => 'nullable|array',
        ]);

        $urun = Urun::create($validated);

        return response()->json([
            'success' => true,
            'data' => $urun,
            'message' => 'Ürün başarıyla oluşturuldu'
        ], 201);
    }

    /**
     * Admin için ürün güncelleme
     */
    public function update(Request $request, Urun $urun): JsonResponse
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:urunler,sku,' . $urun->id,
            'aciklama' => 'nullable|string',
            'fiyat' => 'required|numeric|min:0',
            'bayi_fiyat' => 'nullable|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'minimum_stok' => 'nullable|integer|min:0',
            'kategori_id' => 'nullable|exists:kategoriler,id',
            'marka_id' => 'nullable|exists:markalar,id',
            'barkod' => 'nullable|string',
            'agirlik' => 'nullable|numeric|min:0',
            'boyutlar' => 'nullable|array',
            'durum' => 'boolean',
        ]);

        $urun->update($validated);

        return response()->json([
            'success' => true,
            'data' => $urun,
            'message' => 'Ürün başarıyla güncellendi'
        ]);
    }

    /**
     * Admin için toplu ürün güncelleme
     */
    public function topluGuncelleme(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'urunler' => 'required|array',
            'urunler.*.id' => 'required|exists:urunler,id',
            'urunler.*.fiyat' => 'nullable|numeric|min:0',
            'urunler.*.stok' => 'nullable|integer|min:0',
            'urunler.*.durum' => 'nullable|boolean',
        ]);

        $guncellenenSayisi = 0;
        
        foreach ($validated['urunler'] as $urunData) {
            $urun = Urun::find($urunData['id']);
            
            if ($urun) {
                $guncellenecekData = array_filter($urunData, function($value, $key) {
                    return $key !== 'id' && $value !== null;
                }, ARRAY_FILTER_USE_BOTH);
                
                if (!empty($guncellenecekData)) {
                    $urun->update($guncellenecekData);
                    $guncellenenSayisi++;
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$guncellenenSayisi} ürün başarıyla güncellendi"
        ]);
    }

    /**
     * Stok raporu
     */
    public function stokRaporu(Request $request): JsonResponse
    {
        $kritikStokUrunler = Urun::kritikStok()
                                 ->with(['kategori'])
                                 ->get(['id', 'ad', 'sku', 'stok', 'minimum_stok', 'kategori_id']);

        $stokDurumu = [
            'toplam_urun' => Urun::count(),
            'stokta_olan' => Urun::stokta()->count(),
            'stok_tukenen' => Urun::where('stok', 0)->count(),
            'kritik_stok' => $kritikStokUrunler->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stok_durumu' => $stokDurumu,
                'kritik_stok_urunler' => $kritikStokUrunler,
            ]
        ]);
    }
}