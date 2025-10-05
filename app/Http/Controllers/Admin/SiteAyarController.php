<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteAyar;
use Illuminate\Http\Request;

class SiteAyarController extends Controller
{
    public function index()
    {
        $ayarlar = SiteAyar::orderBy('grup')->orderBy('anahtar')->get()->groupBy('grup');
        return view('admin.site-ayarlari.index', compact('ayarlar'));
    }
    
    public function guncelle(Request $request)
    {
        $request->validate([
            'ayarlar' => 'required|array',
            'ayarlar.*' => 'nullable|string|max:1000',
        ]);
        
        foreach ($request->ayarlar as $anahtar => $deger) {
            SiteAyar::updateOrCreate(
                ['anahtar' => $anahtar],
                ['deger' => $deger]
            );
        }
        
        return back()->with('success', 'Site ayarları başarıyla güncellendi.');
    }
    
    public function yeniAyar(Request $request)
    {
        $request->validate([
            'anahtar' => 'required|string|max:255|unique:site_ayarlari,anahtar',
            'deger' => 'required|string|max:1000',
            'tip' => 'required|in:text,email,url,number,textarea,image',
            'grup' => 'required|string|max:100',
        ]);
        
        SiteAyar::create($request->all());
        
        return back()->with('success', 'Yeni ayar başarıyla eklendi.');
    }
    
    public function sil($id)
    {
        $ayar = SiteAyar::findOrFail($id);
        $ayar->delete();
        
        return back()->with('success', 'Ayar başarıyla silindi.');
    }
}
