@extends('layouts.admin')

@section('title', 'Yeni Ürün Ekle - Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">➕ Yeni Ürün Ekle</h1>
                <p class="text-gray-600">Yeni bir ürün ekleyin ve yönetin</p>
            </div>
            <a href="{{ route('admin.urun.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Geri Dön
            </a>
        </div>
    </div>

    <!-- Ürün Ekleme Formu -->
    <form action="{{ route('admin.urun.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Sol: Temel Bilgiler -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Temel Bilgiler -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">📝 Temel Bilgiler</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="ad" class="block text-sm font-medium text-gray-700 mb-2">Ürün Adı *</label>
                            <input type="text" id="ad" name="ad" value="{{ old('ad') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('ad') border-red-500 @enderror"
                                   required>
                            @error('ad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sku') border-red-500 @enderror"
                                   placeholder="Ürün kodu"
                                   required>
                            @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                            <select id="kategori_id" name="kategori_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori_id') border-red-500 @enderror"
                                    required>
                                <option value="">Kategori Seçin</option>
                                @foreach($kategoriler as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->ad }}
                                </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="marka_id" class="block text-sm font-medium text-gray-700 mb-2">Marka</label>
                            <select id="marka_id" name="marka_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('marka_id') border-red-500 @enderror">
                                <option value="">Marka Seçin</option>
                                @foreach($markalar as $marka)
                                <option value="{{ $marka->id }}" {{ old('marka_id') == $marka->id ? 'selected' : '' }}>
                                    {{ $marka->ad }}
                                </option>
                                @endforeach
                            </select>
                            @error('marka_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fiyat" class="block text-sm font-medium text-gray-700 mb-2">Fiyat (₺) *</label>
                            <input type="number" id="fiyat" name="fiyat" value="{{ old('fiyat') }}" 
                                   step="0.01" min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('fiyat') border-red-500 @enderror"
                                   required>
                            @error('fiyat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">Stok Miktarı *</label>
                            <input type="number" id="stok" name="stok" value="{{ old('stok', 0) }}" 
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stok') border-red-500 @enderror"
                                   required>
                            @error('stok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="aciklama" class="block text-sm font-medium text-gray-700 mb-2">Açıklama</label>
                        <textarea id="aciklama" name="aciklama" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('aciklama') border-red-500 @enderror"
                                  placeholder="Ürün açıklaması...">{{ old('aciklama') }}</textarea>
                        @error('aciklama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- SEO Bilgileri -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">🔍 SEO Bilgileri</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="seo_baslik" class="block text-sm font-medium text-gray-700 mb-2">SEO Başlığı</label>
                            <input type="text" id="seo_baslik" name="seo_baslik" value="{{ old('seo_baslik') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('seo_baslik') border-red-500 @enderror"
                                   placeholder="Arama motorları için başlık">
                            @error('seo_baslik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seo_aciklama" class="block text-sm font-medium text-gray-700 mb-2">SEO Açıklaması</label>
                            <textarea id="seo_aciklama" name="seo_aciklama" rows="3" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('seo_aciklama') border-red-500 @enderror"
                                      placeholder="Arama motorları için açıklama (max 160 karakter)">{{ old('seo_aciklama') }}</textarea>
                            @error('seo_aciklama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seo_anahtar_kelimeler" class="block text-sm font-medium text-gray-700 mb-2">Anahtar Kelimeler</label>
                            <input type="text" id="seo_anahtar_kelimeler" name="seo_anahtar_kelimeler" value="{{ old('seo_anahtar_kelimeler') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('seo_anahtar_kelimeler') border-red-500 @enderror"
                                   placeholder="anahtar, kelime, virgülle, ayrılmış">
                            @error('seo_anahtar_kelimeler')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sağ: Görsel ve Ayarlar -->
            <div class="space-y-6">
                <!-- Ürün Görseli -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">🖼️ Ürün Görseli</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="gorsel" class="block text-sm font-medium text-gray-700 mb-2">Görsel Seç</label>
                            <input type="file" id="gorsel" name="gorsel" accept="image/*" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gorsel') border-red-500 @enderror"
                                   onchange="previewImage(this)">
                            @error('gorsel')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="imagePreview" class="hidden">
                            <img id="preview" src="" alt="Önizleme" class="w-full h-48 object-cover rounded-lg border border-gray-300">
                        </div>

                        <div class="text-sm text-gray-500">
                            <p>• Desteklenen formatlar: JPEG, PNG, JPG, GIF</p>
                            <p>• Maksimum dosya boyutu: 2MB</p>
                            <p>• Önerilen boyut: 800x800px</p>
                        </div>
                    </div>
                </div>

                <!-- Ürün Durumu -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">⚙️ Ürün Durumu</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="durum" name="durum" value="1" {{ old('durum', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="durum" class="ml-2 block text-sm font-medium text-gray-700">
                                Ürün Aktif
                            </label>
                        </div>
                        
                        <div class="text-sm text-gray-600">
                            <p>✓ Aktif ürünler müşteriler tarafından görülebilir ve satın alınabilir</p>
                            <p>✗ Pasif ürünler sadece admin panelinde görünür</p>
                        </div>
                    </div>
                </div>

                <!-- Kaydet Butonu -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="space-y-4">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Ürünü Kaydet
                        </button>
                        
                        <a href="{{ route('admin.urun.index') }}" 
                           class="block w-full bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                            <i class="fas fa-times mr-2"></i>
                            İptal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const imagePreview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            imagePreview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        imagePreview.classList.add('hidden');
    }
}

// Auto-generate SKU from product name
document.getElementById('ad').addEventListener('input', function() {
    const skuInput = document.getElementById('sku');
    if (!skuInput.value) {
        const productName = this.value;
        const sku = productName.toLowerCase()
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '-')
            .substring(0, 20);
        skuInput.value = sku;
    }
});

// Auto-generate SEO title from product name
document.getElementById('ad').addEventListener('input', function() {
    const seoTitleInput = document.getElementById('seo_baslik');
    if (!seoTitleInput.value) {
        seoTitleInput.value = this.value;
    }
});
</script>
@endsection



