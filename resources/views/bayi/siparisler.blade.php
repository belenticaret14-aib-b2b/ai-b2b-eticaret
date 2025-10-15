@extends('layouts.app')

@section('title', 'Siparişlerim')
@section('page-title', '📦 Siparişlerim')
@section('page-subtitle', 'Bayi sipariş yönetimi')

@section('content')
<div class="space-y-6">
    <!-- Sipariş İstatistikleri -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Yeni Sipariş</p>
                    <p class="text-2xl font-bold text-blue-600">12</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Hazırlanıyor</p>
                    <p class="text-2xl font-bold text-orange-600">8</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Kargoda</p>
                    <p class="text-2xl font-bold text-purple-600">15</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-truck text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Bu Ay Gelir</p>
                    <p class="text-2xl font-bold text-green-600">₺45,230</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sipariş Filtreleri -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-64">
                <input type="text" placeholder="Sipariş ara..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>Tüm Durumlar</option>
                <option>Yeni</option>
                <option>Hazırlanıyor</option>
                <option>Kargoda</option>
                <option>Teslim Edildi</option>
                <option>İptal Edildi</option>
            </select>
            <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                Filtrele
            </button>
        </div>
    </div>

    <!-- Sipariş Listesi -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Siparişler</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sipariş No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Müşteri</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ürünler</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Sipariş 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#12345</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Ahmet Yılmaz</div>
                                <div class="text-sm text-gray-500">ahmet@example.com</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">3 ürün</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺299.99</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Yeni</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">15 Ocak 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Detay</button>
                                <button class="text-green-600 hover:text-green-900">Onayla</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Sipariş 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#12344</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Ayşe Demir</div>
                                <div class="text-sm text-gray-500">ayse@example.com</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1 ürün</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺149.99</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs">Hazırlanıyor</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">14 Ocak 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Detay</button>
                                <button class="text-purple-600 hover:text-purple-900">Kargoya Ver</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Sipariş 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#12343</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Mehmet Kaya</div>
                                <div class="text-sm text-gray-500">mehmet@example.com</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2 ürün</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺199.99</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">Kargoda</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">13 Ocak 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Detay</button>
                                <button class="text-gray-600 hover:text-gray-900">Takip</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Sipariş 4 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#12342</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">Fatma Öz</div>
                                <div class="text-sm text-gray-500">fatma@example.com</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1 ürün</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₺89.99</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Teslim Edildi</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12 Ocak 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="text-blue-600 hover:text-blue-900">Detay</button>
                                <button class="text-green-600 hover:text-green-900">Fatura</button>
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
                    Toplam 156 sipariş gösteriliyor
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
            <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                Seçilenleri Onayla
            </button>
            <button class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition">
                Seçilenleri Kargoya Ver
            </button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Fatura Oluştur
            </button>
            <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                Seçilenleri İptal Et
            </button>
        </div>
    </div>
</div>
@endsection

