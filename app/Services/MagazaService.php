<?php

namespace App\Services;

use App\Models\Magaza;
use App\Models\SenkronLog;
use App\Services\PlatformEntegrasyonService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MagazaService
{
    public function __construct(
        private PlatformEntegrasyonService $platformService
    ) {}

    public function testConnection(Magaza $magaza): array
    {
        try {
            $config = $magaza->getApiCredentials();
            
            if (!$config['api_key'] || !$config['api_secret']) {
                throw new \Exception('API anahtarları eksik');
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $config['api_key'],
                    'Content-Type' => 'application/json',
                ])
                ->get($config['base_url'] . '/test');

            if ($response->successful()) {
                $magaza->update([
                    'son_baglanti_testi' => now(),
                    'durum' => true
                ]);

                return [
                    'status' => 'success',
                    'message' => 'Bağlantı başarılı',
                    'response_time' => $response->transferStats?->getHandlerStat('total_time') ?? 0,
                    'data' => $response->json()
                ];
            } else {
                throw new \Exception('API yanıtı başarısız: ' . $response->status());
            }
        } catch (\Exception $e) {
            $magaza->update([
                'son_baglanti_testi' => now(),
                'durum' => false
            ]);

            Log::error('Mağaza bağlantı testi hatası', [
                'magaza_id' => $magaza->id,
                'magaza_ad' => $magaza->ad,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function senkronize(Magaza $magaza): array
    {
        DB::beginTransaction();
        
        try {
            $log = SenkronLog::create([
                'magaza_id' => $magaza->id,
                'islem_turu' => 'urun_senkron',
                'baslangic_tarihi' => now(),
                'durum' => 'basladi'
            ]);

            $result = $this->platformService->urunSenkronize($magaza);
            
            $log->update([
                'bitis_tarihi' => now(),
                'durum' => 'tamamlandi',
                'detay' => json_encode($result)
            ]);

            $magaza->update([
                'son_senkron' => now(),
                'son_senkron_tarihi' => now()
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Senkronizasyon tamamlandı',
                'islenen_urun' => $result['islenen_urun'] ?? 0,
                'basarili' => $result['basarili'] ?? 0,
                'hatali' => $result['hatali'] ?? 0
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($log)) {
                $log->update([
                    'bitis_tarihi' => now(),
                    'durum' => 'hata',
                    'hata_mesaji' => $e->getMessage()
                ]);
            }

            Log::error('Mağaza senkronizasyon hatası', [
                'magaza_id' => $magaza->id,
                'magaza_ad' => $magaza->ad,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function stokGuncelle(Magaza $magaza, array $stokVerileri): array
    {
        try {
            $result = $this->platformService->stokGuncelle($magaza, $stokVerileri);
            
            Log::info('Stok güncelleme başarılı', [
                'magaza_id' => $magaza->id,
                'guncellenen_urun' => count($stokVerileri)
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Stok güncelleme hatası', [
                'magaza_id' => $magaza->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function fiyatGuncelle(Magaza $magaza, array $fiyatVerileri): array
    {
        try {
            $result = $this->platformService->fiyatGuncelle($magaza, $fiyatVerileri);
            
            Log::info('Fiyat güncelleme başarılı', [
                'magaza_id' => $magaza->id,
                'guncellenen_urun' => count($fiyatVerileri)
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Fiyat güncelleme hatası', [
                'magaza_id' => $magaza->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function siparisSenkronize(Magaza $magaza): array
    {
        try {
            $result = $this->platformService->siparisSenkronize($magaza);
            
            Log::info('Sipariş senkronizasyonu başarılı', [
                'magaza_id' => $magaza->id,
                'yeni_siparis' => $result['yeni_siparis'] ?? 0
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Sipariş senkronizasyonu hatası', [
                'magaza_id' => $magaza->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function getMagazaIstatistikleri(Magaza $magaza): array
    {
        return [
            'toplam_urun' => $magaza->urunler()->count(),
            'aktif_urun' => $magaza->urunler()->where('durum', true)->count(),
            'toplam_siparis' => $magaza->siparisler()->count(),
            'bekleyen_siparis' => $magaza->siparisler()->where('durum', 'beklemede')->count(),
            'son_senkron' => $magaza->son_senkron,
            'senkron_durum' => $magaza->getLastSyncStatus(),
            'baglanti_durum' => $magaza->durum ? 'Aktif' : 'Pasif'
        ];
    }

    public function topluSenkronize(array $magazaIds): array
    {
        $sonuclar = [];
        
        foreach ($magazaIds as $magazaId) {
            $magaza = Magaza::find($magazaId);
            
            if (!$magaza) {
                $sonuclar[$magazaId] = [
                    'status' => 'error',
                    'message' => 'Mağaza bulunamadı'
                ];
                continue;
            }

            try {
                $result = $this->senkronize($magaza);
                $sonuclar[$magazaId] = [
                    'status' => 'success',
                    'message' => 'Başarılı',
                    'data' => $result
                ];
            } catch (\Exception $e) {
                $sonuclar[$magazaId] = [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        return $sonuclar;
    }
}
