<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Magaza;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleXMLElement;

class XmlController extends Controller
{
    /**
     * Ürünler XML Feed'i
     */
    public function urunlerXml(Request $request): Response
    {
        $platform = $request->get('platform', 'genel');
        $limit = min($request->get('limit', 1000), 5000);
        
        $urunler = Urun::with(['kategori', 'marka'])
                       ->aktif()
                       ->limit($limit)
                       ->get();

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urunler/>');
        
        foreach ($urunler as $urun) {
            $urunXml = $xml->addChild('urun');
            $urunXml->addChild('id', $urun->id);
            $urunXml->addChild('ad', htmlspecialchars($urun->ad));
            $urunXml->addChild('sku', htmlspecialchars($urun->sku));
            $urunXml->addChild('barkod', htmlspecialchars($urun->barkod));
            $urunXml->addChild('aciklama', htmlspecialchars($urun->aciklama));
            $urunXml->addChild('fiyat', $urun->fiyat);
            $urunXml->addChild('stok', $urun->stok);
            $urunXml->addChild('kategori', htmlspecialchars($urun->kategori?->ad));
            $urunXml->addChild('marka', htmlspecialchars($urun->marka?->ad));
            $urunXml->addChild('resim', $urun->getAnaResim());
            $urunXml->addChild('agirlik', $urun->agirlik);
            
            if ($urun->boyutlar) {
                $boyutlarXml = $urunXml->addChild('boyutlar');
                $boyutlarXml->addChild('en', $urun->boyutlar['en'] ?? '');
                $boyutlarXml->addChild('boy', $urun->boyutlar['boy'] ?? '');
                $boyutlarXml->addChild('yukseklik', $urun->boyutlar['yukseklik'] ?? '');
            }
            
            // Platform özel alanları
            if ($platform === 'trendyol') {
                $urunXml->addChild('tedarikci_stok_kodu', $urun->sku);
                $urunXml->addChild('pazaryeri_komisyon_orani', '15');
                $urunXml->addChild('kargo_profil_id', '1');
            } elseif ($platform === 'hepsiburada') {
                $urunXml->addChild('merchant_sku', $urun->sku);
                $urunXml->addChild('shipping_time', '1-3');
            } elseif ($platform === 'n11') {
                $urunXml->addChild('productSellerCode', $urun->sku);
                $urunXml->addChild('shipmentTemplate', 'Standart Kargo');
            }
        }

        return response($xml->asXML(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Stok XML Feed'i
     */
    public function stokXml(Request $request): Response
    {
        $platform = $request->get('platform', 'genel');
        $limit = min($request->get('limit', 1000), 5000);
        
        $urunler = Urun::aktif()
                       ->select(['id', 'sku', 'barkod', 'stok', 'ad'])
                       ->limit($limit)
                       ->get();

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><stok_listesi/>');
        
        foreach ($urunler as $urun) {
            $urunXml = $xml->addChild('urun');
            $urunXml->addChild('id', $urun->id);
            $urunXml->addChild('sku', htmlspecialchars($urun->sku));
            $urunXml->addChild('barkod', htmlspecialchars($urun->barkod));
            $urunXml->addChild('stok', $urun->stok);
            $urunXml->addChild('durum', $urun->stok > 0 ? 'stokta' : 'tukendi');
            $urunXml->addChild('guncelleme_tarihi', now()->toISOString());
        }

        return response($xml->asXML(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=300', // 5 dakika cache
        ]);
    }

    /**
     * Fiyat XML Feed'i
     */
    public function fiyatXml(Request $request): Response
    {
        $platform = $request->get('platform', 'genel');
        $limit = min($request->get('limit', 1000), 5000);
        
        $urunler = Urun::aktif()
                       ->select(['id', 'sku', 'barkod', 'fiyat', 'bayi_fiyat', 'ad'])
                       ->limit($limit)
                       ->get();

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><fiyat_listesi/>');
        
        foreach ($urunler as $urun) {
            $urunXml = $xml->addChild('urun');
            $urunXml->addChild('id', $urun->id);
            $urunXml->addChild('sku', htmlspecialchars($urun->sku));
            $urunXml->addChild('barkod', htmlspecialchars($urun->barkod));
            $urunXml->addChild('perakende_fiyat', $urun->fiyat);
            
            if ($urun->bayi_fiyat) {
                $urunXml->addChild('bayi_fiyat', $urun->bayi_fiyat);
            }
            
            $urunXml->addChild('guncelleme_tarihi', now()->toISOString());
            
            // Platform özel fiyat hesaplamaları
            if ($platform === 'trendyol') {
                // Trendyol komisyon oranı dahil fiyat
                $komisyonOrani = 0.15; // %15
                $trendyolFiyat = $urun->fiyat / (1 - $komisyonOrani);
                $urunXml->addChild('platform_fiyat', round($trendyolFiyat, 2));
            } elseif ($platform === 'hepsiburada') {
                // Hepsiburada komisyon oranı dahil fiyat
                $komisyonOrani = 0.12; // %12
                $hbFiyat = $urun->fiyat / (1 - $komisyonOrani);
                $urunXml->addChild('platform_fiyat', round($hbFiyat, 2));
            }
        }

        return response($xml->asXML(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=1800', // 30 dakika cache
        ]);
    }

    /**
     * XML Import işlemi
     */
    public function import(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml|max:10240', // 10MB max
            'import_type' => 'required|in:urun,stok,fiyat',
            'update_existing' => 'boolean',
        ]);

        $xmlFile = $request->file('xml_file');
        $importType = $request->input('import_type');
        $updateExisting = $request->boolean('update_existing', true);

        try {
            $xmlContent = file_get_contents($xmlFile->getRealPath());
            $xml = new SimpleXMLElement($xmlContent);
            
            $processedCount = 0;
            $errorCount = 0;
            $errors = [];

            switch ($importType) {
                case 'urun':
                    $result = $this->importUrunler($xml, $updateExisting);
                    break;
                case 'stok':
                    $result = $this->importStok($xml);
                    break;
                case 'fiyat':
                    $result = $this->importFiyat($xml);
                    break;
                default:
                    throw new \Exception('Geçersiz import türü');
            }

            return response()->json([
                'success' => true,
                'message' => 'XML import başarıyla tamamlandı',
                'processed_count' => $result['processed'],
                'error_count' => $result['errors'],
                'details' => $result['details'] ?? [],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'XML import hatası: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * XML Export işlemi
     */
    public function export(Request $request)
    {
        $request->validate([
            'export_type' => 'required|in:urun,stok,fiyat,all',
            'platform' => 'nullable|string',
            'limit' => 'nullable|integer|max:10000',
        ]);

        $exportType = $request->input('export_type');
        $platform = $request->input('platform', 'genel');
        
        switch ($exportType) {
            case 'urun':
                return $this->urunlerXml($request);
            case 'stok':
                return $this->stokXml($request);
            case 'fiyat':
                return $this->fiyatXml($request);
            case 'all':
                return $this->tumVerilerXml($request);
            default:
                return response()->json(['success' => false, 'message' => 'Geçersiz export türü'], 400);
        }
    }

    /**
     * Ürün import işlemi
     */
    private function importUrunler(SimpleXMLElement $xml, bool $updateExisting): array
    {
        $processed = 0;
        $errors = 0;
        $details = [];

        foreach ($xml->urun as $urunXml) {
            try {
                $sku = (string)$urunXml->sku;
                $ad = (string)$urunXml->ad;
                
                if (empty($ad)) {
                    $errors++;
                    $details[] = "Ürün adı boş, atlandı";
                    continue;
                }

                $urunData = [
                    'ad' => $ad,
                    'sku' => $sku ?: null,
                    'aciklama' => (string)$urunXml->aciklama ?: null,
                    'fiyat' => (float)$urunXml->fiyat ?: 0,
                    'bayi_fiyat' => (float)$urunXml->bayi_fiyat ?: null,
                    'stok' => (int)$urunXml->stok ?: 0,
                    'barkod' => (string)$urunXml->barkod ?: null,
                    'agirlik' => (float)$urunXml->agirlik ?: null,
                ];

                if ($updateExisting && $sku) {
                    $urun = Urun::where('sku', $sku)->first();
                    if ($urun) {
                        $urun->update($urunData);
                    } else {
                        Urun::create($urunData);
                    }
                } else {
                    Urun::create($urunData);
                }

                $processed++;

            } catch (\Exception $e) {
                $errors++;
                $details[] = "Hata: " . $e->getMessage();
            }
        }

        return [
            'processed' => $processed,
            'errors' => $errors,
            'details' => $details
        ];
    }

    /**
     * Stok import işlemi
     */
    private function importStok(SimpleXMLElement $xml): array
    {
        $processed = 0;
        $errors = 0;
        $details = [];

        foreach ($xml->urun as $urunXml) {
            try {
                $sku = (string)$urunXml->sku;
                $stok = (int)$urunXml->stok;

                if ($sku) {
                    $updated = Urun::where('sku', $sku)->update(['stok' => $stok]);
                    if ($updated) {
                        $processed++;
                    } else {
                        $errors++;
                        $details[] = "SKU bulunamadı: {$sku}";
                    }
                } else {
                    $errors++;
                    $details[] = "SKU boş, atlandı";
                }

            } catch (\Exception $e) {
                $errors++;
                $details[] = "Hata: " . $e->getMessage();
            }
        }

        return [
            'processed' => $processed,
            'errors' => $errors,
            'details' => $details
        ];
    }

    /**
     * Fiyat import işlemi
     */
    private function importFiyat(SimpleXMLElement $xml): array
    {
        $processed = 0;
        $errors = 0;
        $details = [];

        foreach ($xml->urun as $urunXml) {
            try {
                $sku = (string)$urunXml->sku;
                $fiyat = (float)$urunXml->fiyat;
                $bayiFiyat = (float)$urunXml->bayi_fiyat ?: null;

                if ($sku && $fiyat > 0) {
                    $updateData = ['fiyat' => $fiyat];
                    if ($bayiFiyat) {
                        $updateData['bayi_fiyat'] = $bayiFiyat;
                    }

                    $updated = Urun::where('sku', $sku)->update($updateData);
                    if ($updated) {
                        $processed++;
                    } else {
                        $errors++;
                        $details[] = "SKU bulunamadı: {$sku}";
                    }
                } else {
                    $errors++;
                    $details[] = "Geçersiz fiyat veya SKU: {$sku}";
                }

            } catch (\Exception $e) {
                $errors++;
                $details[] = "Hata: " . $e->getMessage();
            }
        }

        return [
            'processed' => $processed,
            'errors' => $errors,
            'details' => $details
        ];
    }

    /**
     * Tüm veriler XML
     */
    private function tumVerilerXml(Request $request): Response
    {
        $limit = min($request->get('limit', 1000), 5000);
        
        $urunler = Urun::with(['kategori', 'marka'])
                       ->aktif()
                       ->limit($limit)
                       ->get();

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><katalog/>');
        
        // Meta bilgiler
        $meta = $xml->addChild('meta');
        $meta->addChild('olusturma_tarihi', now()->toISOString());
        $meta->addChild('toplam_urun', $urunler->count());
        $meta->addChild('versiyon', '1.0');

        // Ürünler
        $urunlerXml = $xml->addChild('urunler');
        
        foreach ($urunler as $urun) {
            $urunXml = $urunlerXml->addChild('urun');
            $urunXml->addChild('id', $urun->id);
            $urunXml->addChild('ad', htmlspecialchars($urun->ad));
            $urunXml->addChild('sku', htmlspecialchars($urun->sku));
            $urunXml->addChild('barkod', htmlspecialchars($urun->barkod));
            $urunXml->addChild('aciklama', htmlspecialchars($urun->aciklama));
            $urunXml->addChild('fiyat', $urun->fiyat);
            $urunXml->addChild('bayi_fiyat', $urun->bayi_fiyat);
            $urunXml->addChild('stok', $urun->stok);
            $urunXml->addChild('minimum_stok', $urun->minimum_stok);
            $urunXml->addChild('kategori', htmlspecialchars($urun->kategori?->ad));
            $urunXml->addChild('marka', htmlspecialchars($urun->marka?->ad));
            $urunXml->addChild('resim', $urun->getAnaResim());
            $urunXml->addChild('agirlik', $urun->agirlik);
            $urunXml->addChild('durum', $urun->durum ? 'aktif' : 'pasif');
            $urunXml->addChild('olusturma_tarihi', $urun->created_at->toISOString());
            $urunXml->addChild('guncelleme_tarihi', $urun->updated_at->toISOString());
        }

        return response($xml->asXML(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="katalog_' . now()->format('Y-m-d_H-i-s') . '.xml"',
        ]);
    }
}