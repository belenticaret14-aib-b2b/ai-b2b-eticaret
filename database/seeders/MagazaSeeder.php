<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Magaza;

class MagazaSeeder extends Seeder
{
    public function run(): void
    {
        $veriler = [
            ['ad' => 'Trendyol Mağaza', 'platform' => 'Trendyol', 'entegrasyon_turu' => 'trendyol', 'api_anahtari' => null, 'api_gizli_anahtar' => null],
            ['ad' => 'Hepsiburada Mağaza', 'platform' => 'Hepsiburada', 'entegrasyon_turu' => 'hepsiburada', 'api_anahtari' => null, 'api_gizli_anahtar' => null],
            ['ad' => 'N11 Mağaza', 'platform' => 'N11', 'entegrasyon_turu' => 'n11', 'api_anahtari' => null, 'api_gizli_anahtar' => null],
        ];

        foreach ($veriler as $v) {
            Magaza::firstOrCreate(
                ['ad' => $v['ad']],
                [
                    'platform' => $v['platform'],
                    'entegrasyon_turu' => $v['entegrasyon_turu'],
                    'api_anahtari' => $v['api_anahtari'],
                    'api_gizli_anahtar' => $v['api_gizli_anahtar'],
                ]
            );
        }
    }
}
