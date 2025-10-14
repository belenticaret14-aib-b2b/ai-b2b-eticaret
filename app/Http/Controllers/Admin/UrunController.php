<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Kategori;
use App\Models\Marka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UrunController extends Controller
{
    /**
     * Ürün listesi
     */
    public function index(Request $request)
    {
        $query = Urun::with(['kategori', 'marka']);

        // Arama
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->where('ad', 'like', '%' . $request->q . '%')
                  ->orWhere('sku', 'like', '%' . $request->q . '%')
                  ->orWhere('aciklama', 'like', '%' . $request->q . '%');
            });
        }

        // Kategori filtresi
        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Marka filtresi
        if ($request->marka_id) {
            $query->where('marka_id', $request->marka_id);
        }

        // Durum filtresi
        if ($request->durum !== null) {
            $query->where('durum', $request->durum);
        }

        // Stok filtresi
        if ($request->stok_durumu === 'dusuk') {
            $query->where('stok', '<', 10);
        } elseif ($request->stok_durumu === 'tukendi') {
            $query->where('stok', 0);
        }

        // Sıralama
        $sirala = $request->sirala ?? 'id_desc';
        switch ($sirala) {
            case 'ad_asc':
                $query->orderBy('ad', 'asc');
                break;
            case 'ad_desc':
                $query->orderBy('ad', 'desc');
                break;
            case 'fiyat_asc':
                $query->orderBy('fiyat', 'asc');
                break;
            case 'fiyat_desc':
                $query->orderBy('fiyat', 'desc');
                break;
            case 'stok_asc':
                $query->orderBy('stok', 'asc');
                break;
            case 'stok_desc':
                $query->orderBy('stok', 'desc');
                break;
            default:
                $query->latest('id');
                break;
        }

        $urunler = $query->paginate(20)->withQueryString();
        
        // Filtre seçenekleri
        $kategoriler = Kategori::orderBy('ad')->get();
        $markalar = Marka::orderBy('ad')->get();

        return view('admin.urunler.index', compact('urunler', 'kategoriler', 'markalar'));
    }

    /**
     * Yeni ürün formu
     */
    public function create()
    {
        $kategoriler = Kategori::orderBy('ad')->get();
        $markalar = Marka::orderBy('ad')->get();
        
        return view('admin.urunler.create', compact('kategoriler', 'markalar'));
    }

    /**
     * Ürün kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:urunler,sku',
            'aciklama' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoriler,id',
            'marka_id' => 'nullable|exists:markalar,id',
            'fiyat' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gorsel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'durum' => 'boolean',
            'seo_baslik' => 'nullable|string|max:255',
            'seo_aciklama' => 'nullable|string|max:255',
            'seo_anahtar_kelimeler' => 'nullable|string|max:255',
        ]);

        // Görsel yükleme
        if ($request->hasFile('gorsel')) {
            $gorsel = $request->file('gorsel');
            $gorselAdi = time() . '_' . Str::slug($validated['ad']) . '.' . $gorsel->getClientOriginalExtension();
            $gorsel->storeAs('public/urunler', $gorselAdi);
            $validated['gorsel'] = 'urunler/' . $gorselAdi;
        }

        // SEO bilgileri
        $validated['seo_baslik'] = $validated['seo_baslik'] ?? $validated['ad'];
        $validated['seo_aciklama'] = $validated['seo_aciklama'] ?? Str::limit($validated['aciklama'], 160);

        Urun::create($validated);

        return redirect()->route('admin.urun.index')
            ->with('success', 'Ürün başarıyla eklendi.');
    }

    /**
     * Ürün detayı
     */
    public function show(Urun $urun)
    {
        $urun->load(['kategori', 'marka']);
        return view('admin.urunler.show', compact('urun'));
    }

    /**
     * Ürün düzenleme formu
     */
    public function edit(Urun $urun)
    {
        $kategoriler = Kategori::orderBy('ad')->get();
        $markalar = Marka::orderBy('ad')->get();
        
        return view('admin.urunler.edit', compact('urun', 'kategoriler', 'markalar'));
    }

    /**
     * Ürün güncelle
     */
    public function update(Request $request, Urun $urun)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:urunler,sku,' . $urun->id,
            'aciklama' => 'nullable|string',
            'kategori_id' => 'required|exists:kategoriler,id',
            'marka_id' => 'nullable|exists:markalar,id',
            'fiyat' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gorsel' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'durum' => 'boolean',
            'seo_baslik' => 'nullable|string|max:255',
            'seo_aciklama' => 'nullable|string|max:255',
            'seo_anahtar_kelimeler' => 'nullable|string|max:255',
        ]);

        // Eski görseli sil
        if ($request->hasFile('gorsel') && $urun->gorsel) {
            Storage::delete('public/' . $urun->gorsel);
        }

        // Yeni görsel yükleme
        if ($request->hasFile('gorsel')) {
            $gorsel = $request->file('gorsel');
            $gorselAdi = time() . '_' . Str::slug($validated['ad']) . '.' . $gorsel->getClientOriginalExtension();
            $gorsel->storeAs('public/urunler', $gorselAdi);
            $validated['gorsel'] = 'urunler/' . $gorselAdi;
        }

        $urun->update($validated);

        return redirect()->route('admin.urun.index')
            ->with('success', 'Ürün başarıyla güncellendi.');
    }

    /**
     * Ürün sil
     */
    public function destroy(Urun $urun)
    {
        // Görseli sil
        if ($urun->gorsel) {
            Storage::delete('public/' . $urun->gorsel);
        }

        $urun->delete();

        return redirect()->route('admin.urun.index')
            ->with('success', 'Ürün başarıyla silindi.');
    }

    /**
     * Toplu işlemler
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:aktif,pasif,sil,kategori_guncelle,marka_guncelle',
            'urun_ids' => 'required|array',
            'urun_ids.*' => 'exists:urunler,id'
        ]);

        $urunIds = $request->urun_ids;

        switch ($request->action) {
            case 'aktif':
                Urun::whereIn('id', $urunIds)->update(['durum' => true]);
                $message = 'Seçilen ürünler aktif edildi.';
                break;

            case 'pasif':
                Urun::whereIn('id', $urunIds)->update(['durum' => false]);
                $message = 'Seçilen ürünler pasif edildi.';
                break;

            case 'sil':
                Urun::whereIn('id', $urunIds)->delete();
                $message = 'Seçilen ürünler silindi.';
                break;

            case 'kategori_guncelle':
                $request->validate(['kategori_id' => 'required|exists:kategoriler,id']);
                Urun::whereIn('id', $urunIds)->update(['kategori_id' => $request->kategori_id]);
                $message = 'Seçilen ürünlerin kategorisi güncellendi.';
                break;

            case 'marka_guncelle':
                $request->validate(['marka_id' => 'required|exists:markalar,id']);
                Urun::whereIn('id', $urunIds)->update(['marka_id' => $request->marka_id]);
                $message = 'Seçilen ürünlerin markası güncellendi.';
                break;
        }

        return redirect()->route('admin.urun.index')->with('success', $message);
    }
}