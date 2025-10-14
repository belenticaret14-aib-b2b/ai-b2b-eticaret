@extends('layouts.app')

@section('title', 'NetMarketiniz AI-B2B E-Ticaret Platformu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="space-y-4">
                    <h1 class="text-5xl font-bold text-gray-900 leading-tight">
                        🚀 NetMarketiniz 
                        <span class="text-blue-600">AI-B2B</span> 
                        E-Ticaret Platformu
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Bayi, mağaza ve admin yönetimi ile ürünlerinizi kolayca yönetin. 
                        <span class="font-semibold text-blue-600">Hepsiburada, Trendyol</span> entegrasyonu ve 
                        <span class="font-semibold text-purple-600">Claude AI</span> ile akıllı öneriler burada!
                    </p>
                </div>

                <!-- Hızlı Giriş Butonları -->
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('bayi.login') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 shadow-lg hover:shadow-xl">
                        🤝 Bayi Girişi
                    </a>
                    <a href="{{ route('login') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 shadow-lg hover:shadow-xl">
                        👑 Admin Paneli
                    </a>
                    <a href="{{ route('urunler') }}" 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors duration-300 shadow-lg hover:shadow-xl">
                        🛍️ Ürünleri Görüntüle
                    </a>
                </div>

                <!-- Özellikler -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-8">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-robot text-blue-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Claude AI Entegrasyonu</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-green-100 p-2 rounded-full">
                            <i class="fas fa-store text-green-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Platform Entegrasyonları</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-purple-100 p-2 rounded-full">
                            <i class="fas fa-chart-line text-purple-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Akıllı Raporlama</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-orange-100 p-2 rounded-full">
                            <i class="fas fa-users text-orange-600"></i>
                        </div>
                        <span class="text-gray-700 font-medium">Çoklu Kullanıcı Yönetimi</span>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="bg-white rounded-2xl shadow-2xl p-8 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80" 
                         class="w-full h-auto rounded-xl shadow-lg" 
                         alt="AI B2B E-Ticaret Platform">
                </div>
                <!-- Floating Elements -->
                <div class="absolute -top-4 -right-4 bg-blue-500 text-white p-3 rounded-full shadow-lg animate-bounce">
                    <i class="fas fa-rocket text-xl"></i>
                </div>
                <div class="absolute -bottom-4 -left-4 bg-green-500 text-white p-3 rounded-full shadow-lg animate-pulse">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Demo Girişler (Sadece Local) -->
    @if(app()->environment('local'))
    <div class="container mx-auto px-4 pb-16">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">🧪 Demo Hızlı Giriş (Local Geliştirme)</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('dev.login', 'super_admin') }}" 
                   class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <div class="text-2xl mb-2">👑</div>
                    <div>Super Admin</div>
                </a>
                <a href="{{ route('dev.login', 'admin') }}" 
                   class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <div class="text-2xl mb-2">⚙️</div>
                    <div>Admin</div>
                </a>
                <a href="{{ route('dev.login', 'bayi') }}" 
                   class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <div class="text-2xl mb-2">🤝</div>
                    <div>Bayi</div>
                </a>
                <a href="{{ route('dev.login', 'musteri') }}" 
                   class="bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <div class="text-2xl mb-2">👤</div>
                    <div>Müşteri</div>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
