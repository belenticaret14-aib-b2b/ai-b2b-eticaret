<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Magaza;
use App\Services\MagazaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MagazaController extends Controller
{
    public function __construct(
        private MagazaService $magazaService
    ) {}

    public function index(Request $request)
    {
        $query = Magaza::query();

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ad', 'like', "%{$search}%")
                  ->orWhere('platform', 'like', "%{$search}%")
                  ->orWhere('platform_kodu', 'like', "%{$search}%");
            });
        }

        // Platform filtresi
        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        // Durum filtresi
        if ($request->filled('durum')) {
            $query->where('aktif', $request->durum === 'aktif');
        }

        // Ana mağaza filtresi
        if ($request->filled('ana_magaza')) {
            $query->where('ana_magaza', $request->ana_magaza === 'ana');
        }

        $magazalar = $query->latest('id')->paginate(15)->withQueryString();

        // İstatistikler
        $istatistikler = [
            'toplam_magaza' => Magaza::count(),
            'ana_magaza' => Magaza::where('ana_magaza', true)->count(),
            'alt_magaza' => Magaza::where('ana_magaza', false)->count(),
            'aktif_magaza' => Magaza::where('aktif', true)->count(),
            'platform_dagilim' => Magaza::select('platform', DB::raw('count(*) as sayi'))
                ->groupBy('platform')
                ->pluck('sayi', 'platform')
                ->toArray(),
        ];

        return view('super-admin.magazalar', compact('magazalar', 'istatistikler'));
    }

    public function create()
    {
        $platformlar = config('eticaret.platformlar', []);
        return view('super-admin.magaza-create', compact('platformlar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'platform_kodu' => 'nullable|string|max:255',
            'api_anahtari' => 'nullable|string',
            'api_gizli_anahtari' => 'nullable|string',
            'api_url' => 'nullable|url',
            'komisyon_orani' => 'nullable|numeric|min:0|max:100',
            'auto_senkron' => 'boolean',
            'aktif' => 'boolean',
            'test_mode' => 'boolean',
            'ana_magaza' => 'boolean',
            'aciklama' => 'nullable|string',
        ]);

        $magaza = Magaza::create($request->all());

        return redirect()
            ->route('super-admin.magazalar')
            ->with('success', "Mağaza '{$magaza->ad}' başarıyla oluşturuldu.");
    }

    public function show(Magaza $magaza)
    {
        $magaza->load(['urunler', 'kullanicilar', 'senkronLoglar' => function($query) {
            $query->latest()->limit(10);
        }]);

        $istatistikler = [
            'toplam_urun' => $magaza->urunler()->count(),
            'toplam_kullanici' => $magaza->kullanicilar()->count(),
            'son_senkron' => $magaza->senkronLoglar()->latest()->first(),
            'senkron_durum' => $magaza->getLastSyncStatus(),
        ];

        return view('super-admin.magaza-show', compact('magaza', 'istatistikler'));
    }

    public function edit(Magaza $magaza)
    {
        $platformlar = config('eticaret.platformlar', []);
        return view('super-admin.magaza-edit', compact('magaza', 'platformlar'));
    }

    public function update(Request $request, Magaza $magaza)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'platform_kodu' => 'nullable|string|max:255',
            'api_anahtari' => 'nullable|string',
            'api_gizli_anahtari' => 'nullable|string',
            'api_url' => 'nullable|url',
            'komisyon_orani' => 'nullable|numeric|min:0|max:100',
            'auto_senkron' => 'boolean',
            'aktif' => 'boolean',
            'test_mode' => 'boolean',
            'ana_magaza' => 'boolean',
            'aciklama' => 'nullable|string',
        ]);

        $magaza->update($request->all());

        return redirect()
            ->route('super-admin.magazalar')
            ->with('success', "Mağaza '{$magaza->ad}' başarıyla güncellendi.");
    }

    public function destroy(Magaza $magaza)
    {
        $magazaAdi = $magaza->ad;
        
        // Ana mağaza silinmesin
        if ($magaza->ana_magaza) {
            return redirect()
                ->route('super-admin.magazalar')
                ->with('error', 'Ana mağaza silinemez!');
        }

        $magaza->delete();

        return redirect()
            ->route('super-admin.magazalar')
            ->with('success', "Mağaza '{$magazaAdi}' başarıyla silindi.");
    }

    public function testConnection(Magaza $magaza)
    {
        try {
            $result = $this->magazaService->testConnection($magaza);
            
            return response()->json([
                'success' => true,
                'message' => 'Bağlantı başarılı!',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bağlantı hatası: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sync(Magaza $magaza)
    {
        try {
            $result = $this->magazaService->senkronize($magaza);
            
            return response()->json([
                'success' => true,
                'message' => 'Senkronizasyon başarılı!',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Senkronizasyon hatası: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(Magaza $magaza)
    {
        $magaza->update(['aktif' => !$magaza->aktif]);
        
        $durum = $magaza->aktif ? 'aktif' : 'pasif';
        
        return redirect()
            ->route('super-admin.magazalar')
            ->with('success', "Mağaza '{$magaza->ad}' {$durum} duruma getirildi.");
    }

    public function setAsMain(Magaza $magaza)
    {
        // Diğer ana mağazaları pasif yap
        Magaza::where('ana_magaza', true)->update(['ana_magaza' => false]);
        
        // Bu mağazayı ana mağaza yap
        $magaza->update(['ana_magaza' => true]);
        
        return redirect()
            ->route('super-admin.magazalar')
            ->with('success', "Mağaza '{$magaza->ad}' ana mağaza olarak ayarlandı.");
    }
}
