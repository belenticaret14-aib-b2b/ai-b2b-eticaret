<?php

namespace App\Http\Controllers\DealerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Siparis;
use App\Models\Bayi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bayi = $user->bayi; // Kullanıcının bağlı olduğu bayi

        if (!$bayi) {
            return redirect()->route('dealer-admin.bayi-sec')
                           ->with('error', 'Henüz bir bayiliğe atanmamışsınız.');
        }

        $stats = [
            'toplam_urun' => Urun::where('durum', true)->count(),
            'bayi_urun' => $bayi->urunler()->count(),
            'toplam_siparis' => Siparis::where('bayi_id', $bayi->id)->count(),
            'bu_ay_siparis' => Siparis::where('bayi_id', $bayi->id)
                                    ->whereMonth('created_at', now()->month)->count(),
            'bekleyen_siparis' => Siparis::where('bayi_id', $bayi->id)
                                        ->where('durum', 'beklemede')->count(),
            'toplam_tutar' => Siparis::where('bayi_id', $bayi->id)
                                   ->where('durum', 'tamamlandi')
                                   ->sum('toplam_tutar'),
        ];

        $son_siparisler = Siparis::where('bayi_id', $bayi->id)
                                ->with(['kullanici', 'siparisUrunleri.urun'])
                                ->latest()
                                ->limit(10)
                                ->get();

        $populer_urunler = $bayi->urunler()
                               ->withCount('siparisUrunleri')
                               ->orderBy('siparis_urunleri_count', 'desc')
                               ->limit(5)
                               ->get();

        return view('dealer-admin.dashboard', compact('stats', 'son_siparisler', 'populer_urunler', 'bayi'));
    }

    public function bayiSec()
    {
        $bayiler = Bayi::where('durum', true)->get();
        return view('dealer-admin.bayi-sec', compact('bayiler'));
    }

    public function bayiAta(Request $request)
    {
        $request->validate([
            'bayi_id' => 'required|exists:bayiler,id'
        ]);

        $user = Auth::user();
        $user->bayi_id = $request->bayi_id;
        $user->save();

        return redirect()->route('dealer-admin.dashboard')
                       ->with('success', 'Bayilik başarıyla atandı.');
    }
}