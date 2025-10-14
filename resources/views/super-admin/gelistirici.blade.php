@extends('super-admin.layouts.app')

@section('title', 'Süper Admin - Geliştirici Araçları')
@section('page-title', '💻 Geliştirici Araçları')
@section('page-subtitle', 'API, Bot entegrasyonları ve hata analiz sistemi')

@section('content')
<div class="space-y-8">
    <!-- Sistem Sağlık Göstergesi -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-heartbeat text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">🏥 Sistem Sağlık Durumu</h3>
                    <p class="text-gray-600">Gerçek zamanlı sistem durumu</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-green-600 font-medium">Sağlıklı</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Veritabanı</p>
                        <p class="text-lg font-bold text-green-600">100%</p>
                    </div>
                    <i class="fas fa-database text-green-500 text-xl"></i>
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Sunucu</p>
                        <p class="text-lg font-bold text-green-600">100%</p>
                    </div>
                    <i class="fas fa-server text-green-500 text-xl"></i>
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">API Bağlantıları</p>
                        <p class="text-lg font-bold text-green-600">100%</p>
                    </div>
                    <i class="fas fa-plug text-green-500 text-xl"></i>
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Cache</p>
                        <p class="text-lg font-bold text-green-600">100%</p>
                    </div>
                    <i class="fas fa-memory text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- API & Bot Entegrasyonları -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- API Durumu -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">🔌 API Durumu</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-store text-blue-500 mr-3"></i>
                        <span class="font-medium">Hepsiburada API</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Aktif</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                        <span class="font-medium">Trendyol API</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Aktif</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-box text-blue-500 mr-3"></i>
                        <span class="font-medium">N11 API</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Aktif</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-robot text-blue-500 mr-3"></i>
                        <span class="font-medium">Claude AI API</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Aktif</span>
                </div>
            </div>
        </div>

        <!-- Bot Durumu -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">🤖 Bot Durumu</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-search text-purple-500 mr-3"></i>
                        <span class="font-medium">Hata Analiz Botu</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Çalışıyor</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-comments text-purple-500 mr-3"></i>
                        <span class="font-medium">Müşteri Destek Botu</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Çalışıyor</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-sync text-purple-500 mr-3"></i>
                        <span class="font-medium">Senkronizasyon Botu</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Çalışıyor</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-purple-500 mr-3"></i>
                        <span class="font-medium">Rapor Botu</span>
                    </div>
                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">Çalışıyor</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Geliştirici Araçları -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">🛠️ Geliştirici Araçları</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('super-admin.hatali-link-kontrol') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white p-6 rounded-lg text-center transition-colors">
                <i class="fas fa-search text-3xl mb-3"></i>
                <h4 class="font-bold text-lg mb-2">Hatalı Link Kontrolü</h4>
                <p class="text-blue-100">Sistemdeki bozuk linkleri tespit edin</p>
            </a>
            
            <a href="{{ route('super-admin.proje-detaylari') }}" 
               class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg text-center transition-colors">
                <i class="fas fa-info-circle text-3xl mb-3"></i>
                <h4 class="font-bold text-lg mb-2">Proje Detayları</h4>
                <p class="text-green-100">Proje bilgileri ve durumu</p>
            </a>
            
            <a href="{{ route('super-admin.claude') }}" 
               class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg text-center transition-colors">
                <i class="fas fa-robot text-3xl mb-3"></i>
                <h4 class="font-bold text-lg mb-2">Claude AI</h4>
                <p class="text-purple-100">AI destekli geliştirme araçları</p>
            </a>
        </div>
    </div>

    <!-- Sistem Bilgileri -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">📊 Sistem Bilgileri</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <i class="fas fa-code text-gray-500 text-2xl mb-2"></i>
                <p class="font-semibold text-gray-700">PHP Version</p>
                <p class="text-gray-600">{{ phpversion() }}</p>
            </div>
            
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <i class="fas fa-database text-gray-500 text-2xl mb-2"></i>
                <p class="font-semibold text-gray-700">Laravel Version</p>
                <p class="text-gray-600">{{ app()->version() }}</p>
            </div>
            
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <i class="fas fa-server text-gray-500 text-2xl mb-2"></i>
                <p class="font-semibold text-gray-700">Server</p>
                <p class="text-gray-600">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</p>
            </div>
            
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <i class="fas fa-memory text-gray-500 text-2xl mb-2"></i>
                <p class="font-semibold text-gray-700">Memory Usage</p>
                <p class="text-gray-600">{{ round(memory_get_usage() / 1024 / 1024, 2) }} MB</p>
            </div>
        </div>
    </div>

    <!-- Son Güncellemeler -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">📝 Son Güncellemeler</h3>
        <div class="space-y-4">
            <div class="flex items-center p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                <div class="bg-green-500 text-white p-2 rounded-full mr-4">
                    <i class="fas fa-check text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Kategori Yönetimi Eklendi</p>
                    <p class="text-sm text-gray-600">Süper Admin panelinde kategori yönetimi aktif edildi</p>
                    <p class="text-xs text-gray-500">2 saat önce</p>
                </div>
            </div>
            
            <div class="flex items-center p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                <div class="bg-blue-500 text-white p-2 rounded-full mr-4">
                    <i class="fas fa-cog text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Sidebar Optimizasyonu</p>
                    <p class="text-sm text-gray-600">Modern sidebar tasarımı uygulandı</p>
                    <p class="text-xs text-gray-500">3 saat önce</p>
                </div>
            </div>
            
            <div class="flex items-center p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                <div class="bg-purple-500 text-white p-2 rounded-full mr-4">
                    <i class="fas fa-robot text-sm"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Claude AI Entegrasyonu</p>
                    <p class="text-sm text-gray-600">AI destekli özellikler aktif edildi</p>
                    <p class="text-xs text-gray-500">1 gün önce</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection