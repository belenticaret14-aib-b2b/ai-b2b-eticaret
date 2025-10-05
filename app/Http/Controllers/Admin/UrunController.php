<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Magaza;
use App\Models\Kategori;
use App\Models\Marka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UrunController extends Controller
{
    public function index(Request $request)
    {
        $query = Urun::with(['kategori', 'marka']);

        // Gelişmiş Filtreleme
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ad', 'like', "%{$search}%")
                  ->orWhere('barkod', 'like', "%{$search}%")
                  ->orWhere('aciklama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('marka_id')) {
            $query->where('marka_id', $request->marka_id);
        }

        if ($request->filled('stok_durumu')) {
            switch ($request->stok_durumu) {
                case 'dusuk':
                    $query->where('stok', '<=', 5);
                    break;
                case 'tukendi':
                    $query->where('stok', 0);
                    break;
                case 'normal':
                    $query->where('stok', '>', 5);
                    break;
            }
        }

        if ($request->filled('fiyat_min')) {
            $query->where('fiyat', '>=', $request->fiyat_min);
        }

        if ($request->filled('fiyat_max')) {
            $query->where('fiyat', '<=', $request->fiyat_max);
        }

        // Sıralama
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $urunler = $query->paginate(20)->withQueryString();

        // Mağaza eşleştirmeleri
        $urunMagazalari = [];
        if ($urunler->count() > 0) {
            $ids = $urunler->pluck('id')->all();
            $rows = DB::table('magaza_urun')
                ->join('magazalar', 'magazalar.id', '=', 'magaza_urun.magaza_id')
                ->whereIn('magaza_urun.urun_id', $ids)
                ->select('magaza_urun.urun_id', 'magazalar.id as magaza_id', 'magazalar.ad', 'magazalar.platform')
                ->get();
            foreach ($rows as $r) {
                $urunMagazalari[$r->urun_id][] = [
                    'id' => $r->magaza_id,
                    'ad' => $r->ad,
                    'platform' => $r->platform,
                ];
            }
        }

        // Filter seçenekleri
        $kategoriler = Kategori::orderBy('ad')->get();
        $markalar = Marka::orderBy('ad')->get();

        // İstatistikler
        $istatistikler = [
            'toplam_urun' => Urun::count(),
            'dusuk_stok' => Urun::where('stok', '<=', 5)->count(),
            'tukenen_urun' => Urun::where('stok', 0)->count(),
            'toplam_deger' => Urun::sum(DB::raw('stok * fiyat')),
        ];

        return view('admin.urun.index', compact(
            'urunler', 
            'urunMagazalari', 
            'kategoriler', 
            'markalar', 
            'istatistikler'
        ));
    }

    public function create()
    {
        $kategoriler = Kategori::orderBy('ad')->get();
        $markalar = Marka::orderBy('ad')->get();
        $magazalar = Magaza::orderBy('ad')->get();
        
        return view('admin.urun.create', compact('kategoriler', 'markalar', 'magazalar'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ad' => ['required','string','max:255'],
            'aciklama' => ['nullable','string'],
            'fiyat' => ['required','numeric','min:0'],
            'stok' => ['nullable','integer','min:0'],
            'barkod' => ['nullable','string','max:50', 'unique:urunler,barkod'],
            'kategori_id' => ['nullable','exists:kategoriler,id'],
            'marka_id' => ['nullable','exists:markalar,id'],
            'gorsel' => ['nullable','url'],
            'gorsel_dosya' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
            'magazalar' => ['nullable','array'],
            'magazalar.*' => ['integer','exists:magazalar,id'],
            'meta_title' => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string','max:500'],
            'aktif' => ['boolean'],
        ]);

        // SEO URL slug oluştur
        $data['slug'] = Str::slug($data['ad']);
        
        // Benzersiz slug kontrolü
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Urun::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Görsel yükleme
        if ($request->hasFile('gorsel_dosya')) {
            $path = $request->file('gorsel_dosya')->store('urunler', 'public');
            $data['gorsel'] = '/storage/' . $path;
        }

        $data['aktif'] = $request->has('aktif');

        $urun = Urun::create($data);

        // Mağaza eşleştirmeleri
        if ($request->filled('magazalar')) {
            $magazalar = $request->input('magazalar', []);
            $insert = array_map(fn($mid) => [
                'magaza_id' => (int)$mid, 
                'urun_id' => $urun->id,
                'created_at' => now(),
                'updated_at' => now()
            ], $magazalar);
            
            if (!empty($insert)) {
                DB::table('magaza_urun')->insert($insert);
            }
        }

        return redirect()->route('admin.urun.index')->with('success', '✅ Ürün başarıyla eklendi!');
    }

    public function show(Urun $urun)
    {
        $urun->load(['kategori', 'marka']);
        
        // Mağaza bilgileri
        $magazalar = DB::table('magaza_urun')
            ->join('magazalar', 'magazalar.id', '=', 'magaza_urun.magaza_id')
            ->where('magaza_urun.urun_id', $urun->id)
            ->select('magazalar.*')
            ->get();

        // Son işlemler (mock data)
        $sonIslemler = collect([
            ['tarih' => now()->subDays(1), 'islem' => 'Stok güncellendi', 'detay' => 'Stok: 15 → 12'],
            ['tarih' => now()->subDays(3), 'islem' => 'Fiyat değişti', 'detay' => '150₺ → 180₺'],
            ['tarih' => now()->subDays(5), 'islem' => 'Mağazaya eklendi', 'detay' => 'Trendyol entegrasyonu'],
        ]);

        return view('admin.urun.show', compact('urun', 'magazalar', 'sonIslemler'));
    }

    public function edit(Urun $urun)
    {
        $kategoriler = Kategori::orderBy('ad')->get();
        $markalar = Marka::orderBy('ad')->get();
        $magazalar = Magaza::orderBy('ad')->get();
        
        // Mevcut mağaza eşleştirmeleri
        $mevcutMagazalar = DB::table('magaza_urun')
            ->where('urun_id', $urun->id)
            ->pluck('magaza_id')
            ->toArray();

        return view('admin.urun.edit', compact('urun', 'kategoriler', 'markalar', 'magazalar', 'mevcutMagazalar'));
    }

    public function update(Request $request, Urun $urun)
    {
        $data = $request->validate([
            'ad' => ['required','string','max:255'],
            'aciklama' => ['nullable','string'],
            'fiyat' => ['required','numeric','min:0'],
            'stok' => ['nullable','integer','min:0'],
            'barkod' => ['nullable','string','max:50', 'unique:urunler,barkod,' . $urun->id],
            'kategori_id' => ['nullable','exists:kategoriler,id'],
            'marka_id' => ['nullable','exists:markalar,id'],
            'gorsel' => ['nullable','url'],
            'gorsel_dosya' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
            'magazalar' => ['nullable','array'],
            'magazalar.*' => ['integer','exists:magazalar,id'],
            'meta_title' => ['nullable','string','max:255'],
            'meta_description' => ['nullable','string','max:500'],
            'aktif' => ['boolean'],
        ]);

        // Slug güncelleme (ad değiştiyse)
        if ($data['ad'] !== $urun->ad) {
            $data['slug'] = Str::slug($data['ad']);
            
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Urun::where('slug', $data['slug'])->where('id', '!=', $urun->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Görsel yükleme
        if ($request->hasFile('gorsel_dosya')) {
            // Eski görseli sil
            if ($urun->gorsel && Storage::disk('public')->exists(str_replace('/storage/', '', $urun->gorsel))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $urun->gorsel));
            }
            
            $path = $request->file('gorsel_dosya')->store('urunler', 'public');
            $data['gorsel'] = '/storage/' . $path;
        }

        $data['aktif'] = $request->has('aktif');

        $urun->update($data);

        // Mağaza eşleştirmelerini güncelle
        DB::table('magaza_urun')->where('urun_id', $urun->id)->delete();
        
        if ($request->filled('magazalar')) {
            $magazalar = $request->input('magazalar', []);
            $insert = array_map(fn($mid) => [
                'magaza_id' => (int)$mid, 
                'urun_id' => $urun->id,
                'created_at' => now(),
                'updated_at' => now()
            ], $magazalar);
            
            if (!empty($insert)) {
                DB::table('magaza_urun')->insert($insert);
            }
        }

        return redirect()->route('admin.urun.index')->with('success', '✅ Ürün başarıyla güncellendi!');
    }

    public function destroy(Urun $urun)
    {
        // Görsel dosyasını sil
        if ($urun->gorsel && Storage::disk('public')->exists(str_replace('/storage/', '', $urun->gorsel))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $urun->gorsel));
        }

        // Mağaza eşleştirmelerini sil
        DB::table('magaza_urun')->where('urun_id', $urun->id)->delete();

        $urun->delete();
        
        return redirect()->route('admin.urun.index')->with('success', '✅ Ürün başarıyla silindi!');
    }

    // Toplu işlemler
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,update_stock',
            'urun_ids' => 'required|array',
            'urun_ids.*' => 'exists:urunler,id',
            'stock_value' => 'nullable|integer|min:0'
        ]);

        $urunIds = $request->urun_ids;
        $action = $request->action;

        switch ($action) {
            case 'delete':
                Urun::whereIn('id', $urunIds)->delete();
                return back()->with('success', '✅ Seçili ürünler silindi!');

            case 'activate':
                Urun::whereIn('id', $urunIds)->update(['aktif' => true]);
                return back()->with('success', '✅ Seçili ürünler aktifleştirildi!');

            case 'deactivate':
                Urun::whereIn('id', $urunIds)->update(['aktif' => false]);
                return back()->with('success', '✅ Seçili ürünler pasifleştirildi!');

            case 'update_stock':
                if ($request->filled('stock_value')) {
                    Urun::whereIn('id', $urunIds)->update(['stok' => $request->stock_value]);
                    return back()->with('success', '✅ Seçili ürünlerin stoku güncellendi!');
                }
                break;
        }

        return back()->with('error', '❌ İşlem gerçekleştirilemedi!');
    }
}
