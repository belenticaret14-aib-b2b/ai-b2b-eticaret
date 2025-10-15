@extends('layouts.app')

@section('title', 'Siparişlerim')
@section('page-title', '📦 Siparişlerim')
@section('page-subtitle', 'Geçmiş ve aktif siparişleriniz')

@section('content')
<div class="space-y-6">
    <!-- Sipariş Filtreleri -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-wrap gap-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Tümü
            </button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                Beklemede
            </button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                Hazırlanıyor
            </button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                Kargoda
            </button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                Teslim Edildi
            </button>
        </div>
    </div>

    <!-- Sipariş Listesi -->
    <div class="space-y-4">
        <!-- Örnek Sipariş -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Sipariş #12345</h3>
                    <p class="text-gray-600">15 Ocak 2025</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-green-600">₺299.99</p>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">
                        Teslim Edildi
                    </span>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="flex items-center space-x-4">
                    <img src="https://via.placeholder.com/60x60" alt="Ürün" class="w-15 h-15 rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium">Örnek Ürün 1</h4>
                        <p class="text-gray-600 text-sm">Adet: 2</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">₺199.99</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-4 pt-4 border-t">
                <div class="flex space-x-2">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        Detayları Gör
                    </button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                        Tekrar Sipariş Ver
                    </button>
                </div>
                <button class="text-blue-600 hover:text-blue-800 transition">
                    Fatura İndir
                </button>
            </div>
        </div>

        <!-- Başka Sipariş -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold">Sipariş #12344</h3>
                    <p class="text-gray-600">12 Ocak 2025</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-orange-600">₺149.99</p>
                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-sm">
                        Kargoda
                    </span>
                </div>
            </div>
            
            <div class="border-t pt-4">
                <div class="flex items-center space-x-4">
                    <img src="https://via.placeholder.com/60x60" alt="Ürün" class="w-15 h-15 rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium">Örnek Ürün 2</h4>
                        <p class="text-gray-600 text-sm">Adet: 1</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium">₺149.99</p>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-4 pt-4 border-t">
                <div class="flex space-x-2">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        Detayları Gör
                    </button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                        Kargo Takip
                    </button>
                </div>
                <button class="text-blue-600 hover:text-blue-800 transition">
                    Fatura İndir
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

