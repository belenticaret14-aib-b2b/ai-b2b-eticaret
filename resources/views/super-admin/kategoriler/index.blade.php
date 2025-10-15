@extends('super-admin.layouts.app')

@section('title', 'Süper Admin - Kategori Yönetimi')
@section('page-title', '📂 Kategori Yönetimi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">👑 Süper Admin - Kategori Yönetimi</h1>
            <p class="text-gray-600">Tüm kategorileri yönetin ve sistem genelinde kontrol edin</p>
        </div>
        <a href="{{ route('super-admin.kategoriler.create') }}" 
           class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
            ➕ Yeni Kategori
        </a>
    </div>

    <!-- Super Admin Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Toplam Kategori</p>
                    <p class="text-3xl font-bold">{{ $kategoriler->count() }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 p-3 rounded-full">
                    <span class="text-2xl">📂</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Alt Kategori</p>
                    <p class="text-3xl font-bold">{{ $kategoriler->sum('children_count') }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 p-3 rounded-full">
                    <span class="text-2xl">📄</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Aktif Kategori</p>
                    <p class="text-3xl font-bold">{{ $kategoriler->where('durum', true)->count() }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 p-3 rounded-full">
                    <span class="text-2xl">✅</span>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Toplam Ürün</p>
                    <p class="text-3xl font-bold">{{ $kategoriler->sum('urunler_count') }}</p>
                </div>
                <div class="bg-orange-400 bg-opacity-30 p-3 rounded-full">
                    <span class="text-2xl">📦</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Tree -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">🌳 Kategori Ağacı</h3>
            <p class="text-gray-600 mt-1">Hierarchical kategori yapısı ve detayları</p>
        </div>
        
        <div class="p-6">
            @forelse($kategoriler as $kategori)
                <div class="mb-6">
                    <!-- Ana Kategori -->
                    <div class="flex items-center justify-between p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 shadow-sm">
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-500 text-white p-3 rounded-full">
                                <span class="text-2xl">📁</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">{{ $kategori->ad }}</h4>
                                @if($kategori->aciklama)
                                    <p class="text-gray-600 mt-1">{{ $kategori->aciklama }}</p>
                                @endif
                                <div class="flex items-center space-x-3 mt-3">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                        🔗 {{ $kategori->slug }}
                                    </span>
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-medium">
                                        📊 Sıra: {{ $kategori->sira ?? 0 }}
                                    </span>
                                    <span class="{{ $kategori->durum ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $kategori->durum ? '✅ Aktif' : '❌ Pasif' }}
                                    </span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">
                                        📦 {{ $kategori->urunler()->count() }} ürün
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                ✏️ Düzenle
                            </button>
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                🗑️ Sil
                            </button>
                        </div>
                    </div>
                    
                    <!-- Alt Kategoriler -->
                    @if($kategori->children->count())
                        <div class="ml-8 mt-4 space-y-3">
                            <h5 class="text-lg font-semibold text-gray-700 mb-3">📄 Alt Kategoriler</h5>
                            @foreach($kategori->children as $altKategori)
                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200 shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-gray-500 text-white p-2 rounded-full">
                                            <span class="text-lg">📄</span>
                                        </div>
                                        <div>
                                            <h6 class="font-semibold text-gray-800">{{ $altKategori->ad }}</h6>
                                            <div class="flex items-center space-x-3 mt-1">
                                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                                                    {{ $altKategori->slug }}
                                                </span>
                                                <span class="{{ $altKategori->durum ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} px-2 py-1 rounded-full text-xs">
                                                    {{ $altKategori->durum ? 'Aktif' : 'Pasif' }}
                                                </span>
                                                <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-xs">
                                                    {{ $altKategori->urunler()->count() }} ürün
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <button class="text-blue-600 hover:text-blue-700 p-2 hover:bg-blue-50 rounded-lg transition-colors">
                                            ✏️
                                        </button>
                                        <button class="text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition-colors">
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <span class="text-4xl text-gray-400">📂</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-600 mb-3">Henüz kategori bulunmuyor</h3>
                    <p class="text-gray-500 mb-8">Sisteminizi kategorilerle organize etmeye başlayın.</p>
                    <a href="{{ route('super-admin.kategoriler.create') }}" 
                       class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        ➕ İlk Kategoriyi Oluştur
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Super Admin Actions -->
    @if($kategoriler->count())
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">🔧 Süper Admin İşlemleri</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    📊 Kategori İstatistikleri
                </button>
                <button class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    🔄 Toplu Güncelleme
                </button>
                <button class="bg-purple-500 hover:bg-purple-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    📤 Kategori Export
                </button>
            </div>
        </div>
    @endif
</div>
@endsection



