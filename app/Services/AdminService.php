<?php

namespace App\Services;

use App\Models\Kullanici;
use App\Models\Bayi;
use App\Models\Siparis;
use App\Models\Urun;

class AdminService
{
    public function dashboardStats(): array
    {
        return [
            'toplam_kullanici' => Kullanici::count(),
            'toplam_bayi' => Bayi::count(),
            'toplam_urun' => Urun::count(),
            'toplam_siparis' => Siparis::count(),
            'aktif_bayiler' => Bayi::where('durum', 'aktif')->count(),
            'bekleyen_siparisler' => Siparis::where('durum', 'beklemede')->count(),
            'son_siparisler' => Siparis::with('kullanici', 'bayi')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
        ];
    }

    public function bayiListesiniGetir()
    {
        return Bayi::with('kullanici')->get();
    }

    public function siparisListesiniGetir()
    {
        return Siparis::with('kullanici', 'bayi', 'siparisUrunleri')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}



