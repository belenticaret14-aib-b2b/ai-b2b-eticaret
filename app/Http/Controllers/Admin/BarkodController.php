<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarkodController extends Controller
{
    public function fetchProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barkod' => 'required|string|min:8|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Geçersiz barkod formatı',
                'errors' => $validator->errors()
            ], 422);
        }

        $barkod = $request->input('barkod');
        
        try {
            // Mock Data - Gerçek API entegrasyonu için hazır yapı
            $urunVeritabani = [
                '8691234567890' => [
                    'ad' => 'Samsung Galaxy S23 128GB',
                    'marka' => 'Samsung',
                    'kategori' => 'Cep Telefonu',
                    'fiyat' => 18500,
                    'stok' => 15,
                    'aciklama' => 'Samsung Galaxy S23 5G Akıllı Telefon',
                    'gorsel' => 'https://example.com/galaxy-s23.jpg'
                ],
                '8699876543210' => [
                    'ad' => 'Apple iPhone 14 Pro 256GB',
                    'marka' => 'Apple', 
                    'kategori' => 'Cep Telefonu',
                    'fiyat' => 35000,
                    'stok' => 8,
                    'aciklama' => 'Apple iPhone 14 Pro 5G',
                    'gorsel' => 'https://example.com/iphone-14-pro.jpg'
                ],
                '8690123456789' => [
                    'ad' => 'MacBook Air M2 13"',
                    'marka' => 'Apple',
                    'kategori' => 'Laptop',
                    'fiyat' => 45000,
                    'stok' => 5,
                    'aciklama' => 'Apple MacBook Air 13 M2 Çip 8GB 256GB',
                    'gorsel' => 'https://example.com/macbook-air.jpg'
                ],
                '8695555111222' => [
                    'ad' => 'Logitech MX Master 3S',
                    'marka' => 'Logitech',
                    'kategori' => 'Bilgisayar Aksesuarı',
                    'fiyat' => 2500,
                    'stok' => 25,
                    'aciklama' => 'Kablosuz Performans Mouse',
                    'gorsel' => 'https://example.com/mx-master.jpg'
                ]
            ];

            if (isset($urunVeritabani[$barkod])) {
                return response()->json([
                    'success' => true,
                    'data' => $urunVeritabani[$barkod],
                    'message' => 'Ürün başarıyla bulundu',
                    'meta' => [
                        'barkod' => $barkod,
                        'source' => 'External API Mock',
                        'fetched_at' => now()->format('Y-m-d H:i:s')
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Bu barkoda ait ürün bulunamadı',
                'data' => null
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Barkod sorgulanırken hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
}
