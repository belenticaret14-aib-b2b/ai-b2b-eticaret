<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kullanici;
use App\Models\Bayi;

class DemoKullanicilarSeeder extends Seeder
{
    public function run(): void
    {
        // Admin kullanıcı
        $admin = Kullanici::updateOrCreate(
            ['email' => 'admin@aib2b.local'],
            [
                'ad' => 'Demo Admin',
                'password' => Hash::make('Admin123!'),
                'rol' => 'admin',
                'telefon' => '+90 212 000 0000',
                'adres' => 'İstanbul',
                'durum' => true,
                'email_verified_at' => now(),
            ]
        );

        // Bayi kullanıcı
        $bayiUser = Kullanici::updateOrCreate(
            ['email' => 'bayi@aib2b.local'],
            [
                'ad' => 'Demo Bayi Kullanıcı',
                'password' => Hash::make('Bayi123!'),
                'rol' => 'bayi',
                'telefon' => '+90 216 000 0000',
                'adres' => 'İstanbul',
                'durum' => true,
                'email_verified_at' => now(),
            ]
        );

        Bayi::updateOrCreate(
            ['kullanici_id' => $bayiUser->id],
            [
                'ad' => 'Demo Bayi Ltd. Şti.',
                'email' => 'bayi@aib2b.local',
                'telefon' => '+90 216 000 0000',
                'adres' => 'İstanbul',
            ]
        );

        // Müşteri kullanıcı
        Kullanici::updateOrCreate(
            ['email' => 'musteri@aib2b.local'],
            [
                'ad' => 'Demo Müşteri',
                'password' => Hash::make('Musteri123!'),
                'rol' => 'musteri',
                'telefon' => '+90 212 111 1111',
                'adres' => 'İstanbul',
                'durum' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
