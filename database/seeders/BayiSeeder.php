<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bayi;
use App\Models\Kullanici;

class BayiSeeder extends Seeder
{
    public function run(): void
    {
        $bayiKullanici = Kullanici::updateOrCreate(
            ['email' => 'bayi@example.com'],
            [
                'ad' => 'Bayi Test',
                'password' => bcrypt('password'),
                'rol' => 'bayi',
            ]
        );

        Bayi::updateOrCreate(
            ['kullanici_id' => $bayiKullanici->id],
            [
                'ad' => 'Bayi Test',
                'email' => 'bayi@example.com',
                'telefon' => '5551234567',
                'adres' => 'Bayi Adresi',
            ]
        );
    }
}
