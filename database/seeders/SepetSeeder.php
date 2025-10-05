<?php

namespace Database\Seeders;

use App\Models\Sepet;
use Illuminate\Database\Seeder;

class SepetSeeder extends Seeder
{
    public function run(): void
    {
        // Mevcut kullanıcı ve ürünleri al
        $kullanicilar = \App\Models\Kullanici::where('rol', '!=', 'admin')->take(3)->get();
        $urunler = \App\Models\Urun::take(3)->get();
        
        if ($kullanicilar->isEmpty() || $urunler->isEmpty()) {
            return; // Veri yoksa çık
        }

        $sepetler = [
            [
                'kullanici_id' => $kullanicilar->first()->id,
                'urun_id' => $urunler->first()->id,
                'adet' => 2,
            ],
            [
                'kullanici_id' => $kullanicilar->first()->id,
                'urun_id' => $urunler->skip(1)->first()->id ?? $urunler->first()->id,
                'adet' => 1,
            ],
            [
                'kullanici_id' => $kullanicilar->skip(1)->first()->id ?? $kullanicilar->first()->id,
                'urun_id' => $urunler->skip(2)->first()->id ?? $urunler->first()->id,
                'adet' => 1,
            ]
        ];

        foreach ($sepetler as $sepet) {
            Sepet::firstOrCreate(
                [
                    'kullanici_id' => $sepet['kullanici_id'],
                    'urun_id' => $sepet['urun_id']
                ],
                $sepet
            );
        }
    }
}
