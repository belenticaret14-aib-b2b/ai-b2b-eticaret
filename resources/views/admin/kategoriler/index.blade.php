@extends('admin.layouts.app')

@section('title', 'Kategori Yönetimi')
@section('page-title', '📂 Kategori Yönetimi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📂 Kategori Yönetimi</h1>
            <p class="text-gray-600">Ürün kategorilerini yönetin ve düzenleyin</p>
        </div>
        <a href="{{ route('admin.kategoriler.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            ➕ Yeni Kategori
        </a>
    </div>

    <!-- Categories Tree -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Kategori Ağacı</h3>
        </div>
        
        <div class="p-6">
            @forelse($kategoriler as $kategori)
                <div class="mb-4">
                    <!-- Ana Kategori -->
                    <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">📁</span>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $kategori->ad }}</h4>
                                @if($kategori->aciklama)
                                    <p class="text-sm text-gray-600">{{ $kategori->aciklama }}</p>
                                @endif
                                <div class="flex items-center space-x-4 mt-1">
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">
                                        Slug: {{ $kategori->slug }}
                                    </span>
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                        Sıra: {{ $kategori->sira ?? 0 }}
                                    </span>
                                    <span class="text-xs {{ $kategori->durum ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} px-2 py-1 rounded-full">
                                        {{ $kategori->durum ? '✅ Aktif' : '❌ Pasif' }}
                                    </span>
                                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full">
                                        📦 {{ $kategori->urunler()->count() }} ürün
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                ✏️ Düzenle
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                🗑️ Sil
                            </a>
                        </div>
                    </div>
                    
                    <!-- Alt Kategoriler -->
                    @if($kategori->children->count())
                        <div class="ml-8 mt-2 space-y-2">
                            @foreach($kategori->children as $altKategori)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-xl">📄</span>
                                        <div>
                                            <h5 class="font-medium text-gray-800">{{ $altKategori->ad }}</h5>
                                            <div class="flex items-center space-x-3 mt-1">
                                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                                    {{ $altKategori->slug }}
                                                </span>
                                                <span class="text-xs {{ $altKategori->durum ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} px-2 py-1 rounded-full">
                                                    {{ $altKategori->durum ? 'Aktif' : 'Pasif' }}
                                                </span>
                                                <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full">
                                                    {{ $altKategori->urunler()->count() }} ürün
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm">
                                            ✏️
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-700 text-sm">
                                            🗑️
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">📂</div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Henüz kategori bulunmuyor</h3>
                    <p class="text-gray-500 mb-4">İlk kategorinizi oluşturmak için aşağıdaki butona tıklayın.</p>
                    <a href="{{ route('admin.kategoriler.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        ➕ İlk Kategoriyi Oluştur
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Statistics -->
    @if($kategoriler->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <span class="text-2xl">📁</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Toplam Kategori</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $kategoriler->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <span class="text-2xl">📄</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Alt Kategori</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $kategoriler->sum('children_count') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <span class="text-2xl">📦</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Toplam Ürün</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $kategoriler->sum('urunler_count') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

