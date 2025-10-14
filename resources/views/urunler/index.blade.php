@extends('layouts.app')

@section('title', 'Ürünler - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🛍️ Ürünlerimiz</h1>
            <p class="text-gray-600">Kaliteli ürünlerimizi keşfedin</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sol: Filtreler -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">🔍 Filtreler</h2>
                    
                    <!-- Arama -->
                    <form method="GET" action="{{ route('urunler') }}" class="mb-6">
                        <div class="relative">
                            <input type="text" name="q" value="{{ request('q') }}" 
                                   placeholder="Ürün ara..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Kategoriler -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Kategoriler</h3>
                        <div class="space-y-2">
                            <a href="{{ route('urunler') }}" 
                               class="block text-sm {{ !request('kategori_id') ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Tümü
                            </a>
                            @foreach($kategoriler as $kategori)
                            <a href="{{ route('urunler', ['kategori_id' => $kategori->id]) }}" 
                               class="block text-sm {{ request('kategori_id') == $kategori->id ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                {{ $kategori->ad }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Markalar -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Markalar</h3>
                        <div class="space-y-2">
                            <a href="{{ route('urunler') }}" 
                               class="block text-sm {{ !request('marka_id') ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                Tümü
                            </a>
                            @foreach($markalar as $marka)
                            <a href="{{ route('urunler', ['marka_id' => $marka->id]) }}" 
                               class="block text-sm {{ request('marka_id') == $marka->id ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-gray-900' }}">
                                {{ $marka->ad }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Fiyat Aralığı -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Fiyat Aralığı</h3>
                        <form method="GET" action="{{ route('urunler') }}">
                            @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                            @if(request('kategori_id'))<input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">@endif
                            @if(request('marka_id'))<input type="hidden" name="marka_id" value="{{ request('marka_id') }}">@endif
                            
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_fiyat" value="{{ request('min_fiyat') }}" 
                                       placeholder="Min" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="number" name="max_fiyat" value="{{ request('max_fiyat') }}" 
                                       placeholder="Max" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                            <button type="submit" class="w-full mt-2 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm">
                                Uygula
                            </button>
                        </form>
                    </div>

                    <!-- Temizle -->
                    <a href="{{ route('urunler') }}" 
                       class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 rounded-lg text-sm">
                        Filtreleri Temizle
                    </a>
                </div>
            </div>

            <!-- Sağ: Ürünler -->
            <div class="lg:col-span-3">
                <!-- Sıralama ve Sonuç Sayısı -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-600">
                            <span class="font-medium">{{ $urunler->total() }}</span> ürün bulundu
                        </p>
                        
                        <form method="GET" action="{{ route('urunler') }}">
                            @foreach(request()->all() as $key => $value)
                                @if($key !== 'sirala')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            
                            <select name="sirala" onchange="this.form.submit()" 
                                    class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="yeni" {{ request('sirala') == 'yeni' ? 'selected' : '' }}>En Yeni</option>
                                <option value="fiyat_artan" {{ request('sirala') == 'fiyat_artan' ? 'selected' : '' }}>Fiyat (Düşük → Yüksek)</option>
                                <option value="fiyat_azalan" {{ request('sirala') == 'fiyat_azalan' ? 'selected' : '' }}>Fiyat (Yüksek → Düşük)</option>
                                <option value="isim" {{ request('sirala') == 'isim' ? 'selected' : '' }}>İsme Göre (A-Z)</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Ürün Grid -->
                @if($urunler->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($urunler as $urun)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <!-- Ürün Resmi -->
                            <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                                @if($urun->gorsel)
                                    <img src="{{ asset('storage/' . $urun->gorsel) }}" alt="{{ $urun->ad }}" 
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Ürün Bilgileri -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $urun->ad }}</h3>
                                
                                @if($urun->kategori)
                                <p class="text-sm text-gray-600 mb-2">{{ $urun->kategori->ad }}</p>
    @endif

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-lg font-bold text-blue-600">₺{{ number_format($urun->fiyat, 2) }}</span>
                                    @if($urun->stok > 0)
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                            Stokta
                                        </span>
                                    @else
                                        <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">
                                            Tükendi
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Sepete Ekle Butonu -->
                                @if($urun->stok > 0)
                                <form method="POST" action="{{ route('sepet.ekle') }}">
                                    @csrf
                                    <input type="hidden" name="urun_id" value="{{ $urun->id }}">
                                    <button type="submit" 
                                            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Sepete Ekle
                                    </button>
                                </form>
                                @else
                                <button disabled 
                                        class="w-full bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                                    <i class="fas fa-times mr-2"></i>
                                    Stokta Yok
                                </button>
    @endif

                                <!-- Detay Butonu -->
                                <a href="{{ route('urun-detay', $urun->id) }}" 
                                   class="block w-full mt-2 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg transition-colors text-center">
                                    <i class="fas fa-eye mr-2"></i>
                                    Detayları Gör
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $urunler->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <div class="text-6xl text-gray-300 mb-4">🔍</div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Ürün Bulunamadı</h2>
                        <p class="text-gray-600 mb-8">Arama kriterlerinize uygun ürün bulunamadı</p>
                        <a href="{{ route('urunler') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-colors inline-flex items-center">
                            <i class="fas fa-refresh mr-2"></i>
                            Tüm Ürünleri Görüntüle
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection