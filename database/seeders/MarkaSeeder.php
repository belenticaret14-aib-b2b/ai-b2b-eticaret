<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marka;
use Illuminate\Support\Str;

class MarkaSeeder extends Seeder
{
    public function run(): void
    {
        $markalar = [
            ['ad' => 'Genel', 'aciklama' => 'Genel marka'],
            ['ad' => 'Acme', 'aciklama' => 'Kaliteli ürünler'],
            ['ad' => 'TechPro', 'aciklama' => 'Teknoloji markası'],
            ['ad' => 'HomeLine', 'aciklama' => 'Ev ürünleri'],
        ];

        foreach ($markalar as $m) {
            $data = $m;
            $data['slug'] = Str::slug($m['ad']);
            Marka::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
