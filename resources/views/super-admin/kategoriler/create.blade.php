@extends('super-admin.layouts.app')

@section('title', 'Süper Admin - Yeni Kategori')
@section('page-title', '👑 Yeni Kategori Oluştur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-purple-600 to-blue-600 text-white">
            <h3 class="text-2xl font-bold">👑 Süper Admin - Yeni Kategori</h3>
            <p class="text-purple-100 mt-2">Sistem genelinde kategori oluşturun ve yönetin</p>
        </div>
        
        <form action="{{ route('super-admin.kategoriler.store') }}" method="POST" class="p-8 space-y-8">
            @csrf
            
            <!-- Kategori Bilgileri -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Sol Kolon -->
                <div class="space-y-6">
                    <h4 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">📝 Kategori Bilgileri</h4>
                    
                    <!-- Kategori Adı -->
                    <div>
                        <label for="ad" class="block text-sm font-medium text-gray-700 mb-2">
                            📝 Kategori Adı <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="ad" 
                               name="ad" 
                               value="{{ old('ad') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('ad') border-red-500 @enderror"
                               placeholder="Örn: Elektronik, Giyim, Ev & Yaşam"
                               required>
                        @error('ad')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            🔗 URL Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                               placeholder="elektronik, giyim, ev-yasam"
                               required>
                        <p class="text-gray-500 text-sm mt-1">URL'de kullanılacak kısa ad (küçük harf, tire ile ayrılmış)</p>
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Ana Kategori -->
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">
                            📁 Ana Kategori
                        </label>
                        <select id="parent_id" 
                                name="parent_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('parent_id') border-red-500 @enderror">
                            <option value="">Ana Kategori (Üst seviye)</option>
                            @foreach($anaKategoriler as $anaKategori)
                                <option value="{{ $anaKategori->id }}" {{ old('parent_id') == $anaKategori->id ? 'selected' : '' }}>
                                    {{ $anaKategori->ad }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-gray-500 text-sm mt-1">Boş bırakırsanız ana kategori olarak oluşturulur</p>
                        @error('parent_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Sıra -->
                    <div>
                        <label for="sira" class="block text-sm font-medium text-gray-700 mb-2">
                            🔢 Sıralama
                        </label>
                        <input type="number" 
                               id="sira" 
                               name="sira" 
                               value="{{ old('sira', 0) }}"
                               min="0"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sira') border-red-500 @enderror"
                               placeholder="0">
                        <p class="text-gray-500 text-sm mt-1">Düşük sayılar önce görünür</p>
                        @error('sira')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Sağ Kolon -->
                <div class="space-y-6">
                    <h4 class="text-xl font-semibold text-gray-900 border-b border-gray-200 pb-2">⚙️ Ayarlar & SEO</h4>
                    
                    <!-- Açıklama -->
                    <div>
                        <label for="aciklama" class="block text-sm font-medium text-gray-700 mb-2">
                            📄 Açıklama
                        </label>
                        <textarea id="aciklama" 
                                  name="aciklama" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('aciklama') border-red-500 @enderror"
                                  placeholder="Kategori hakkında detaylı açıklama...">{{ old('aciklama') }}</textarea>
                        @error('aciklama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Durum -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="durum" 
                                   value="1" 
                                   {{ old('durum', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="ml-3 text-sm font-medium text-gray-700">✅ Aktif (Kategori görünür olsun)</span>
                        </label>
                    </div>
                    
                    <!-- SEO Başlığı -->
                    <div>
                        <label for="seo_baslik" class="block text-sm font-medium text-gray-700 mb-2">
                            🏷️ SEO Başlığı
                        </label>
                        <input type="text" 
                               id="seo_baslik" 
                               name="seo_baslik" 
                               value="{{ old('seo_baslik') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Arama motorları için özel başlık...">
                    </div>
                    
                    <!-- SEO Açıklaması -->
                    <div>
                        <label for="seo_aciklama" class="block text-sm font-medium text-gray-700 mb-2">
                            📝 SEO Açıklaması
                        </label>
                        <textarea id="seo_aciklama" 
                                  name="seo_aciklama" 
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Arama motorları için açıklama...">{{ old('seo_aciklama') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Süper Admin Özel Ayarları -->
            <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg p-6 border border-purple-200">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">👑 Süper Admin Özel Ayarları</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="sistem_kategori" 
                                   value="1" 
                                   class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="ml-3 text-sm font-medium text-gray-700">🔧 Sistem Kategorisi</span>
                        </label>
                        <p class="text-gray-500 text-xs mt-1">Sistem tarafından özel olarak yönetilir</p>
                    </div>
                    
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="bayi_ozel" 
                                   value="1" 
                                   class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                            <span class="ml-3 text-sm font-medium text-gray-700">🤝 Bayi Özel Kategori</span>
                        </label>
                        <p class="text-gray-500 text-xs mt-1">Sadece bayiler için görünür</p>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('super-admin.kategoriler.index') }}" 
                   class="px-8 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    ❌ İptal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl font-medium">
                    ✅ Kategori Oluştur
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Slug otomatik oluşturma
document.getElementById('ad').addEventListener('input', function() {
    const slug = this.value
        .toLowerCase()
        .replace(/ğ/g, 'g')
        .replace(/ü/g, 'u')
        .replace(/ş/g, 's')
        .replace(/ı/g, 'i')
        .replace(/ö/g, 'o')
        .replace(/ç/g, 'c')
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    
    document.getElementById('slug').value = slug;
});

// SEO başlığı otomatik doldurma
document.getElementById('ad').addEventListener('input', function() {
    if (!document.getElementById('seo_baslik').value) {
        document.getElementById('seo_baslik').value = this.value + ' - NetMarketiniz';
    }
});
</script>
@endsection

