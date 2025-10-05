<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Urun;

class UrunSeeder extends Seeder
{
    public function run(): void
    {
        Urun::firstOrCreate(
            ['ad' => 'Barkodlu Kalem'],
            [
                'aciklama' => 'Okul ve ofisler için uygun fiyatlı kalem.',
                'fiyat' => 12.50,
                'stok' => 150,
                'barkod' => '8691234567890',
                'gorsel' => 'https://placehold.co/600x400?text=Kalem',
            ]
        );
        Urun::firstOrCreate(
            ['ad' => 'Barkodlu Defter'],
            [
                'aciklama' => 'Kaliteli kapak ve kâğıt, çizgili defter.',
                'fiyat' => 25.00,
                'stok' => 80,
                'barkod' => '8699876543210',
                'gorsel' => 'https://placehold.co/600x400?text=Defter',
            ]
        );
    }
}