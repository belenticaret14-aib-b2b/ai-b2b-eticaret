<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SayfaIcerik;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SayfaYonetimController extends Controller
{
    public function index()
    {
        $sayfalar = SayfaIcerik::orderBy('sira')->orderBy('baslik')->get();
        return view('admin.sayfalar.index', compact('sayfalar'));
    }
    
    public function create()
    {
        return view('admin.sayfalar.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
            'meta_baslik' => 'nullable|string|max:255',
            'meta_aciklama' => 'nullable|string|max:500',
            'durum' => 'boolean',
            'sira' => 'nullable|integer|min:0',
            'tip' => 'required|in:sayfa,blog,duyuru',
        ]);
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->baslik);
        $data['durum'] = $request->has('durum');
        
        // Aynı slug varsa benzersiz yap
        $originalSlug = $data['slug'];
        $counter = 1;
        while (SayfaIcerik::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        SayfaIcerik::create($data);
        
        return redirect()->route('admin.sayfalar')->with('success', 'Sayfa başarıyla oluşturuldu.');
    }
    
    public function edit(SayfaIcerik $sayfa)
    {
        return view('admin.sayfalar.edit', compact('sayfa'));
    }
    
    public function update(Request $request, SayfaIcerik $sayfa)
    {
        $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
            'meta_baslik' => 'nullable|string|max:255',
            'meta_aciklama' => 'nullable|string|max:500',
            'durum' => 'boolean',
            'sira' => 'nullable|integer|min:0',
            'tip' => 'required|in:sayfa,blog,duyuru',
        ]);
        
        $data = $request->all();
        $data['durum'] = $request->has('durum');
        
        $sayfa->update($data);
        
        return redirect()->route('admin.sayfalar')->with('success', 'Sayfa başarıyla güncellendi.');
    }
    
    public function destroy(SayfaIcerik $sayfa)
    {
        $sayfa->delete();
        return back()->with('success', 'Sayfa başarıyla silindi.');
    }
}
