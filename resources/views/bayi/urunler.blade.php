@extends('layouts.app')

@section('title', 'Ürünlerim')
@section('page-title', '📦 Ürünlerim')
@section('page-subtitle', 'Bayi ürün yönetimi')

@section('content')
<div class="space-y-6">
    <!-- Ürün İstatistikleri -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Toplam Ürün</p>
                    <p class="text-2xl font-bold text-blue-600">156</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Aktif Ürün</p>
                    <p class="text-2xl font-bold text-green-600">142</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Stokta Olmayan</p>
                    <p class="text-2xl font-bold text-red-600">8</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Bu Ay Satış</p>
                    <p class="text-2xl font-bold text-purple-600">₺45,230</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Ürün Filtreleri -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-64">
                <input type="text" placeholder="Ürün ara..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>Tüm Kategoriler</option>
                <option>Elektronik</option>
                <option>Giyim</option>
                <option>Ev & Yaşam</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>Tüm Durumlar</option>
                <option>Aktif</option>
                <option>Pasif</option>
                <option>Stokta Yok</option>
            </select>
            <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                Filtrele
            </button>
        </div>
    </div>

    <!-- Ürün Listesi -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Ürünlerim</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ürün</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fiyat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Ürün 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://via.placeholder.com/40x40" alt="Ürün" class="w-10 h-10 rounded-lg mr-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Örnek Ürün 1</div>
                                    <div class="text-sm text-gray-500">SKU: PRD001</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Elektronik</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">45</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺299.99</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Aktif</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Düzenle</button>
                                <button class="text-red-600 hover:text-red-900">Sil</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Ürün 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://via.placeholder.com/40x40" alt="Ürün" class="w-10 h-10 rounded-lg mr-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Örnek Ürün 2</div>
                                    <div class="text-sm text-gray-500">SKU: PRD002</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Giyim</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">0</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺149.99</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Stokta Yok</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Düzenle</button>
                                <button class="text-red-600 hover:text-red-900">Sil</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Ürün 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="https://via.placeholder.com/40x40" alt="Ürün" class="w-10 h-10 rounded-lg mr-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Örnek Ürün 3</div>
                                    <div class="text-sm text-gray-500">SKU: PRD003</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Ev & Yaşam</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺199.99</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Aktif</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Düzenle</button>
                                <button class="text-red-600 hover:text-red-900">Sil</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Toplam 156 ürün gösteriliyor
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Önceki</button>
                    <button class="px-3 py-2 bg-blue-500 text-white rounded-lg">1</button>
                    <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">2</button>
                    <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">3</button>
                    <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Sonraki</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toplu İşlemler -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Toplu İşlemler</h3>
        <div class="flex flex-wrap gap-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Seçilenleri Aktif Et
            </button>
            <button class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Seçilenleri Pasif Et
            </button>
            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                Stok Güncelle
            </button>
            <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                Seçilenleri Sil
            </button>
        </div>
    </div>
</div>
@endsection

