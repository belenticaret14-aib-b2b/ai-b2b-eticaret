<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Bayi;
use App\Models\Magaza;
use App\Models\SiteAyar;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $urunSayisi = class_exists(Urun::class) ? Urun::count() : 0;
        $bayiSayisi = class_exists(Bayi::class) ? Bayi::count() : 0;
        $magazaSayisi = class_exists(Magaza::class) ? Magaza::count() : 0;
        $sonUrunler = class_exists(Urun::class) ? Urun::latest('id')->take(6)->get() : collect();

        // Site ayarlarını al
        $siteAyarlar = [];
        if (class_exists(SiteAyar::class)) {
            $siteAyarlar = SiteAyar::pluck('deger', 'anahtar')->toArray();
        }

        // Ek metrikler
        $stokToplam = 0;
        $stokDegeri = 0.0;
        $dusukStokler = collect();
        if (class_exists(Urun::class)) {
            // stok toplamı ve stok değeri
            $stokToplam = (int) Urun::sum('stok');
            $stokDegeri = (float) Urun::select(DB::raw('SUM(COALESCE(stok,0) * COALESCE(fiyat,0)) as toplam'))
                ->value('toplam');
            // düşük stok listesi (<=5)
            $dusukStokler = Urun::whereNotNull('stok')
                ->where('stok', '<=', 5)
                ->orderBy('stok')
                ->take(5)
                ->get();
        }

        return view('admin.dashboard', [
            'istatistik' => [
                'urun' => $urunSayisi,
                'bayi' => $bayiSayisi,
                'magaza' => $magazaSayisi,
            ],
            'sonUrunler' => $sonUrunler,
            'stokToplam' => $stokToplam,
            'stokDegeri' => $stokDegeri,
            'dusukStokler' => $dusukStokler,
            'siteAyarlar' => $siteAyarlar,
        ]);
    }
}
