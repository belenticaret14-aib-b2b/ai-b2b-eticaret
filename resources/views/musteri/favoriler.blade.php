@extends('layouts.app')

@section('title', 'Favorilerim')
@section('page-title', '❤️ Favorilerim')
@section('page-subtitle', 'Beğendiğiniz ürünler')

@section('content')
<div class="space-y-6">
    <!-- Favori Ürünler -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Ürün 1 -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="relative">
                <img src="https://via.placeholder.com/300x200" alt="Ürün" class="w-full h-48 object-cover rounded-t-lg">
                <button class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition">
                    <i class="fas fa-heart text-sm"></i>
                </button>
                <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded text-xs">
                    %20 İndirim
                </span>
            </div>
            
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-2">Örnek Ürün 1</h3>
                <p class="text-gray-600 text-sm mb-3">Ürün açıklaması burada yer alacak...</p>
                
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-red-600">₺199.99</span>
                        <span class="text-sm text-gray-500 line-through">₺249.99</span>
                    </div>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-sm text-gray-600 ml-1">(4.5)</span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                        Sepete Ekle
                    </button>
                    <button class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Ürün 2 -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="relative">
                <img src="https://via.placeholder.com/300x200" alt="Ürün" class="w-full h-48 object-cover rounded-t-lg">
                <button class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition">
                    <i class="fas fa-heart text-sm"></i>
                </button>
            </div>
            
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-2">Örnek Ürün 2</h3>
                <p class="text-gray-600 text-sm mb-3">Ürün açıklaması burada yer alacak...</p>
                
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-gray-900">₺299.99</span>
                    </div>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-600 ml-1">(4.0)</span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                        Sepete Ekle
                    </button>
                    <button class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Ürün 3 -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="relative">
                <img src="https://via.placeholder.com/300x200" alt="Ürün" class="w-full h-48 object-cover rounded-t-lg">
                <button class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition">
                    <i class="fas fa-heart text-sm"></i>
                </button>
                <span class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 rounded text-xs">
                    Yeni
                </span>
            </div>
            
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-2">Örnek Ürün 3</h3>
                <p class="text-gray-600 text-sm mb-3">Ürün açıklaması burada yer alacak...</p>
                
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-gray-900">₺149.99</span>
                    </div>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-600 ml-1">(5.0)</span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                        Sepete Ekle
                    </button>
                    <button class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Ürün 4 -->
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="relative">
                <img src="https://via.placeholder.com/300x200" alt="Ürün" class="w-full h-48 object-cover rounded-t-lg">
                <button class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition">
                    <i class="fas fa-heart text-sm"></i>
                </button>
            </div>
            
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-2">Örnek Ürün 4</h3>
                <p class="text-gray-600 text-sm mb-3">Ürün açıklaması burada yer alacak...</p>
                
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="text-lg font-bold text-gray-900">₺399.99</span>
                    </div>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <span class="text-sm text-gray-600 ml-1">(3.5)</span>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                        Sepete Ekle
                    </button>
                    <button class="bg-gray-200 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Boş Durum -->
    <div class="text-center py-12 hidden">
        <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Henüz favori ürününüz yok</h3>
        <p class="text-gray-500 mb-6">Beğendiğiniz ürünleri favorilere ekleyerek burada görüntüleyebilirsiniz.</p>
        <a href="{{ route('urunler') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
            Ürünleri Keşfet
        </a>
    </div>
</div>
@endsection

