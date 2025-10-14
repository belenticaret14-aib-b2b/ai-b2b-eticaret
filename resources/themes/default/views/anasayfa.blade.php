@extends('themes::default.layouts.app')

@section('title', 'NetMarketiniz AI-B2B E-Ticaret Platformu')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">
                🚀 NetMarketiniz AI-B2B E-Ticaret Platformu
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Bayi, mağaza ve admin yönetimi ile ürünlerinizi kolayca yönetin. 
                Hepsiburada, Trendyol entegrasyonu ve Claude AI ile akıllı öneriler burada!
            </p>
            
            <!-- Hızlı Giriş Butonları -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <a href="{{ route('bayi.login') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    🤝 Bayi Girişi
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    👑 Admin Paneli
                </a>
                <a href="{{ route('urunler') }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    🛍️ Ürünleri Görüntüle
                </a>
            </div>
            
            <!-- Tema Bilgisi -->
            <div class="bg-gray-100 rounded-lg p-6 max-w-2xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">🎨 Varsayılan Tema</h2>
                <p class="text-gray-600 mb-4">
                    Bu varsayılan Laravel Breeze temasıdır. Admin panelinden farklı temalar seçebilirsiniz.
                </p>
                <a href="{{ route('admin.theme') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    → Tema Seçici'ye Git
                </a>
            </div>
        </div>
    </div>

    <!-- Demo Girişler (Sadece Local) -->
    @if(app()->environment('local'))
    <div class="container mx-auto px-4 pb-16">
        <div class="bg-gray-50 rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">🧪 Demo Hızlı Giriş (Local Geliştirme)</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('dev.login', 'super_admin') }}" 
                   class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all">
                    <div class="text-2xl mb-2">👑</div>
                    <div>Super Admin</div>
                </a>
                <a href="{{ route('dev.login', 'admin') }}" 
                   class="bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all">
                    <div class="text-2xl mb-2">⚙️</div>
                    <div>Admin</div>
                </a>
                <a href="{{ route('dev.login', 'bayi') }}" 
                   class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all">
                    <div class="text-2xl mb-2">🤝</div>
                    <div>Bayi</div>
                </a>
                <a href="{{ route('dev.login', 'musteri') }}" 
                   class="bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white px-6 py-4 rounded-lg font-semibold text-center transition-all">
                    <div class="text-2xl mb-2">👤</div>
                    <div>Müşteri</div>
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

