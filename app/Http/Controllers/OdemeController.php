<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Siparis;
use App\Models\SiparisUrunu;
use App\Models\Kullanici;
use App\Models\Magaza;
use Illuminate\Support\Str;

class OdemeController extends Controller
{
    /**
     * Ödeme sayfası
     */
    public function index()
    {
        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        
        if (empty($sepet['items'])) {
            return redirect()->route('sepet')->with('error', 'Sepetiniz boş!');
        }

        // Kullanıcı bilgileri (giriş yapmışsa)
        $kullanici = Auth::user();
        
        return view('odeme.index', compact('sepet', 'kullanici'));
    }

    /**
     * Ödeme işlemi
     */
    public function islem(Request $request)
    {
        $validated = $request->validate([
            'odeme_yontemi' => 'required|in:nakit,kredi_karti,banka_havalesi,kredi_limiti',
            'teslimat_bilgileri' => 'required|array',
            'teslimat_bilgileri.ad_soyad' => 'required|string|max:255',
            'teslimat_bilgileri.telefon' => 'required|string|max:20',
            'teslimat_bilgileri.email' => 'required|email|max:255',
            'teslimat_bilgileri.adres' => 'required|string|max:500',
            'teslimat_bilgileri.sehir' => 'required|string|max:100',
            'teslimat_bilgileri.ilce' => 'required|string|max:100',
            'teslimat_bilgileri.posta_kodu' => 'nullable|string|max:10',
            'fatura_bilgileri' => 'nullable|array',
            'notlar' => 'nullable|string|max:1000',
        ]);

        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        
        if (empty($sepet['items'])) {
            return redirect()->route('sepet')->with('error', 'Sepetiniz boş!');
        }

        try {
            DB::beginTransaction();

            // Sipariş oluştur
            $siparis = $this->siparisOlustur($validated, $sepet);
            
            // Sepeti temizle
            session(['sepet' => ['items' => [], 'total' => 0]]);
            
            DB::commit();

            return redirect()->route('siparis.detay', $siparis->id)
                ->with('success', 'Siparişiniz başarıyla oluşturuldu!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Sipariş oluşturulurken hata oluştu: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Sipariş oluştur
     */
    private function siparisOlustur(array $validated, array $sepet): Siparis
    {
        $kullanici = Auth::user();
        
        // Sipariş numarası oluştur
        $siparisNo = 'SP' . date('Ymd') . '-' . strtoupper(Str::random(6));
        
        // Kargo tutarı hesapla (basit hesaplama)
        $kargoTutari = $this->kargoTutariHesapla($sepet['total']);
        
        // Vergi hesapla (%18 KDV)
        $vergiTutari = $sepet['total'] * 0.18;
        
        // Net tutar
        $netTutar = $sepet['total'] + $kargoTutari + $vergiTutari;

        // Sipariş oluştur
        $siparis = Siparis::create([
            'siparis_no' => $siparisNo,
            'kullanici_id' => $kullanici?->id,
            'magaza_id' => null, // Ana mağaza
            'platform_siparis_id' => null,
            'durum' => 'yeni',
            'odeme_durumu' => 'bekliyor',
            'kargo_durumu' => 'hazirlaniyor',
            'toplam_tutar' => $sepet['total'],
            'indirim_tutari' => 0,
            'kargo_tutari' => $kargoTutari,
            'vergi_tutari' => $vergiTutari,
            'net_tutar' => $netTutar,
            'odeme_yontemi' => $validated['odeme_yontemi'],
            'kargo_firmasi' => 'yurtici', // Varsayılan
            'kargo_takip_no' => null,
            'fatura_bilgileri' => $validated['fatura_bilgileri'] ?? null,
            'teslimat_bilgileri' => $validated['teslimat_bilgileri'],
            'notlar' => $validated['notlar'] ?? null,
            'siparis_tarihi' => now(),
        ]);

        // Sipariş ürünlerini ekle
        foreach ($sepet['items'] as $item) {
            SiparisUrunu::create([
                'siparis_id' => $siparis->id,
                'urun_id' => $item['id'],
                'urun_adi' => $item['ad'],
                'urun_fiyati' => $item['fiyat'],
                'adet' => $item['adet'],
                'toplam_tutar' => $item['fiyat'] * $item['adet'],
            ]);
        }

        return $siparis;
    }

    /**
     * Kargo tutarı hesapla
     */
    private function kargoTutariHesapla(float $tutar): float
    {
        // Basit kargo hesaplama
        if ($tutar >= 500) {
            return 0; // Ücretsiz kargo
        } elseif ($tutar >= 200) {
            return 15; // 15 TL
        } else {
            return 25; // 25 TL
        }
    }

    /**
     * Sipariş detay sayfası
     */
    public function siparisDetay($id)
    {
        $siparis = Siparis::with(['urunler', 'kullanici'])
            ->where('id', $id)
            ->firstOrFail();

        // Sadece sipariş sahibi veya admin görebilir
        if (Auth::user() && Auth::user()->id !== $siparis->kullanici_id && !Auth::user()->hasRole('super_admin')) {
            abort(403);
        }

        return view('odeme.siparis-detay', compact('siparis'));
    }
}

