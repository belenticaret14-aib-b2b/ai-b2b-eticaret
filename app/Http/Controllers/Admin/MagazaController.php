<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magaza;
use App\Models\Urun;
use App\Services\PlatformEntegrasyonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MagazaController extends Controller
{
    protected $platformService;

    public function __construct(PlatformEntegrasyonService $platformService)
    {
        $this->platformService = $platformService;
    }

    public function index(Request $request)
    {
        $query = Magaza::query();

        // Arama filtresi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ad', 'like', "%{$search}%")
                  ->orWhere('platform', 'like', "%{$search}%");
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

        $magazalar = $query->latest('id')->paginate(15)->withQueryString();

        // Her mağaza için ürün sayısı ve istatistikler
        $magazaIstatistik = [];
        foreach ($magazalar as $magaza) {
            $urunSayisi = DB::table('magaza_urun')->where('magaza_id', $magaza->id)->count();
            $sonSenkron = $magaza->son_senkron_tarihi ?? 'Hiç';
            
            $magazaIstatistik[$magaza->id] = [
                'urun_sayisi' => $urunSayisi,
                'son_senkron' => $sonSenkron,
                'durum' => $magaza->aktif ? 'Aktif' : 'Pasif',
                'senkron_status' => $this->getSenkronStatus($magaza)
            ];
        }

        // Platform istatistikleri
        $platformStats = [
            'toplam_magaza' => Magaza::count(),
            'aktif_magaza' => Magaza::where('aktif', true)->count(),
            'trendyol' => Magaza::where('platform', 'Trendyol')->count(),
            'hepsiburada' => Magaza::where('platform', 'Hepsiburada')->count(),
            'n11' => Magaza::where('platform', 'N11')->count(),
        ];

        $platformlar = ['Trendyol', 'Hepsiburada', 'N11', 'Amazon', 'Pazarama', 'GittiGidiyor'];

        return view('admin.magaza.index', compact(
            'magazalar', 
            'magazaIstatistik', 
            'platformStats',
            'platformlar'
        ));
    }

    public function create()
    {
        $platformlar = [
            'Trendyol' => ['api_url' => 'https://api.trendyol.com', 'test_mode' => true],
            'Hepsiburada' => ['api_url' => 'https://api.hepsiburada.com', 'test_mode' => true],
            'N11' => ['api_url' => 'https://api.n11.com', 'test_mode' => true],
            'Amazon' => ['api_url' => 'https://api.amazon.com', 'test_mode' => true],
            'Pazarama' => ['api_url' => 'https://api.pazarama.com', 'test_mode' => true],
            'GittiGidiyor' => ['api_url' => 'https://api.gittigidiyor.com', 'test_mode' => true],
        ];

        return view('admin.magaza.create', compact('platformlar'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ad' => ['required','string','max:255'],
            'platform' => ['required','string','max:100'],
            'api_anahtari' => ['nullable','string','max:255'],
            'api_gizli_anahtari' => ['nullable','string','max:255'],
            'api_url' => ['nullable','url','max:255'],
            'magaza_id' => ['nullable','string','max:100'],
            'komisyon_orani' => ['nullable','numeric','min:0','max:100'],
            'auto_senkron' => ['boolean'],
            'aktif' => ['boolean'],
            'test_mode' => ['boolean'],
            'aciklama' => ['nullable','string','max:500'],
        ]);

        $data['aktif'] = $request->has('aktif');
        $data['auto_senkron'] = $request->has('auto_senkron');
        $data['test_mode'] = $request->has('test_mode');
        $data['son_senkron_tarihi'] = null;

        $magaza = Magaza::create($data);

        // API bağlantısını test et
        if ($request->has('test_connection')) {
            $testResult = $this->testConnection($magaza);
            if ($testResult['success']) {
                $magaza->update(['son_baglanti_testi' => now()]);
                return redirect()->route('admin.magaza.index')
                    ->with('success', "✅ Mağaza eklendi ve API bağlantısı başarılı!");
            } else {
                return redirect()->route('admin.magaza.index')
                    ->with('warning', "⚠️ Mağaza eklendi ancak API bağlantısında sorun var: " . $testResult['message']);
            }
        }

        return redirect()->route('admin.magaza.index')->with('success', '✅ Mağaza başarıyla eklendi!');
    }

    public function show(Magaza $magaza)
    {
        // Mağazaya ait ürünler
        $urunler = DB::table('magaza_urun')
            ->join('urunler', 'urunler.id', '=', 'magaza_urun.urun_id')
            ->where('magaza_urun.magaza_id', $magaza->id)
            ->select('urunler.*')
            ->paginate(20);

        // Senkronizasyon logları (mock data)
        $senkronLoglar = collect([
            [
                'tarih' => now()->subHours(2),
                'islem' => 'Ürün senkronizasyonu',
                'sonuc' => 'Başarılı',
                'detay' => '25 ürün güncellendi',
                'durum' => 'success'
            ],
            [
                'tarih' => now()->subHours(6),
                'islem' => 'Stok güncelleme',
                'sonuc' => 'Başarılı',
                'detay' => '142 ürün stoku güncellendi',
                'durum' => 'success'
            ],
            [
                'tarih' => now()->subHours(12),
                'islem' => 'Fiyat senkronizasyonu',
                'sonuc' => 'Hata',
                'detay' => 'API limiti aşıldı',
                'durum' => 'error'
            ],
        ]);

        // Performans metrikleri
        $performans = [
            'toplam_urun' => DB::table('magaza_urun')->where('magaza_id', $magaza->id)->count(),
            'aktif_urun' => DB::table('magaza_urun')
                ->join('urunler', 'urunler.id', '=', 'magaza_urun.urun_id')
                ->where('magaza_urun.magaza_id', $magaza->id)
                ->where('urunler.aktif', true)
                ->count(),
            'son_senkron' => $magaza->son_senkron_tarihi ? $magaza->son_senkron_tarihi->diffForHumans() : 'Hiç',
            'api_durumu' => $this->getApiDurumu($magaza),
        ];

        return view('admin.magaza.show', compact('magaza', 'urunler', 'senkronLoglar', 'performans'));
    }

    public function edit(Magaza $magaza)
    {
        $platformlar = [
            'Trendyol' => ['api_url' => 'https://api.trendyol.com', 'test_mode' => true],
            'Hepsiburada' => ['api_url' => 'https://api.hepsiburada.com', 'test_mode' => true],
            'N11' => ['api_url' => 'https://api.n11.com', 'test_mode' => true],
            'Amazon' => ['api_url' => 'https://api.amazon.com', 'test_mode' => true],
            'Pazarama' => ['api_url' => 'https://api.pazarama.com', 'test_mode' => true],
            'GittiGidiyor' => ['api_url' => 'https://api.gittigidiyor.com', 'test_mode' => true],
        ];

        return view('admin.magaza.edit', compact('magaza', 'platformlar'));
    }

    public function update(Request $request, Magaza $magaza)
    {
        $data = $request->validate([
            'ad' => ['required','string','max:255'],
            'platform' => ['required','string','max:100'],
            'api_anahtari' => ['nullable','string','max:255'],
            'api_gizli_anahtari' => ['nullable','string','max:255'],
            'api_url' => ['nullable','url','max:255'],
            'magaza_id' => ['nullable','string','max:100'],
            'komisyon_orani' => ['nullable','numeric','min:0','max:100'],
            'auto_senkron' => ['boolean'],
            'aktif' => ['boolean'],
            'test_mode' => ['boolean'],
            'aciklama' => ['nullable','string','max:500'],
        ]);

        $data['aktif'] = $request->has('aktif');
        $data['auto_senkron'] = $request->has('auto_senkron');
        $data['test_mode'] = $request->has('test_mode');

        $magaza->update($data);

        return redirect()->route('admin.magaza.index')->with('success', '✅ Mağaza başarıyla güncellendi!');
    }

    public function destroy(Magaza $magaza)
    {
        // Önce ürün eşleştirmelerini sil
        DB::table('magaza_urun')->where('magaza_id', $magaza->id)->delete();
        
        $magaza->delete();
        
        return redirect()->route('admin.magaza.index')->with('success', '✅ Mağaza başarıyla silindi!');
    }

    // API Bağlantı Testi
    public function testConnection(Magaza $magaza)
    {
        try {
            // Platform service üzerinden test
            $result = $this->platformService->testConnection($magaza->platform, [
                'api_key' => $magaza->api_anahtari,
                'api_secret' => $magaza->api_gizli_anahtari,
                'api_url' => $magaza->api_url,
                'test_mode' => $magaza->test_mode,
            ]);

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
                'data' => $result['data'] ?? null
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bağlantı testi sırasında hata: ' . $e->getMessage()
            ]);
        }
    }

    // Ürün Senkronizasyonu
    public function senkronize(Request $request, Magaza $magaza)
    {
        try {
            $islemTuru = $request->get('islem', 'urun'); // urun, stok, fiyat
            
            $result = $this->platformService->senkronize($magaza, $islemTuru);
            
            // Son senkron tarihini güncelle
            $magaza->update(['son_senkron_tarihi' => now()]);

            if ($result['success']) {
                return back()->with('success', "✅ {$islemTuru} senkronizasyonu başarılı: " . $result['message']);
            } else {
                return back()->with('error', "❌ Senkronizasyon hatası: " . $result['message']);
            }

        } catch (\Exception $e) {
            return back()->with('error', '❌ Senkronizasyon sırasında hata: ' . $e->getMessage());
        }
    }

    // Toplu İşlemler
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,sync_all,test_all',
            'magaza_ids' => 'required|array',
            'magaza_ids.*' => 'exists:magazalar,id',
        ]);

        $magazaIds = $request->magaza_ids;
        $action = $request->action;

        switch ($action) {
            case 'activate':
                Magaza::whereIn('id', $magazaIds)->update(['aktif' => true]);
                return back()->with('success', '✅ Seçili mağazalar aktifleştirildi!');

            case 'deactivate':
                Magaza::whereIn('id', $magazaIds)->update(['aktif' => false]);
                return back()->with('success', '✅ Seçili mağazalar pasifleştirildi!');

            case 'sync_all':
                $başarılı = 0;
                $hatalı = 0;
                
                foreach ($magazaIds as $id) {
                    $magaza = Magaza::find($id);
                    try {
                        $result = $this->platformService->senkronize($magaza, 'urun');
                        if ($result['success']) {
                            $başarılı++;
                            $magaza->update(['son_senkron_tarihi' => now()]);
                        } else {
                            $hatalı++;
                        }
                    } catch (\Exception $e) {
                        $hatalı++;
                    }
                }
                
                return back()->with('success', "✅ Senkronizasyon tamamlandı: {$başarılı} başarılı, {$hatalı} hatalı");

            case 'test_all':
                $başarılı = 0;
                $hatalı = 0;
                
                foreach ($magazaIds as $id) {
                    $magaza = Magaza::find($id);
                    $result = $this->testConnection($magaza);
                    if ($result['success']) {
                        $başarılı++;
                        $magaza->update(['son_baglanti_testi' => now()]);
                    } else {
                        $hatalı++;
                    }
                }
                
                return back()->with('success', "✅ Bağlantı testleri tamamlandı: {$başarılı} başarılı, {$hatalı} hatalı");
        }

        return back()->with('error', '❌ İşlem gerçekleştirilemedi!');
    }

    // Yardımcı metodlar
    private function getSenkronStatus($magaza)
    {
        if (!$magaza->son_senkron_tarihi) {
            return ['status' => 'never', 'class' => 'bg-gray-100 text-gray-800', 'text' => 'Hiç'];
        }

        $diff = now()->diffInHours($magaza->son_senkron_tarihi);
        
        if ($diff < 1) {
            return ['status' => 'recent', 'class' => 'bg-green-100 text-green-800', 'text' => 'Güncel'];
        } elseif ($diff < 24) {
            return ['status' => 'old', 'class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Eski'];
        } else {
            return ['status' => 'very_old', 'class' => 'bg-red-100 text-red-800', 'text' => 'Çok Eski'];
        }
    }

    private function getApiDurumu($magaza)
    {
        // Mock API durumu kontrolü
        $statuses = ['online', 'offline', 'limited'];
        return $statuses[array_rand($statuses)];
    }
}
 
