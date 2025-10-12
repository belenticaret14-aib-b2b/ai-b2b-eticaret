<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kullanici;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Süper Admin kullanıcısı oluştur
        Kullanici::create([
            'ad' => 'Süper Admin',
            'email' => 'superadmin@aib2b.local',
            'password' => Hash::make('password'),
            'rol' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        // Mağaza Admin kullanıcısı oluştur
        Kullanici::create([
            'ad' => 'Mağaza Admin',
            'email' => 'storeadmin@aib2b.local',
            'password' => Hash::make('password'),
            'rol' => 'store_admin',
            'email_verified_at' => now(),
        ]);

        // Bayi Admin kullanıcısı oluştur
        Kullanici::create([
            'ad' => 'Bayi Admin',
            'email' => 'dealeradmin@aib2b.local',
            'password' => Hash::make('password'),
            'rol' => 'dealer_admin',
            'email_verified_at' => now(),
        ]);
    }
}