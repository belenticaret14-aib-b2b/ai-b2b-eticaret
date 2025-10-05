<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DemoKullanicilarSeeder::class,
            KullaniciSeeder::class,
            MarkaSeeder::class,
            KategoriSeeder::class,
            MagazaSeeder::class,
            UrunSeeder::class,
            BayiSeeder::class,
            SiteAyarSeeder::class,
            SayfaIcerikSeeder::class,
        ]);
    }
}