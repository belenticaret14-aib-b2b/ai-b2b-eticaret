@extends('admin.layouts.app')

@section('title', 'Site Ayarları')
@section('page-title', 'Site Ayarları')

@section('content')
<div class="space-y-6">
    <!-- Ayarları Güncelle -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Site Ayarları</h2>
        
        <form method="POST" action="{{ route('admin.site-ayarlari.guncelle') }}">
            @csrf
            
            @foreach($ayarlar as $grup => $grupAyarlari)
                <div class="mb-8">
                    <h3 class="text-md font-medium text-gray-700 mb-4 capitalize border-b pb-2">
                        {{ ucfirst($grup) }} Ayarları
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($grupAyarlari as $ayar)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ ucwords(str_replace('_', ' ', $ayar->anahtar)) }}
                                </label>
                                @if($ayar->tip === 'textarea')
                                    <textarea name="ayarlar[{{ $ayar->anahtar }}]" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              rows="3">{{ $ayar->deger }}</textarea>
                                @elseif($ayar->tip === 'email')
                                    <input type="email" name="ayarlar[{{ $ayar->anahtar }}]" 
                                           value="{{ $ayar->deger }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @elseif($ayar->tip === 'url')
                                    <input type="url" name="ayarlar[{{ $ayar->anahtar }}]" 
                                           value="{{ $ayar->deger }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @elseif($ayar->tip === 'number')
                                    <input type="number" name="ayarlar[{{ $ayar->anahtar }}]" 
                                           value="{{ $ayar->deger }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @else
                                    <input type="text" name="ayarlar[{{ $ayar->anahtar }}]" 
                                           value="{{ $ayar->deger }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @endif
                                <div class="flex justify-between items-center mt-1">
                                    <small class="text-gray-500">{{ $ayar->anahtar }}</small>
                                    <form method="POST" action="{{ route('admin.site-ayarlari.sil', $ayar->id) }}" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Bu ayarı silmek istediğinizden emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-xs">Sil</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    Ayarları Güncelle
                </button>
            </div>
        </form>
    </div>
    
    <!-- Yeni Ayar Ekle -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Yeni Ayar Ekle</h2>
        
        <form method="POST" action="{{ route('admin.site-ayarlari.yeni') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Anahtar</label>
                    <input type="text" name="anahtar" 
                           placeholder="ornek_ayar"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Değer</label>
                    <input type="text" name="deger" 
                           placeholder="Ayar değeri"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tip</label>
                    <select name="tip" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="text">Text</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        <option value="number">Number</option>
                        <option value="textarea">Textarea</option>
                        <option value="image">Image</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grup</label>
                    <select name="grup" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="genel">Genel</option>
                        <option value="iletisim">İletişim</option>
                        <option value="sosyal">Sosyal</option>
                        <option value="seo">SEO</option>
                        <option value="eticaret">E-Ticaret</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                        Ekle
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Önizleme -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Mevcut Ayarlar Önizlemesi</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">Site Bilgileri</h3>
                <div class="space-y-1 text-sm">
                    <p><strong>Site Adı:</strong> {{ $siteAyarlar['site_adi'] ?? 'Belirtilmemiş' }}</p>
                    <p><strong>Site Açıklaması:</strong> {{ Str::limit($siteAyarlar['site_aciklama'] ?? 'Belirtilmemiş', 50) }}</p>
                    <p><strong>Para Birimi:</strong> {{ $siteAyarlar['varsayilan_para_birimi'] ?? 'TL' }}</p>
                </div>
            </div>
            
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">İletişim Bilgileri</h3>
                <div class="space-y-1 text-sm">
                    <p><strong>E-posta:</strong> {{ $siteAyarlar['iletisim_email'] ?? 'Belirtilmemiş' }}</p>
                    <p><strong>Telefon:</strong> {{ $siteAyarlar['iletisim_telefon'] ?? 'Belirtilmemiş' }}</p>
                    <p><strong>Adres:</strong> {{ Str::limit($siteAyarlar['iletisim_adres'] ?? 'Belirtilmemiş', 50) }}</p>
                </div>
            </div>
            
            <div class="border rounded-lg p-4">
                <h3 class="font-medium text-gray-900 mb-2">E-Ticaret Ayarları</h3>
                <div class="space-y-1 text-sm">
                    <p><strong>Kargo Ücreti:</strong> {{ $siteAyarlar['kargo_ucreti'] ?? '0' }} {{ $siteAyarlar['varsayilan_para_birimi'] ?? 'TL' }}</p>
                    <p><strong>Ücretsiz Kargo:</strong> {{ $siteAyarlar['ucretsiz_kargo_limiti'] ?? '0' }} {{ $siteAyarlar['varsayilan_para_birimi'] ?? 'TL' }} üzeri</p>
                    <p><strong>Min. Sipariş:</strong> {{ $siteAyarlar['minimum_siparis_tutari'] ?? '0' }} {{ $siteAyarlar['varsayilan_para_birimi'] ?? 'TL' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection