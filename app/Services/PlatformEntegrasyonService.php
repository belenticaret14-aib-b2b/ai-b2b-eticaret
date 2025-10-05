<?php

namespace App\Services;

use App\Models\Magaza;
use App\Models\Urun;
use App\Models\Siparis;
use App\Models\SenkronLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlatformEntegrasyonService
{
    /**
     * Ürünleri platforma senkronize et
     */
    public function urunleriSenkronize(Magaza $magaza, array $urunIds): array
    {
        $successCount = 0;
        $errorCount = 0;
        $details = [];

        foreach ($urunIds as $urunId) {
            try {
                $urun = Urun::find($urunId);
                if (!$urun) {
                    $errorCount++;
                    $details[] = "Ürün bulunamadı: {$urunId}";
                    continue;
                }

                $result = $this->platformUrunGonder($magaza, $urun);
                
                if ($result['success']) {
                    $successCount++;
                    // Pivot tablosunu güncelle
                    $magaza->urunler()->updateExistingPivot($urunId, [
                        'platform_urun_id' => $result['platform_id'] ?? null,
                        'platform_sku' => $result['platform_sku'] ?? null,
                        'senkron_durum' => 'tamamlandi'
                    ]);
                } else {
                    $errorCount++;
                    $details[] = "Ürün senkron hatası ({$urun->ad}): " . $result['message'];
                    $magaza->urunler()->updateExistingPivot($urunId, [
                        'senkron_durum' => 'hata'
                    ]);
                }

            } catch (\Exception $e) {
                $errorCount++;
                $details[] = "Exception: " . $e->getMessage();
                Log::error('Ürün senkron hatası', [
                    'magaza_id' => $magaza->id,
                    'urun_id' => $urunId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Senkron log kaydet
        SenkronLog::create([
            'magaza_id' => $magaza->id,
            'tip' => 'urun_senkron',
            'durum' => $errorCount === 0 ? 'basarili' : 'kismi_basarili',
            'detay' => [
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'details' => $details
            ]
        ]);

        return [
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'details' => $details
        ];
    }

    /**
     * Stok senkronizasyonu
     */
    public function stokSenkronize(Magaza $magaza): array
    {
        $successCount = 0;
        $errorCount = 0;
        $details = [];

        $urunler = $magaza->urunler()->wherePivot('senkron_durum', 'tamamlandi')->get();

        foreach ($urunler as $urun) {
            try {
                $result = $this->platformStokGuncelle($magaza, $urun);
                
                if ($result['success']) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $details[] = "Stok güncelleme hatası ({$urun->ad}): " . $result['message'];
                }

            } catch (\Exception $e) {
                $errorCount++;
                $details[] = "Exception: " . $e->getMessage();
                Log::error('Stok senkron hatası', [
                    'magaza_id' => $magaza->id,
                    'urun_id' => $urun->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Senkron log kaydet
        SenkronLog::create([
            'magaza_id' => $magaza->id,
            'tip' => 'stok_senkron',
            'durum' => $errorCount === 0 ? 'basarili' : 'kismi_basarili',
            'detay' => [
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'details' => $details
            ]
        ]);

        return [
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'details' => $details
        ];
    }

    /**
     * Fiyat senkronizasyonu
     */
    public function fiyatSenkronize(Magaza $magaza): array
    {
        $successCount = 0;
        $errorCount = 0;
        $details = [];

        $urunler = $magaza->urunler()->wherePivot('senkron_durum', 'tamamlandi')->get();

        foreach ($urunler as $urun) {
            try {
                $result = $this->platformFiyatGuncelle($magaza, $urun);
                
                if ($result['success']) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $details[] = "Fiyat güncelleme hatası ({$urun->ad}): " . $result['message'];
                }

            } catch (\Exception $e) {
                $errorCount++;
                $details[] = "Exception: " . $e->getMessage();
                Log::error('Fiyat senkron hatası', [
                    'magaza_id' => $magaza->id,
                    'urun_id' => $urun->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Senkron log kaydet
        SenkronLog::create([
            'magaza_id' => $magaza->id,
            'tip' => 'fiyat_senkron',
            'durum' => $errorCount === 0 ? 'basarili' : 'kismi_basarili',
            'detay' => [
                'success_count' => $successCount,
                'error_count' => $errorCount,
                'details' => $details
            ]
        ]);

        return [
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'details' => $details
        ];
    }

    /**
     * Platform API bağlantı testi
     */
    public function testApiConnection(string $platform, array $credentials): array
    {
        switch ($platform) {
            case 'trendyol':
                return $this->testTrendyolApi($credentials);
            case 'hepsiburada':
                return $this->testHepsiburadaApi($credentials);
            case 'n11':
                return $this->testN11Api($credentials);
            case 'amazon':
                return $this->testAmazonApi($credentials);
            default:
                return [
                    'success' => false,
                    'message' => 'Desteklenmeyen platform'
                ];
        }
    }

    /**
     * Platform'a ürün gönder
     */
    private function platformUrunGonder(Magaza $magaza, Urun $urun): array
    {
        switch ($magaza->platform) {
            case 'trendyol':
                return $this->trendyolUrunGonder($magaza, $urun);
            case 'hepsiburada':
                return $this->hepsiburadaUrunGonder($magaza, $urun);
            case 'n11':
                return $this->n11UrunGonder($magaza, $urun);
            case 'amazon':
                return $this->amazonUrunGonder($magaza, $urun);
            default:
                return [
                    'success' => false,
                    'message' => 'Desteklenmeyen platform'
                ];
        }
    }

    /**
     * Platform'da stok güncelle
     */
    private function platformStokGuncelle(Magaza $magaza, Urun $urun): array
    {
        switch ($magaza->platform) {
            case 'trendyol':
                return $this->trendyolStokGuncelle($magaza, $urun);
            case 'hepsiburada':
                return $this->hepsiburadaStokGuncelle($magaza, $urun);
            case 'n11':
                return $this->n11StokGuncelle($magaza, $urun);
            case 'amazon':
                return $this->amazonStokGuncelle($magaza, $urun);
            default:
                return [
                    'success' => false,
                    'message' => 'Desteklenmeyen platform'
                ];
        }
    }

    /**
     * Platform'da fiyat güncelle
     */
    private function platformFiyatGuncelle(Magaza $magaza, Urun $urun): array
    {
        switch ($magaza->platform) {
            case 'trendyol':
                return $this->trendyolFiyatGuncelle($magaza, $urun);
            case 'hepsiburada':
                return $this->hepsiburadaFiyatGuncelle($magaza, $urun);
            case 'n11':
                return $this->n11FiyatGuncelle($magaza, $urun);
            case 'amazon':
                return $this->amazonFiyatGuncelle($magaza, $urun);
            default:
                return [
                    'success' => false,
                    'message' => 'Desteklenmeyen platform'
                ];
        }
    }

    // ============ TRENDYOL ENTEGRASYONLARı ============

    private function testTrendyolApi(array $credentials): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($credentials['api_anahtari'] . ':' . $credentials['api_gizli_anahtar']),
                'Content-Type' => 'application/json',
            ])->get('https://api.trendyol.com/sapigw/suppliers/' . $credentials['api_anahtari'] . '/v2/products');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Trendyol API bağlantısı başarılı',
                    'data' => $response->json()
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Trendyol API bağlantı hatası: ' . $response->body()
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Trendyol API test hatası: ' . $e->getMessage()
            ];
        }
    }

    private function trendyolUrunGonder(Magaza $magaza, Urun $urun): array
    {
        try {
            $credentials = $magaza->getApiCredentials();
            
            $urunData = [
                'barcode' => $urun->barkod,
                'title' => $urun->ad,
                'productMainId' => $urun->sku,
                'brandId' => $urun->marka_id ?? 1, // Default brand
                'categoryId' => $urun->kategori_id ?? 1, // Default category
                'quantity' => $urun->stok,
                'stockCode' => $urun->sku,
                'dimensionalWeight' => $urun->agirlik ?? 0,
                'description' => $urun->aciklama ?? '',
                'currencyType' => 'TL',
                'listPrice' => $urun->fiyat,
                'salePrice' => $urun->fiyat,
                'vatRate' => 18,
                'cargoProfileId' => 1,
                'deliveryDuration' => [
                    'deliveryDuration' => 3
                ],
                'images' => [
                    ['url' => $urun->getAnaResim()]
                ],
                'attributes' => []
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($credentials['api_key'] . ':' . $credentials['api_secret']),
                'Content-Type' => 'application/json',
            ])->post('https://api.trendyol.com/sapigw/suppliers/' . $credentials['api_key'] . '/v2/products', [
                'items' => [$urunData]
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                return [
                    'success' => true,
                    'platform_id' => $responseData['batchRequestId'] ?? null,
                    'platform_sku' => $urun->sku
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Trendyol ürün gönderme hatası: ' . $response->body()
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Trendyol ürün gönderme exception: ' . $e->getMessage()
            ];
        }
    }

    private function trendyolStokGuncelle(Magaza $magaza, Urun $urun): array
    {
        try {
            $credentials = $magaza->getApiCredentials();
            $platformSku = $urun->pivot->platform_sku ?? $urun->sku;

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($credentials['api_key'] . ':' . $credentials['api_secret']),
                'Content-Type' => 'application/json',
            ])->put('https://api.trendyol.com/sapigw/suppliers/' . $credentials['api_key'] . '/v2/products/stock-price', [
                'items' => [
                    [
                        'barcode' => $urun->barkod,
                        'quantity' => $urun->stok
                    ]
                ]
            ]);

            return [
                'success' => $response->successful(),
                'message' => $response->successful() ? 'Başarılı' : 'Hata: ' . $response->body()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Trendyol stok güncelleme exception: ' . $e->getMessage()
            ];
        }
    }

    private function trendyolFiyatGuncelle(Magaza $magaza, Urun $urun): array
    {
        try {
            $credentials = $magaza->getApiCredentials();
            
            // Trendyol komisyon oranını hesapla
            $komisyonOrani = 0.15; // %15 varsayılan
            $trendyolFiyat = $urun->fiyat / (1 - $komisyonOrani);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($credentials['api_key'] . ':' . $credentials['api_secret']),
                'Content-Type' => 'application/json',
            ])->put('https://api.trendyol.com/sapigw/suppliers/' . $credentials['api_key'] . '/v2/products/stock-price', [
                'items' => [
                    [
                        'barcode' => $urun->barkod,
                        'listPrice' => round($trendyolFiyat, 2),
                        'salePrice' => round($trendyolFiyat, 2)
                    ]
                ]
            ]);

            return [
                'success' => $response->successful(),
                'message' => $response->successful() ? 'Başarılı' : 'Hata: ' . $response->body()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Trendyol fiyat güncelleme exception: ' . $e->getMessage()
            ];
        }
    }

    // ============ HEPSİBURADA ENTEGRASYONLARı ============

    private function testHepsiburadaApi(array $credentials): array
    {
        // Hepsiburada API test implementasyonu
        return [
            'success' => true,
            'message' => 'Hepsiburada API test - Mock implementasyon'
        ];
    }

    private function hepsiburadaUrunGonder(Magaza $magaza, Urun $urun): array
    {
        // Hepsiburada ürün gönderme implementasyonu
        return [
            'success' => true,
            'platform_id' => 'HB_' . $urun->id,
            'platform_sku' => $urun->sku
        ];
    }

    private function hepsiburadaStokGuncelle(Magaza $magaza, Urun $urun): array
    {
        // Hepsiburada stok güncelleme implementasyonu
        return ['success' => true, 'message' => 'Mock başarılı'];
    }

    private function hepsiburadaFiyatGuncelle(Magaza $magaza, Urun $urun): array
    {
        // Hepsiburada fiyat güncelleme implementasyonu
        return ['success' => true, 'message' => 'Mock başarılı'];
    }

    // ============ N11 ENTEGRASYONLARı ============

    private function testN11Api(array $credentials): array
    {
        // N11 API test implementasyonu
        return [
            'success' => true,
            'message' => 'N11 API test - Mock implementasyon'
        ];
    }

    private function n11UrunGonder(Magaza $magaza, Urun $urun): array
    {
        // N11 ürün gönderme implementasyonu
        return [
            'success' => true,
            'platform_id' => 'N11_' . $urun->id,
            'platform_sku' => $urun->sku
        ];
    }

    private function n11StokGuncelle(Magaza $magaza, Urun $urun): array
    {
        return ['success' => true, 'message' => 'Mock başarılı'];
    }

    private function n11FiyatGuncelle(Magaza $magaza, Urun $urun): array
    {
        return ['success' => true, 'message' => 'Mock başarılı'];
    }

    // ============ AMAZON ENTEGRASYONLARı ============

    private function testAmazonApi(array $credentials): array
    {
        return [
            'success' => true,
            'message' => 'Amazon API test - Mock implementasyon'
        ];
    }

    private function amazonUrunGonder(Magaza $magaza, Urun $urun): array
    {
        return [
            'success' => true,
            'platform_id' => 'AMZ_' . $urun->id,
            'platform_sku' => $urun->sku
        ];
    }

    private function amazonStokGuncelle(Magaza $magaza, Urun $urun): array
    {
        return ['success' => true, 'message' => 'Mock başarılı'];
    }

    private function amazonFiyatGuncelle(Magaza $magaza, Urun $urun): array
    {
        return ['success' => true, 'message' => 'Mock başarılı'];
    }

    // ============ WEBHOOK İŞLEMLERİ ============

    public function trendyolSiparisIsle(array $data): void
    {
        // Trendyol sipariş webhook işleme
        Log::info('Trendyol sipariş webhook alındı', $data);
    }

    public function trendyolSiparisIptal(array $data): void
    {
        // Trendyol sipariş iptal webhook işleme
        Log::info('Trendyol sipariş iptal webhook alındı', $data);
    }

    public function hepsiburadaSiparisIsle(array $data): void
    {
        Log::info('Hepsiburada sipariş webhook alındı', $data);
    }

    public function n11WebhookIsle(array $data): void
    {
        Log::info('N11 webhook alındı', $data);
    }

    public function amazonWebhookIsle(array $data): void
    {
        Log::info('Amazon webhook alındı', $data);
    }
}