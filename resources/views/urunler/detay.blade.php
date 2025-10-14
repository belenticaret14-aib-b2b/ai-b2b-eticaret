@extends('layouts.app')

@section('title', $urun->baslik ?? 'Ürün Detayı')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('anasayfa') }}" class="hover:text-blue-600">Ana Sayfa</a></li>
                <li>/</li>
                <li><a href="{{ route('urunler') }}" class="hover:text-blue-600">Ürünler</a></li>
                <li>/</li>
                <li class="text-gray-900 font-medium">{{ $urun->baslik ?? 'Ürün Detayı' }}</li>
            </ol>
        </nav>

        <!-- Ürün Detay -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Ürün Resmi -->
                <div class="space-y-4">
                    @if($urun->resimler && count($urun->resimler) > 0)
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ $urun->resimler[0]->url ?? '/images/placeholder.jpg' }}" 
                                 alt="{{ $urun->baslik }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Ürün Bilgileri -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $urun->baslik ?? 'Ürün Başlığı' }}</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="text-2xl font-bold text-blue-600">₺{{ number_format($urun->fiyat ?? 0, 2) }}</span>
                            @if($urun->stok > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Stokta
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Stok Yok
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Ürün Açıklaması -->
                    @if($urun->aciklama)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Açıklama</h3>
                            <div class="text-gray-600 prose max-w-none">
                                {!! nl2br(e($urun->aciklama)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Sepete Ekle -->
                    <div class="pt-6 border-t">
                        <form action="{{ route('sepet.ekle') }}" method="POST" class="flex items-center space-x-4">
                            @csrf
                            <input type="hidden" name="urun_id" value="{{ $urun->id }}">
                            
                            <div class="flex items-center space-x-2">
                                <label for="adet" class="text-sm font-medium text-gray-700">Adet:</label>
                                <input type="number" 
                                       id="adet" 
                                       name="adet" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $urun->stok ?? 1 }}"
                                       class="w-20 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <button type="submit" 
                                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benzer Ürünler -->
        @if(isset($benzerUrunler) && count($benzerUrunler) > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Benzer Ürünler</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($benzerUrunler as $benzerUrun)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                            <div class="aspect-square bg-gray-100">
                                @if($benzerUrun->resimler && count($benzerUrun->resimler) > 0)
                                    <img src="{{ $benzerUrun->resimler[0]->url ?? '/images/placeholder.jpg' }}" 
                                         alt="{{ $benzerUrun->baslik }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $benzerUrun->baslik }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-blue-600">₺{{ number_format($benzerUrun->fiyat, 2) }}</span>
                                    <a href="{{ route('urun-detay', $benzerUrun->id) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Detay
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


