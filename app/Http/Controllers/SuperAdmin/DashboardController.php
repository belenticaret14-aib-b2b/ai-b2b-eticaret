<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Kullanici;
use App\Models\Urun;
use App\Models\Siparis;
use App\Models\Magaza;
use App\Models\Bayi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'toplam_kullanici' => Kullanici::count(),
            'toplam_urun' => Urun::count(),
            'toplam_siparis' => Siparis::count(),
            'toplam_magaza' => Magaza::count(),
            'toplam_bayi' => Bayi::count(),
            'aktif_magaza' => Magaza::where('durum', true)->count(),
            'aktif_bayi' => Bayi::where('durum', true)->count(),
            'ana_magaza' => Magaza::where('ana_magaza', true)->count(),
            'bu_ay_siparis' => Siparis::whereMonth('created_at', now()->month)->count(),
        ];

        $son_siparisler = Siparis::with(['kullanici', 'siparisUrunleri.urun'])
                                ->latest()
                                ->limit(10)
                                ->get();

        $magaza_istatistikleri = Magaza::withCount('urunler')
                                      ->orderBy('urunler_count', 'desc')
                                      ->limit(5)
                                      ->get();

        return view('super-admin.dashboard', compact('stats', 'son_siparisler', 'magaza_istatistikleri'));
    }
}