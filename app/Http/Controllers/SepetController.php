<?php

namespace App\Http\Controllers;

use App\Models\Urun;
use Illuminate\Http\Request;

class SepetController extends Controller
{
    public function index()
    {
        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        return view('sepet.index', compact('sepet'));
    }

    public function ekle(Request $request)
    {
        $data = $request->validate([
            'urun_id' => ['required','integer','exists:urunler,id'],
            'adet' => ['nullable','integer','min:1'],
        ]);

        $urun = Urun::findOrFail($data['urun_id']);
        $adet = $data['adet'] ?? 1;

        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        // Aynı ürün varsa adeti artır
        $found = false;
        foreach ($sepet['items'] as &$item) {
            if ($item['id'] === $urun->id) {
                $item['adet'] += $adet;
                $found = true;
                break;
            }
        }
        unset($item);
        if (!$found) {
            $sepet['items'][] = [
                'id' => $urun->id,
                'ad' => $urun->ad,
                'fiyat' => (float)$urun->fiyat,
                'adet' => $adet,
                'gorsel' => $urun->gorsel,
            ];
        }

        $sepet['total'] = $this->hesaplaToplam($sepet['items']);
        session(['sepet' => $sepet]);

        return redirect()->back()->with('status', 'Ürün sepete eklendi.');
    }

    public function guncelle(Request $request)
    {
        $data = $request->validate([
            'urun_id' => ['required','integer'],
            'adet' => ['required','integer','min:1'],
        ]);
        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        foreach ($sepet['items'] as &$item) {
            if ($item['id'] === (int)$data['urun_id']) {
                $item['adet'] = (int)$data['adet'];
                break;
            }
        }
        unset($item);
        $sepet['total'] = $this->hesaplaToplam($sepet['items']);
        session(['sepet' => $sepet]);
        return back()->with('status', 'Sepet güncellendi.');
    }

    public function sil(Request $request)
    {
        $data = $request->validate([
            'urun_id' => ['required','integer'],
        ]);
        $sepet = session('sepet', ['items' => [], 'total' => 0]);
        $sepet['items'] = array_values(array_filter($sepet['items'], fn($i) => $i['id'] !== (int)$data['urun_id']));
        $sepet['total'] = $this->hesaplaToplam($sepet['items']);
        session(['sepet' => $sepet]);
        return back()->with('status', 'Ürün sepetten kaldırıldı.');
    }

    public function bosalt()
    {
        session(['sepet' => ['items' => [], 'total' => 0]]);
        return back()->with('status', 'Sepet boşaltıldı.');
    }

    private function hesaplaToplam(array $items): float
    {
        $toplam = 0;
        foreach ($items as $i) {
            $toplam += $i['fiyat'] * $i['adet'];
        }
        return $toplam;
    }
}
 