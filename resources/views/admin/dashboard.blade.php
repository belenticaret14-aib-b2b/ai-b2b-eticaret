@extends('admin.layouts.app')

@section('title', 'Admin Panel')
@section('page-title', 'Admin Panel')

@section('content')
<div class="space-y-8" x-data="adminPanel()">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Toplam Ürün</p>
                    <p class="text-3xl font-bold">{{ \App\Models\Urun::count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Mağazalar</p>
                    <p class="text-3xl font-bold">{{ \App\Models\Magaza::count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Bayiler</p>
                    <p class="text-3xl font-bold">{{ \App\Models\Bayi::count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Aktif Sayfalar</p>
                    <p class="text-3xl font-bold">{{ \App\Models\SayfaIcerik::where('durum', true)->count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabbed Interface -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Tab Headers -->
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6">
                <button @click="activeTab = 'overview'" 
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'overview', 'border-transparent text-gray-500': activeTab !== 'overview' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition">
                    📊 Genel Bakış
                </button>
                <button @click="activeTab = 'products'" 
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'products', 'border-transparent text-gray-500': activeTab !== 'products' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition">
                    🛍️ Ürün Yönetimi
                </button>
                <button @click="activeTab = 'settings'" 
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'settings', 'border-transparent text-gray-500': activeTab !== 'settings' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition">
                    ⚙️ Site Ayarları
                </button>
                <button @click="activeTab = 'tools'" 
                        :class="{ 'border-blue-500 text-blue-600': activeTab === 'tools', 'border-transparent text-gray-500': activeTab !== 'tools' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap transition">
                    🔧 Araçlar & AI
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Genel Bakış Tab -->
            <div x-show="activeTab === 'overview'" x-transition class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Hızlı İşlemler -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">🚀 Hızlı İşlemler</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.urun.create') }}" 
                               class="bg-white p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition text-center">
                                <div class="text-2xl mb-2">📦</div>
                                <div class="text-sm font-medium">Yeni Ürün</div>
                            </a>
                            <a href="{{ route('admin.magaza.create') }}" 
                               class="bg-white p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-green-500 hover:bg-green-50 transition text-center">
                                <div class="text-2xl mb-2">🏪</div>
                                <div class="text-sm font-medium">Yeni Mağaza</div>
                            </a>
                            <a href="{{ route('admin.sayfalar.create') }}" 
                               class="bg-white p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-purple-500 hover:bg-purple-50 transition text-center">
                                <div class="text-2xl mb-2">📄</div>
                                <div class="text-sm font-medium">Yeni Sayfa</div>
                            </a>
                            <a href="{{ route('vitrin.index') }}" target="_blank"
                               class="bg-white p-4 rounded-lg border-2 border-dashed border-gray-300 hover:border-orange-500 hover:bg-orange-50 transition text-center">
                                <div class="text-2xl mb-2">👁️</div>
                                <div class="text-sm font-medium">Siteyi Gör</div>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Son Aktiviteler -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">📈 Son Eklenen Ürünler</h3>
                        <div class="space-y-3">
                            @php($sonUrunler = \App\Models\Urun::latest()->limit(5)->get())
                            @forelse($sonUrunler as $urun)
                                <div class="bg-white p-3 rounded-lg flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-sm">{{ Str::limit($urun->ad, 30) }}</p>
                                        <p class="text-xs text-gray-500">{{ $urun->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-sm font-bold text-blue-600">
                                        {{ number_format($urun->fiyat, 0) }}₺
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <div class="text-4xl mb-2">📦</div>
                                    <p>Henüz ürün eklenmemiş</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ürün Yönetimi Tab -->
            <div x-show="activeTab === 'products'" x-transition class="space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">🛍️ Ürün Yönetimi</h3>
                    <a href="{{ route('admin.urun.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        + Yeni Ürün Ekle
                    </a>
                </div>
                
                <!-- Ürün Listesi (Son 10) -->
                <div class="bg-gray-50 rounded-lg overflow-hidden">
                    @php($urunler = \App\Models\Urun::with(['kategori', 'marka'])->latest()->limit(10)->get())
                    @if($urunler->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($urunler as $urun)
                                <div class="p-4 hover:bg-white transition">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $urun->gorsel ?? 'https://placehold.co/80x80?text=Ürün' }}" 
                                                 class="w-12 h-12 rounded-lg object-cover" alt="Ürün">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ Str::limit($urun->ad, 40) }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $urun->kategori?->ad }} • {{ $urun->marka?->ad }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <p class="font-bold text-lg">{{ number_format($urun->fiyat, 0) }}₺</p>
                                                <p class="text-sm text-gray-500">Stok: {{ $urun->stok ?? 0 }}</p>
                                            </div>
                                            <a href="{{ route('admin.urun.edit', $urun) }}" 
                                               class="bg-gray-100 hover:bg-gray-200 p-2 rounded-lg transition">
                                                ✏️
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="p-4 bg-white border-t">
                            <a href="{{ route('admin.urun.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                Tüm ürünleri görüntüle ({{ \App\Models\Urun::count() }} ürün) →
                            </a>
                        </div>
                    @else
                        <div class="p-8 text-center">
                            <div class="text-6xl mb-4">📦</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz ürün yok</h3>
                            <p class="text-gray-500 mb-4">İlk ürününüzü ekleyerek başlayın</p>
                            <a href="{{ route('admin.urun.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                İlk Ürünü Ekle
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Site Ayarları Tab -->
            <div x-show="activeTab === 'settings'" x-transition>
                <h3 class="text-xl font-semibold text-gray-900 mb-6">⚙️ Site Ayarları</h3>
                
                <form method="POST" action="{{ route('admin.site-ayarlari.guncelle') }}" class="space-y-8">
                    @csrf
                    
                    <!-- Temel Bilgiler -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">🏢 Temel Site Bilgileri</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Site Adı</label>
                                <input type="text" name="ayarlar[site_adi]" 
                                       value="{{ $siteAyarlar['site_adi'] ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Para Birimi</label>
                                <select name="ayarlar[varsayilan_para_birimi]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="TL" {{ ($siteAyarlar['varsayilan_para_birimi'] ?? '') === 'TL' ? 'selected' : '' }}>Türk Lirası (TL)</option>
                                    <option value="USD" {{ ($siteAyarlar['varsayilan_para_birimi'] ?? '') === 'USD' ? 'selected' : '' }}>Dolar (USD)</option>
                                    <option value="EUR" {{ ($siteAyarlar['varsayilan_para_birimi'] ?? '') === 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Site Açıklaması</label>
                                <textarea name="ayarlar[site_aciklama]" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $siteAyarlar['site_aciklama'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- İletişim Bilgileri -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">📞 İletişim Bilgileri</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                                <input type="email" name="ayarlar[iletisim_email]" 
                                       value="{{ $siteAyarlar['iletisim_email'] ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                                <input type="text" name="ayarlar[iletisim_telefon]" 
                                       value="{{ $siteAyarlar['iletisim_telefon'] ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
                                <textarea name="ayarlar[iletisim_adres]" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $siteAyarlar['iletisim_adres'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- E-Ticaret Ayarları -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">🛒 E-Ticaret Ayarları</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kargo Ücreti (₺)</label>
                                <input type="number" step="0.01" name="ayarlar[kargo_ucreti]" 
                                       value="{{ $siteAyarlar['kargo_ucreti'] ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ücretsiz Kargo Limiti (₺)</label>
                                <input type="number" step="0.01" name="ayarlar[ucretsiz_kargo_limiti]" 
                                       value="{{ $siteAyarlar['ucretsiz_kargo_limiti'] ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Sipariş (₺)</label>
                                <input type="number" step="0.01" name="ayarlar[minimum_siparis_tutari]" 
                                       value="{{ $siteAyarlar['minimum_siparis_tutari'] ?? '' }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                            💾 Ayarları Kaydet
                        </button>
                    </div>
                </form>
            </div>

            <!-- Araçlar & AI Tab -->
            <div x-show="activeTab === 'tools'" x-transition class="space-y-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">🔧 Araçlar & AI Asistan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- AI Ürün Önerisi -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-3">🤖</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">AI Ürün Önerisi</h4>
                            <p class="text-sm text-gray-600 mb-4">Yapay zeka ile akıllı ürün önerileri alın</p>
                            <button onclick="aiUrunOnerisi()" 
                                    class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                                Öneri Al
                            </button>
                        </div>
                    </div>
                    
                    <!-- Barkod Okuyucu -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border border-blue-200 rounded-xl p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-3">📱</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Barkod Okuyucu</h4>
                            <p class="text-sm text-gray-600 mb-4">Barkod ile hızlı ürün bilgisi alın</p>
                            <button onclick="barkodFetch()" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Barkod Oku
                            </button>
                        </div>
                    </div>
                    
                    <!-- Sayfa Yönetimi -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-3">📄</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Sayfa Yönetimi</h4>
                            <p class="text-sm text-gray-600 mb-4">Site sayfalarını yönetin</p>
                            <a href="{{ route('admin.sayfalar') }}" 
                               class="inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                                Sayfalar
                            </a>
                        </div>
                    </div>
                    
                    <!-- Mağaza Entegrasyonu -->
                    <div class="bg-gradient-to-br from-orange-50 to-red-50 border border-orange-200 rounded-xl p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-3">🏪</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Mağaza Entegrasyonu</h4>
                            <p class="text-sm text-gray-600 mb-4">Trendyol, N11, Hepsiburada</p>
                            <a href="{{ route('admin.magaza.index') }}" 
                               class="inline-block bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition">
                                Mağazalar
                            </a>
                        </div>
                    </div>
                    
                    <!-- XML İşlemleri -->
                    <div class="bg-gradient-to-br from-gray-50 to-slate-50 border border-gray-200 rounded-xl p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-3">📋</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">XML İşlemleri</h4>
                            <p class="text-sm text-gray-600 mb-4">Ürün verilerini içe/dışa aktarın</p>
                            <div class="space-y-2">
                                <button class="block w-full bg-gray-600 text-white px-4 py-1 rounded text-sm hover:bg-gray-700 transition">
                                    XML İçe Aktar
                                </button>
                                <a href="{{ route('admin.xml.export') }}" class="block w-full bg-gray-600 text-white px-4 py-1 rounded text-sm hover:bg-gray-700 transition text-center">
                                    XML Dışa Aktar
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Site Önizleme -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl p-6">
                        <div class="text-center">
                            <div class="text-4xl mb-3">👁️</div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Site Önizleme</h4>
                            <p class="text-sm text-gray-600 mb-4">Canlı siteyi görüntüleyin</p>
                            <a href="{{ route('vitrin.index') }}" target="_blank"
                               class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                                Siteyi Aç
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function adminPanel() {
    return {
        activeTab: 'overview'
    }
}
</script>
@endsection
