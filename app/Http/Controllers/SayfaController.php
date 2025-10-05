<?php

namespace App\Http\Controllers;

use App\Models\SayfaIcerik;
use Illuminate\Http\Request;

class SayfaController extends Controller
{
    public function goster($slug)
    {
        $sayfa = SayfaIcerik::where('slug', $slug)
            ->where('durum', true)
            ->firstOrFail();
        
        return view('sayfa.goster', compact('sayfa'));
    }
    
    public function hakkimizda()
    {
        return $this->goster('hakkimizda');
    }
    
    public function iletisim()
    {
        return $this->goster('iletisim');
    }
    
    public function gizlilikPolitikasi()
    {
        return $this->goster('gizlilik-politikasi');
    }
    
    public function kullanimSartlari()
    {
        return $this->goster('kullanim-sartlari');
    }
    
    public function iletisimFormuGonder(Request $request)
    {
        $request->validate([
            'ad_soyad' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefon' => 'nullable|string|max:20',
            'mesaj' => 'required|string',
        ], [
            'ad_soyad.required' => 'Ad soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'mesaj.required' => 'Mesaj alanı zorunludur.',
        ]);
        
        // Burada e-posta gönderme işlemi yapılabilir
        // Mail::to('info@aib2b.com')->send(new IletisimFormu($request->all()));
        
        // Log kaydı
        \Log::info('İletişim formu gönderildi', $request->all());
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.'
            ]);
        }
        
        return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }
}
