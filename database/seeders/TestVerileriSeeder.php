<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestVerileriSeeder extends Seeder
{
    public function run(): void
    {
        // Kullanıcılar
        DB::table('kullanicilar')->insert([
            ['ad' => 'Admin Kullanıcı', 'email' => 'admin@test.com', 'sifre' => bcrypt('123456'), 'rol' => 'admin'],
            ['ad' => 'Müşteri Kullanıcı', 'email' => 'musteri@test.com', 'sifre' => bcrypt('123456'), 'rol' => 'musteri'],
        ]);

        // Ürünler
        DB::table('urunler')->insert([
            ['ad' => 'Laptop', 'aciklama' => 'Güçlü oyun laptopu', 'fiyat' => 25000, 'stok' => 10],
            ['ad' => 'Telefon', 'aciklama' => 'Akıllı telefon', 'fiyat' => 15000, 'stok' => 20],
            ['ad' => 'Kulaklık', 'aciklama' => 'Bluetooth kulaklık', 'fiyat' => 500, 'stok' => 50],
        ]);

        // Mağazalar
        DB::table('magazalar')->insert([
            ['ad' => 'Trendyol', 'entegrasyon_turu' => 'trendyol', 'api_anahtari' => 'demoKey1', 'api_gizli_anahtar' => 'demoSecret1'],
            ['ad' => 'Hepsiburada', 'entegrasyon_turu' => 'hepsiburada', 'api_anahtari' => 'demoKey2', 'api_gizli_anahtar' => 'demoSecret2'],
        ]);
    }
}
