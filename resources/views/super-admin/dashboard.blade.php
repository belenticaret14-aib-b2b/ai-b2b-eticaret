@extends('super-admin.layouts.app')

@section('title', 'Süper Admin Dashboard')
@section('page-title', '👑 Süper Admin Dashboard')
@section('page-subtitle', 'Sistem yönetimi ve genel bakış')

@section('content')
<div class="space-y-8">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">👑 Hoş Geldiniz, Süper Admin!</h2>
                <p class="text-purple-100 text-lg">Sisteminizi yönetin ve tüm modülleri kontrol edin</p>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-full">
                <i class="fas fa-crown text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Toplam Kullanıcı</p>
                    <p class="text-3xl font-bold text-gray-900">156</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Aktif Mağaza</p>
                    <p class="text-3xl font-bold text-gray-900">12</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-store text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Toplam Ürün</p>
                    <p class="text-3xl font-bold text-gray-900">2,847</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Aktif Bayi</p>
                    <p class="text-3xl font-bold text-gray-900">28</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <i class="fas fa-handshake text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Ürün Yönetimi -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">📦 Ürün Yönetimi</h3>
                <a href="{{ route('super-admin.urunler.index') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Yönet
                </a>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <span class="text-gray-700">Toplam Ürün</span>
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold">2,847</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <span class="text-gray-700">Aktif Ürün</span>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">2,156</span>
                </div>
            </div>
        </div>

        <!-- Kategori Yönetimi -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">📂 Kategori Yönetimi</h3>
                <a href="{{ route('super-admin.kategoriler.index') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Yönet
                </a>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <span class="text-gray-700">Toplam Kategori</span>
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold">24</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <span class="text-gray-700">Aktif Kategori</span>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">18</span>
                </div>
            </div>
        </div>

        <!-- Modül Yönetimi -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">🔧 Modül Yönetimi</h3>
                <a href="{{ route('super-admin.modules.index') }}" 
                   class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Yönet
                </a>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <span class="text-gray-700">Aktif Modül</span>
                    <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-bold">8</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-700">Pasif Modül</span>
                    <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-sm font-bold">3</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">⚡ Hızlı İşlemler</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <a href="{{ route('super-admin.urunler.create') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-plus text-2xl mb-2"></i>
                <p class="font-medium">Yeni Ürün</p>
            </a>
            
            <a href="{{ route('super-admin.kategoriler.create') }}" 
               class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-folder-plus text-2xl mb-2"></i>
                <p class="font-medium">Yeni Kategori</p>
            </a>
            
            <a href="{{ route('super-admin.modules.create') }}" 
               class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-cube text-2xl mb-2"></i>
                <p class="font-medium">Yeni Modül</p>
            </a>
            
            <a href="{{ route('super-admin.theme') }}" 
               class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-palette text-2xl mb-2"></i>
                <p class="font-medium">Tema Ayarları</p>
            </a>
            
            <a href="{{ route('super-admin.claude') }}" 
               class="bg-orange-500 hover:bg-orange-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-robot text-2xl mb-2"></i>
                <p class="font-medium">Claude AI</p>
            </a>
        </div>
    </div>

    <!-- Development Tools -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">🛠️ Geliştirici Araçları</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('super-admin.hatali-link-kontrol') }}" 
               class="bg-red-500 hover:bg-red-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-search text-2xl mb-2"></i>
                <p class="font-medium">Hatalı Link Kontrolü</p>
                <p class="text-xs text-red-100 mt-1">Sistemdeki bozuk linkleri tespit et</p>
            </a>
            
            <a href="{{ route('super-admin.gelistirici') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-code text-2xl mb-2"></i>
                <p class="font-medium">Geliştirici Sayfası</p>
                <p class="text-xs text-blue-100 mt-1">Proje geliştirme araçları</p>
            </a>
            
            <a href="{{ route('super-admin.proje-detaylari') }}" 
               class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-project-diagram text-2xl mb-2"></i>
                <p class="font-medium">Proje Detayları</p>
                <p class="text-xs text-green-100 mt-1">Geliştirme roadmap'i</p>
            </a>
        </div>
    </div>

    <!-- E-Ticaret Yönetimi -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">🛒 E-Ticaret Yönetimi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('urunler') }}" 
               class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-box text-2xl mb-2"></i>
                <p class="font-medium">Ürünler</p>
                <p class="text-xs text-purple-100 mt-1">Ürün listesini görüntüle</p>
            </a>
            
            <a href="{{ route('sepet') }}" 
               class="bg-orange-500 hover:bg-orange-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-shopping-cart text-2xl mb-2"></i>
                <p class="font-medium">Sepet Sistemi</p>
                <p class="text-xs text-orange-100 mt-1">Sepet işlemlerini test et</p>
            </a>
            
            <a href="{{ route('anasayfa') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-home text-2xl mb-2"></i>
                <p class="font-medium">Ana Mağaza</p>
                <p class="text-xs text-blue-100 mt-1">E-ticaret sitesini görüntüle</p>
            </a>
            
            <a href="{{ route('admin.panel') }}" 
               class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition-colors">
                <i class="fas fa-cog text-2xl mb-2"></i>
                <p class="font-medium">Admin Panel</p>
                <p class="text-xs text-green-100 mt-1">Mağaza yönetimi</p>
            </a>
        </div>
    </div>

    <!-- System Status -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">🔍 Sistem Durumu</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <i class="fas fa-database text-green-500 text-3xl mb-2"></i>
                <p class="font-semibold text-green-700">Veritabanı</p>
                <p class="text-green-600 text-sm">Sağlıklı</p>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <i class="fas fa-server text-green-500 text-3xl mb-2"></i>
                <p class="font-semibold text-green-700">Sunucu</p>
                <p class="text-green-600 text-sm">Çalışıyor</p>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <i class="fas fa-plug text-green-500 text-3xl mb-2"></i>
                <p class="font-semibold text-green-700">API Bağlantıları</p>
                <p class="text-green-600 text-sm">Aktif</p>
            </div>
        </div>
    </div>
</div>
@endsection
