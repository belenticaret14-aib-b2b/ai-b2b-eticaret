<?php

namespace App\Http\Controllers\StoreAdmin;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Siparis;
use App\Models\Magaza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $magaza = $user->magaza; // Kullanıcının bağlı olduğu mağaza

        if (!$magaza) {
            return redirect()->route('store-admin.magaza-sec')
                           ->with('error', 'Henüz bir mağazaya atanmamışsınız.');
        }

        $stats = [
            'toplam_urun' => $magaza->urunler()->count(),
            'aktif_urun' => $magaza->urunler()->where('durum', true)->count(),
            'toplam_siparis' => Siparis::whereHas('siparisUrunleri.urun', function($q) use ($magaza) {
                $q->whereIn('id', $magaza->urunler()->pluck('id'));
            })->count(),
            'bu_ay_siparis' => Siparis::whereHas('siparisUrunleri.urun', function($q) use ($magaza) {
                $q->whereIn('id', $magaza->urunler()->pluck('id'));
            })->whereMonth('created_at', now()->month)->count(),
            'senkron_urun' => $magaza->urunler()->wherePivot('senkron_durum', 'tamamlandi')->count(),
        ];

        $son_siparisler = Siparis::whereHas('siparisUrunleri.urun', function($q) use ($magaza) {
            $q->whereIn('id', $magaza->urunler()->pluck('id'));
        })->with(['kullanici', 'siparisUrunleri.urun'])
          ->latest()
          ->limit(10)
          ->get();

        $urun_istatistikleri = $magaza->urunler()
                                    ->withCount('siparisUrunleri')
                                    ->orderBy('siparis_urunleri_count', 'desc')
                                    ->limit(5)
                                    ->get();

        return view('store-admin.dashboard', compact('stats', 'son_siparisler', 'urun_istatistikleri', 'magaza'));
    }

    public function magazaSec()
    {
        $magazalar = Magaza::where('durum', true)->get();
        return view('store-admin.magaza-sec', compact('magazalar'));
    }

    public function magazaAta(Request $request)
    {
        $request->validate([
            'magaza_id' => 'required|exists:magazalar,id'
        ]);

        $user = Auth::user();
        $user->magaza_id = $request->magaza_id;
        $user->save();

        return redirect()->route('store-admin.dashboard')
                       ->with('success', 'Mağaza başarıyla atandı.');
    }
}