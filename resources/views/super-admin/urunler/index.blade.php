@extends('super-admin.layouts.app')

@section('title', 'Ürün Yönetimi - Süper Admin Panel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">📦 Ürün Yönetimi</h1>
                <p class="text-gray-600">Tüm ürünleri yönetin ve düzenleyin</p>
            </div>
            <a href="{{ route('super-admin.urunler.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Yeni Ürün
            </a>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('super-admin.urunler.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Arama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Arama</label>
                <input type="text" name="q" value="{{ request('q') }}" 
                       placeholder="Ürün adı, SKU..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tümü</option>
                    @foreach($kategoriler as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->ad }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Marka -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Marka</label>
                <select name="marka_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tümü</option>
                    @foreach($markalar as $marka)
                    <option value="{{ $marka->id }}" {{ request('marka_id') == $marka->id ? 'selected' : '' }}>
                        {{ $marka->ad }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Durum -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                <select name="durum" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tümü</option>
                    <option value="1" {{ request('durum') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('durum') === '0' ? 'selected' : '' }}>Pasif</option>
                </select>
            </div>

            <!-- Stok Durumu -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                <select name="stok_durumu" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tümü</option>
                    <option value="dusuk" {{ request('stok_durumu') === 'dusuk' ? 'selected' : '' }}>Düşük Stok</option>
                    <option value="tukendi" {{ request('stok_durumu') === 'tukendi' ? 'selected' : '' }}>Tükendi</option>
                </select>
            </div>

            <!-- Butonlar -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-1"></i>
                    Filtrele
                </button>
                <a href="{{ route('super-admin.urunler.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-times mr-1"></i>
                    Temizle
                </a>
            </div>
        </form>
    </div>

    <!-- Ürün Listesi -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        @if($urunler->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Ürün</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">SKU</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Kategori</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Fiyat</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Stok</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Durum</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($urunler as $urun)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        @if($urun->gorsel)
                                            <img src="{{ asset('storage/' . $urun->gorsel) }}" alt="{{ $urun->ad }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <i class="fas fa-box text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $urun->ad }}</p>
                                        @if($urun->marka)
                                            <p class="text-sm text-gray-600">{{ $urun->marka->ad }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-sm">{{ $urun->sku }}</td>
                            <td class="px-4 py-3">
                                @if($urun->kategori)
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">{{ $urun->kategori->ad }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium">₺{{ number_format($urun->fiyat, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="{{ $urun->stok > 10 ? 'text-green-600' : ($urun->stok > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $urun->stok }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs {{ $urun->durum ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $urun->durum ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('super-admin.urunler.show', $urun) }}" 
                                       class="text-blue-600 hover:text-blue-800" title="Görüntüle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('super-admin.urunler.edit', $urun) }}" 
                                       class="text-yellow-600 hover:text-yellow-800" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('super-admin.urunler.destroy', $urun) }}" class="inline" 
                                          onsubmit="return confirm('Bu ürünü silmek istediğinizden emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Sil">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $urunler->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl text-gray-300 mb-4">📦</div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Ürün Bulunamadı</h3>
                <p class="text-gray-600 mb-6">Henüz hiç ürün eklenmemiş veya arama kriterlerinize uygun ürün bulunamadı</p>
                <a href="{{ route('super-admin.urunler.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    İlk Ürünü Ekle
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

