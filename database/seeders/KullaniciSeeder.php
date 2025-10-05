<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KullaniciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kullanicilar = [
            [
                'ad' => 'Admin Kullanıcı',
                'email' => 'admin@b2b.com',
                'password' => \Hash::make('admin123'),
                'rol' => 'admin',
            ],
            [
                'ad' => 'Bayi Kullanıcı',
                'email' => 'bayi@b2b.com',
                'password' => \Hash::make('bayi123'),
                'rol' => 'bayi',
            ],
            [
                'ad' => 'Müşteri 1',
                'email' => 'musteri1@b2b.com',
                'password' => \Hash::make('musteri123'),
                'rol' => 'musteri',
            ],
            [
                'ad' => 'Müşteri 2',
                'email' => 'musteri2@b2b.com',
                'password' => \Hash::make('musteri123'),
                'rol' => 'musteri',
            ],
        ];

        foreach ($kullanicilar as $k) {
            \App\Models\Kullanici::firstOrCreate(
                ['email' => $k['email']],
                $k
            );
        }
    }
}
