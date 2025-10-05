<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Magaza;
use App\Models\Urun;
use App\Services\PlatformEntegrasyonService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MagazaController extends Controller
{
    protected $platformService;

    public function __construct(PlatformEntegrasyonService $platformService)
    {
        $this->platformService = $platformService;
    }

    /**
     * Mağaza listesi
     */
    public function index(Request $request): JsonResponse
    {
        $magazalar = Magaza::with(['urunler' => function($query) {
                                $query->take(5);
                            }])
                           ->when($request->has('platform'), function($query) use ($request) {
                               $query->where('platform', $request->platform);
                           })
                           ->when($request->has('durum'), function($query) use ($request) {
                               $query->where('durum', $request->boolean('durum'));
                           })
                           ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $magazalar->items(),
            'pagination' => [
                'current_page' => $magazalar->currentPage(),
                'last_page' => $magazalar->lastPage(),
                'per_page' => $magazalar->perPage(),
                'total' => $magazalar->total(),
            ]
        ]);
    }

    /**
     * Mağaza detayı
     */
    public function show(Magaza $magaza): JsonResponse
    {
        $magaza->load(['urunler', 'senkronLoglar' => function($query) {
            $query->latest()->take(10);
        }]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $magaza->id,
                'ad' => $magaza->ad,
                'platform' => $magaza->platform,
                'platform_kodu' => $magaza->platform_kodu,
                'entegrasyon_turu' => $magaza->entegrasyon_turu,
                'durum' => $magaza->durum,
                'senkron_durum' => $magaza->senkron_durum,
                'son_senkron' => $magaza->son_senkron,
                'ayarlar' => $magaza->ayarlar,
                'api_configured' => $magaza->isApiConfigured(),
                'can_sync' => $magaza->canSync(),
                'last_sync_status' => $magaza->getLastSyncStatus(),
                'toplam_urun' => $magaza->urunler->count(),
                'son_senkron_loglar' => $magaza->senkronLoglar,
            ]
        ]);
    }

    /**
     * Yeni mağaza oluştur
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'platform' => 'required|string|in:trendyol,hepsiburada,n11,amazon,pazarama,gittigidiyor',
            'platform_kodu' => 'nullable|string|max:100',
            'api_anahtari' => 'required|string|max:500',
            'api_gizli_anahtar' => 'nullable|string|max:500',
            'api_base_url' => 'nullable|url',
            'entegrasyon_turu' => 'required|string|in:api,xml,manuel',
            'ayarlar' => 'nullable|array',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string|max:255',
        ]);

        $magaza = Magaza::create($validated);

        return response()->json([
            'success' => true,
            'data' => $magaza,
            'message' => 'Mağaza başarıyla oluşturuldu'
        ], 201);
    }

    /**
     * Mağaza güncelle
     */
    public function update(Request $request, Magaza $magaza): JsonResponse
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'platform_kodu' => 'nullable|string|max:100',
            'api_anahtari' => 'required|string|max:500',
            'api_gizli_anahtar' => 'nullable|string|max:500',
            'api_base_url' => 'nullable|url',
            'entegrasyon_turu' => 'required|string|in:api,xml,manuel',
            'durum' => 'boolean',
            'ayarlar' => 'nullable|array',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string|max:255',
        ]);

        $magaza->update($validated);

        return response()->json([
            'success' => true,
            'data' => $magaza,
            'message' => 'Mağaza başarıyla güncellendi'
        ]);
    }

    /**
     * Mağaza ile ürün eşitle
     */
    public function urunEsitle(Request $request, Magaza $magaza): JsonResponse
    {
        $validated = $request->validate([
            'urun_ids' => 'required|array',
            'urun_ids.*' => 'exists:urunler,id',
            'platform_settings' => 'nullable|array',
        ]);

        try {
            $urunIds = $validated['urun_ids'];
            $platformSettings = $validated['platform_settings'] ?? [];

            // Mevcut eşleşmeleri kaldır
            $magaza->urunler()->detach();

            // Yeni eşleşmeleri ekle
            $syncData = [];
            foreach ($urunIds as $urunId) {
                $syncData[$urunId] = [
                    'senkron_durum' => 'bekliyor',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $magaza->urunler()->attach($syncData);

            // Platform entegrasyonu varsa senkronize et
            if ($magaza->canSync()) {
                $this->platformService->urunleriSenkronize($magaza, $urunIds);
            }

            return response()->json([
                'success' => true,
                'message' => count($urunIds) . ' ürün mağaza ile eşitlendi',
                'esitlenen_urun_sayisi' => count($urunIds)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ürün eşitleme hatası: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Stok senkronizasyonu
     */
    public function stokSenkronize(Request $request, Magaza $magaza): JsonResponse
    {
        if (!$magaza->canSync()) {
            return response()->json([
                'success' => false,
                'message' => 'Mağaza API ayarları eksik veya mağaza pasif'
            ], 400);
        }

        try {
            $result = $this->platformService->stokSenkronize($magaza);

            return response()->json([
                'success' => true,
                'message' => 'Stok senkronizasyonu tamamlandı',
                'senkronize_edilen' => $result['success_count'],
                'hata_olan' => $result['error_count'],
                'detaylar' => $result['details']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stok senkronizasyon hatası: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fiyat senkronizasyonu
     */
    public function fiyatSenkronize(Request $request, Magaza $magaza): JsonResponse
    {
        if (!$magaza->canSync()) {
            return response()->json([
                'success' => false,
                'message' => 'Mağaza API ayarları eksik veya mağaza pasif'
            ], 400);
        }

        try {
            $result = $this->platformService->fiyatSenkronize($magaza);

            return response()->json([
                'success' => true,
                'message' => 'Fiyat senkronizasyonu tamamlandı',
                'senkronize_edilen' => $result['success_count'],
                'hata_olan' => $result['error_count'],
                'detaylar' => $result['details']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Fiyat senkronizasyon hatası: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API Entegrasyon Test
     */
    public function apiEntegrasyon(Request $request, string $platform): JsonResponse
    {
        $validated = $request->validate([
            'api_anahtari' => 'required|string',
            'api_gizli_anahtar' => 'nullable|string',
            'test_endpoint' => 'nullable|string',
        ]);

        try {
            $result = $this->platformService->testApiConnection($platform, $validated);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'data' => $result['data'] ?? null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'API test hatası: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Trendyol Webhook
     */
    public function trendyolWebhook(Request $request): JsonResponse
    {
        try {
            // Webhook imza doğrulaması
            $signature = $request->header('X-Trendyol-Signature');
            $payload = $request->getContent();
            
            // İmza kontrolü yapılacak...
            
            $data = $request->all();
            $eventType = $data['eventType'] ?? null;

            switch ($eventType) {
                case 'ORDER_CREATED':
                    $this->platformService->trendyolSiparisIsle($data);
                    break;
                case 'ORDER_CANCELLED':
                    $this->platformService->trendyolSiparisIptal($data);
                    break;
                case 'STOCK_UPDATE':
                    $this->platformService->trendyolStokGuncelle($data);
                    break;
                default:
                    \Log::info('Bilinmeyen Trendyol webhook eventi: ' . $eventType, $data);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Trendyol webhook hatası: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Hepsiburada Webhook
     */
    public function hepsiburadaWebhook(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $eventType = $data['eventType'] ?? null;

            switch ($eventType) {
                case 'OrderUpdate':
                    $this->platformService->hepsiburadaSiparisIsle($data);
                    break;
                case 'StockUpdate':
                    $this->platformService->hepsiburadaStokGuncelle($data);
                    break;
                default:
                    \Log::info('Bilinmeyen Hepsiburada webhook eventi: ' . $eventType, $data);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Hepsiburada webhook hatası: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    /**
     * N11 Webhook
     */
    public function n11Webhook(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            
            // N11 webhook işlemleri
            $this->platformService->n11WebhookIsle($data);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('N11 webhook hatası: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Amazon Webhook
     */
    public function amazonWebhook(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            
            // Amazon webhook işlemleri
            $this->platformService->amazonWebhookIsle($data);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            \Log::error('Amazon webhook hatası: ' . $e->getMessage(), [
                'request' => $request->all()
            ]);

            return response()->json(['success' => false], 500);
        }
    }
}