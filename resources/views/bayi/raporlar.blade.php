@extends('layouts.app')

@section('title', 'Raporlarım')
@section('page-title', '📊 Raporlarım')
@section('page-subtitle', 'Bayi performans ve satış raporları')

@section('content')
<div class="space-y-6">
    <!-- Rapor Filtreleri -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Rapor Filtreleri</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tarih Aralığı</label>
                <input type="date" value="2025-01-01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bitiş Tarihi</label>
                <input type="date" value="2025-01-15" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Tüm Kategoriler</option>
                    <option>Elektronik</option>
                    <option>Giyim</option>
                    <option>Ev & Yaşam</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Rapor Oluştur
                </button>
            </div>
        </div>
    </div>

    <!-- Özet Kartlar -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Toplam Satış</p>
                    <p class="text-2xl font-bold text-blue-600">₺125,430</p>
                    <p class="text-sm text-green-600">+12.5% bu ay</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Toplam Sipariş</p>
                    <p class="text-2xl font-bold text-green-600">156</p>
                    <p class="text-sm text-green-600">+8.2% bu ay</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Ortalama Sepet</p>
                    <p class="text-2xl font-bold text-purple-600">₺804</p>
                    <p class="text-sm text-red-600">-2.1% bu ay</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-basket-shopping text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Müşteri Sayısı</p>
                    <p class="text-2xl font-bold text-orange-600">89</p>
                    <p class="text-sm text-green-600">+15.3% bu ay</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-users text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Raporları -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Satış Grafiği -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Satış Trendi</h3>
            <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <i class="fas fa-chart-area text-4xl mb-2"></i>
                    <p>Satış grafiği burada görüntülenecek</p>
                </div>
            </div>
        </div>

        <!-- Kategori Dağılımı -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Kategori Dağılımı</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-500 rounded mr-3"></div>
                        <span class="text-sm">Elektronik</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                        <span class="text-sm font-medium">45%</span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded mr-3"></div>
                        <span class="text-sm">Giyim</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 30%"></div>
                        </div>
                        <span class="text-sm font-medium">30%</span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-purple-500 rounded mr-3"></div>
                        <span class="text-sm">Ev & Yaşam</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 25%"></div>
                        </div>
                        <span class="text-sm font-medium">25%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detaylı Tablolar -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- En Çok Satan Ürünler -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">En Çok Satan Ürünler</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40x40" alt="Ürün" class="w-10 h-10 rounded-lg mr-3">
                        <div>
                            <p class="font-medium">Örnek Ürün 1</p>
                            <p class="text-sm text-gray-600">45 adet</p>
                        </div>
                    </div>
                    <span class="font-bold text-green-600">₺13,500</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40x40" alt="Ürün" class="w-10 h-10 rounded-lg mr-3">
                        <div>
                            <p class="font-medium">Örnek Ürün 2</p>
                            <p class="text-sm text-gray-600">32 adet</p>
                        </div>
                    </div>
                    <span class="font-bold text-green-600">₺9,600</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40x40" alt="Ürün" class="w-10 h-10 rounded-lg mr-3">
                        <div>
                            <p class="font-medium">Örnek Ürün 3</p>
                            <p class="text-sm text-gray-600">28 adet</p>
                        </div>
                    </div>
                    <span class="font-bold text-green-600">₺8,400</span>
                </div>
            </div>
        </div>

        <!-- Müşteri Analizi -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Müşteri Analizi</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm">Yeni Müşteriler</span>
                    <span class="font-bold text-blue-600">23</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm">Tekrar Eden Müşteriler</span>
                    <span class="font-bold text-green-600">66</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm">Ortalama Sipariş Sayısı</span>
                    <span class="font-bold text-purple-600">1.8</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm">Müşteri Sadakat Oranı</span>
                    <span class="font-bold text-orange-600">74%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rapor İndirme -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Rapor İndirme</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button class="bg-blue-500 text-white p-4 rounded-lg hover:bg-blue-600 transition">
                <i class="fas fa-file-excel text-2xl mb-2"></i>
                <p class="font-medium">Excel Raporu</p>
                <p class="text-sm opacity-90">Detaylı satış raporu</p>
            </button>
            
            <button class="bg-red-500 text-white p-4 rounded-lg hover:bg-red-600 transition">
                <i class="fas fa-file-pdf text-2xl mb-2"></i>
                <p class="font-medium">PDF Raporu</p>
                <p class="text-sm opacity-90">Özet rapor</p>
            </button>
            
            <button class="bg-green-500 text-white p-4 rounded-lg hover:bg-green-600 transition">
                <i class="fas fa-file-csv text-2xl mb-2"></i>
                <p class="font-medium">CSV Raporu</p>
                <p class="text-sm opacity-90">Ham veri</p>
            </button>
        </div>
    </div>
</div>
@endsection

