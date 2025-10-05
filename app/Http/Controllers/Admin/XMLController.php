<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Urun;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class XMLController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'xml' => ['required', 'file', 'mimes:xml', 'max:5120'],
        ]);

        $path = $request->file('xml')->getRealPath();
        $xml = simplexml_load_file($path);

        // Basit örnek: XML içinde <urunler><urun><ad>..</ad><fiyat>..</fiyat></urun></urunler>
        if ($xml && isset($xml->urun)) {
            foreach ($xml->urun as $xUrun) {
                $ad = (string)($xUrun->ad ?? '');
                $fiyat = (float)($xUrun->fiyat ?? 0);
                if ($ad !== '') {
                    Urun::updateOrCreate(
                        ['ad' => $ad],
                        [
                            'fiyat' => $fiyat,
                            'stok' => (int)($xUrun->stok ?? 0),
                            'barkod' => (string)($xUrun->barkod ?? null),
                            'gorsel' => (string)($xUrun->gorsel ?? null),
                            'aciklama' => (string)($xUrun->aciklama ?? null),
                        ]
                    );
                }
            }
        }

        return back()->with('status', 'XML içe aktarma tamamlandı.');
    }

    public function export(): StreamedResponse
    {
        $urunler = Urun::all(['ad', 'fiyat', 'stok', 'barkod', 'gorsel', 'aciklama']);

        $callback = function () use ($urunler) {
            $xml = new \SimpleXMLElement('<urunler/>');
            foreach ($urunler as $u) {
                $node = $xml->addChild('urun');
                $node->addChild('ad', htmlspecialchars((string)$u->ad));
                $node->addChild('fiyat', (string)$u->fiyat);
                $node->addChild('stok', (string)($u->stok ?? 0));
                if ($u->barkod) $node->addChild('barkod', htmlspecialchars((string)$u->barkod));
                if ($u->gorsel) $node->addChild('gorsel', htmlspecialchars((string)$u->gorsel));
                if ($u->aciklama) $node->addChild('aciklama', htmlspecialchars((string)$u->aciklama));
            }
            echo $xml->asXML();
        };

        return response()->streamDownload($callback, 'export.xml', [
            'Content-Type' => 'application/xml',
        ]);
    }
}
 
