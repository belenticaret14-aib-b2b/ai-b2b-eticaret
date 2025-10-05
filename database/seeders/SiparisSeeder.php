<?php

namespace Database\Seeders;

use App\Models\Siparis;
use Illuminate\Database\Seeder;

class SiparisSeeder extends Seeder
{
    public function run(): void
    {
        $siparisler = [
            [
                'kullanici_id' => 2,
                'toplam_tutar' => 63998.99,
                'durum' => 'onaylandı',
                'adres' => 'İstanbul, Kadıköy, Test Sokak 1',
            ],
            [
                'kullanici_id' => 3,
                'toplam_tutar' => 28999.00,
                'durum' => 'beklemede',
                'adres' => 'Ankara, Çankaya, Test Cadde 2',
            ]
        ];

        foreach ($siparisler as $siparis) {
            Siparis::create($siparis);
        }
    }
}
