<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriler = [
            ['ad' => 'Elektronik', 'aciklama' => 'Elektronik ürünler'],
            ['ad' => 'Ev & Yaşam', 'aciklama' => 'Ev eşyaları ve yaşam ürünleri'],
            ['ad' => 'Ofis', 'aciklama' => 'Ofis ve kırtasiye'],
        ];

        foreach ($kategoriler as $k) {
            $data = $k;
            $data['slug'] = Str::slug($k['ad']);
            Kategori::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
