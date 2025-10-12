<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Magaza;

class AnaMagazaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ana mağaza oluştur
        Magaza::create([
            'ad' => 'Ana Mağaza',
            'entegrasyon_turu' => 'ana_magaza',
            'api_anahtari' => null,
            'api_gizli_anahtar' => null,
            'platform_kodu' => 'ANA001',
            'api_base_url' => null,
            'durum' => true,
            'senkron_durum' => 'tamamlandi',
            'son_senkron' => now(),
            'ayarlar' => [
                'ana_magaza' => true,
                'merkezi_depo' => true,
                'stok_yonetimi' => true
            ],
            'webhook_url' => null,
            'webhook_secret' => null,
            'ana_magaza' => true,
        ]);

        // Trendyol mağazası oluştur
        Magaza::create([
            'ad' => 'Trendyol Mağazası',
            'entegrasyon_turu' => 'trendyol',
            'api_anahtari' => 'test_api_key',
            'api_gizli_anahtar' => 'test_api_secret',
            'platform_kodu' => 'TRD001',
            'api_base_url' => 'https://api.trendyol.com',
            'durum' => true,
            'senkron_durum' => 'tamamlandi',
            'son_senkron' => now(),
            'ayarlar' => [
                'platform' => 'trendyol',
                'auto_sync' => true,
                'price_markup' => 10
            ],
            'webhook_url' => null,
            'webhook_secret' => null,
            'ana_magaza' => false,
        ]);

        // Hepsiburada mağazası oluştur
        Magaza::create([
            'ad' => 'Hepsiburada Mağazası',
            'entegrasyon_turu' => 'hepsiburada',
            'api_anahtari' => 'test_api_key',
            'api_gizli_anahtar' => 'test_api_secret',
            'platform_kodu' => 'HBS001',
            'api_base_url' => 'https://api.hepsiburada.com',
            'durum' => true,
            'senkron_durum' => 'tamamlandi',
            'son_senkron' => now(),
            'ayarlar' => [
                'platform' => 'hepsiburada',
                'auto_sync' => true,
                'price_markup' => 8
            ],
            'webhook_url' => null,
            'webhook_secret' => null,
            'ana_magaza' => false,
        ]);
    }
}