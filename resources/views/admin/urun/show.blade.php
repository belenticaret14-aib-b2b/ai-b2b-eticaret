@extends('admin.layouts.app')

@section('title', 'Ürün Detayları')
@section('page-title', 'Ürün Detayları')

@section('content')
<div class="space-y-6">
    <!-- Ürün Bilgileri -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">{{ $urun->ad }}</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.urun.edit', $urun) }}" 
                       class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition">
                        ✏️ Düzenle
                    </a>
                    <a href="{{ route('admin.urun.index') }}" 
                       class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg transition">
                        ← Geri
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
            <!-- Ürün Görseli -->
            <div class="lg:col-span-1">
                <div class="bg-gray-100 rounded-lg aspect-square flex items-center justify-center">
                    @if($urun->gorsel)
                        <img src="{{ $urun->gorsel }}" alt="{{ $urun->ad }}" 
                             class="w-full h-full object-cover rounded-lg">
                    @else
                        <div class="text-center text-gray-500">
                            <div class="text-6xl mb-2">📦</div>
                            <p>Görsel Yok</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ürün Detayları -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Temel Bilgiler -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Temel Bilgiler</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="text-sm font-medium text-gray-600">Ürün Adı</label>
                            <p class="text-lg font-semibold">{{ $urun->ad }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="text-sm font-medium text-gray-600">SKU</label>
                            <p class="text-lg font-semibold">{{ $urun->sku ?? 'Belirtilmemiş' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="text-sm font-medium text-gray-600">Barkod</label>
                            <p class="text-lg font-semibold">{{ $urun->barkod ?? 'Belirtilmemiş' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="text-sm font-medium text-gray-600">Durum</label>
                            <p class="text-lg font-semibold">
                                @if($urun->aktif ?? true)
                                    <span class="text-green-600">✅ Aktif</span>
                                @else
                                    <span class="text-red-600">❌ Pasif</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fiyat & Stok -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">💰 Fiyat & Stok</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 border border-green-200 p-4 rounded-lg">
                            <label class="text-sm font-medium text-green-600">Satış Fiyatı</label>
                            <p class="text-2xl font-bold text-green-700">{{ number_format($urun->fiyat, 0) }}₺</p>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <label class="text-sm font-medium text-blue-600">Mevcut Stok</label>
                            <p class="text-2xl font-bold text-blue-700">{{ $urun->stok ?? 0 }}</p>
                        </div>
                        <div class="bg-orange-50 border border-orange-200 p-4 rounded-lg">
                            <label class="text-sm font-medium text-orange-600">Bayi Fiyatı</label>
                            <p class="text-2xl font-bold text-orange-700">{{ number_format($urun->bayi_fiyat ?? 0, 0) }}₺</p>
                        </div>
                    </div>
                </div>

                <!-- Kategori & Marka -->
                @if($urun->kategori || $urun->marka)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🏷️ Sınıflandırma</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($urun->kategori)
                        <div class="bg-purple-50 border border-purple-200 p-4 rounded-lg">
                            <label class="text-sm font-medium text-purple-600">Kategori</label>
                            <p class="text-lg font-semibold text-purple-700">{{ $urun->kategori->ad }}</p>
                        </div>
                        @endif
                        @if($urun->marka)
                        <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg">
                            <label class="text-sm font-medium text-indigo-600">Marka</label>
                            <p class="text-lg font-semibold text-indigo-700">{{ $urun->marka->ad }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Açıklama -->
        @if($urun->aciklama)
        <div class="px-6 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Ürün Açıklaması</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 leading-relaxed">{{ $urun->aciklama }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Mağaza Eşleştirmeleri -->
    @if($magazalar->count() > 0)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 text-white">
            <h2 class="text-xl font-semibold">🏪 Mağaza Eşleştirmeleri</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($magazalar as $magaza)
                <div class="border border-gray-200 p-4 rounded-lg hover:bg-gray-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $magaza->ad }}</h4>
                            <p class="text-sm text-gray-600">{{ $magaza->platform }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                Aktif
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Son İşlemler -->
    @if($sonIslemler->count() > 0)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-500 to-gray-600 text-white">
            <h2 class="text-xl font-semibold">📈 Son İşlemler</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($sonIslemler as $islem)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $islem['islem'] }}</h4>
                        <p class="text-sm text-gray-600">{{ $islem['detay'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ $islem['tarih']->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection