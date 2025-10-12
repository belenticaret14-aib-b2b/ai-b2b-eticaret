@extends('layouts.admin')

@section('title', 'Proje Detayları')
@section('page-title', 'Proje Detayları')
@section('page-subtitle', 'Geliştirme aşamaları, özellikler ve roadmap')

@section('sidebar')
<div class="px-4 space-y-2">
    <!-- Dashboard -->
    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Dashboard
    </a>

    <!-- Kullanıcılar -->
    <a href="{{ route('super-admin.kullanicilar') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
        </svg>
        Kullanıcılar
    </a>

    <!-- Mağazalar -->
    <a href="{{ route('super-admin.magazalar') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        Mağazalar
    </a>

    <!-- Bayiler -->
    <a href="{{ route('super-admin.bayiler') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        Bayiler
    </a>

    <!-- Sistem Ayarları -->
    <a href="{{ route('super-admin.sistem-ayarlari') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Sistem Ayarları
    </a>

    <!-- Raporlar -->
    <a href="{{ route('super-admin.raporlar') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        Raporlar
    </a>

    <!-- Geliştirici -->
    <a href="{{ route('super-admin.gelistirici') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
        </svg>
        Geliştirici
    </a>

    <!-- Proje Detayları - Active -->
    <a href="{{ route('super-admin.proje-detaylari') }}" class="flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
        </svg>
        Proje Detayları
    </a>
</div>
@endsection

@section('content')
<!-- Proje Genel Bilgileri -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">📋 Proje Genel Bilgileri</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">AI B2B</div>
                <div class="text-sm text-gray-600">E-Ticaret Platformu</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600 mb-2">Laravel 12</div>
                <div class="text-sm text-gray-600">Framework</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600 mb-2">v1.0</div>
                <div class="text-sm text-gray-600">Sürüm</div>
            </div>
        </div>
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h4 class="font-medium text-gray-900 mb-2">🎯 Proje Amacı</h4>
            <p class="text-gray-600">Trendyol, Hepsiburada, N11, Amazon gibi platformlarla entegre çalışan, B2B ve B2C e-ticaret çözümleri sunan kapsamlı bir e-ticaret platformu.</p>
        </div>
    </div>
</div>

<!-- Geliştirme Aşamaları -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">🚀 Geliştirme Aşamaları</h3>
    </div>
    <div class="p-6">
        <div class="space-y-6">
            <!-- Aşama 1: Temel Altyapı -->
            <div class="border-l-4 border-green-500 pl-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">✅ Aşama 1: Temel Altyapı</h4>
                        <p class="text-sm text-gray-600">Laravel kurulumu, veritabanı yapısı, temel modeller</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Tamamlandı</span>
                </div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="text-sm">
                        <strong>Tamamlanan:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Laravel 12 kurulumu</li>
                            <li>Veritabanı migration'ları</li>
                            <li>Eloquent modeller</li>
                            <li>Repository pattern</li>
                            <li>Middleware yapısı</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Aşama 2: Kullanıcı Yönetimi -->
            <div class="border-l-4 border-green-500 pl-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">✅ Aşama 2: Kullanıcı Yönetimi</h4>
                        <p class="text-sm text-gray-600">Rol tabanlı erişim kontrolü, admin panelleri</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Tamamlandı</span>
                </div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="text-sm">
                        <strong>Tamamlanan:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Super Admin paneli</li>
                            <li>Store Admin paneli</li>
                            <li>Dealer Admin paneli</li>
                            <li>Rol tabanlı middleware</li>
                            <li>Kullanıcı seeder'ları</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Aşama 3: Platform Entegrasyonları -->
            <div class="border-l-4 border-blue-500 pl-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">🔄 Aşama 3: Platform Entegrasyonları</h4>
                        <p class="text-sm text-gray-600">Trendyol, Hepsiburada, N11, Amazon API entegrasyonları</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">Geliştirme Aşamasında</span>
                </div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="text-sm">
                        <strong>Yapılan:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>PlatformEntegrasyonService</li>
                            <li>API endpoint'leri</li>
                            <li>Webhook yapısı</li>
                            <li>Senkronizasyon logları</li>
                        </ul>
                    </div>
                    <div class="text-sm">
                        <strong>Yapılacak:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Trendyol API entegrasyonu</li>
                            <li>Hepsiburada API entegrasyonu</li>
                            <li>N11 API entegrasyonu</li>
                            <li>Amazon API entegrasyonu</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Aşama 4: Bot Sistemi -->
            <div class="border-l-4 border-green-500 pl-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">✅ Aşama 4: Bot Sistemi</h4>
                        <p class="text-sm text-gray-600">WhatsApp, Telegram, Discord bot entegrasyonları</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Tamamlandı</span>
                </div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="text-sm">
                        <strong>Tamamlanan:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>BotController</li>
                            <li>Webhook handler'ları</li>
                            <li>Bot ayarları sayfası</li>
                            <li>Test mesaj sistemi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Aşama 5: Hata Analiz Sistemi -->
            <div class="border-l-4 border-green-500 pl-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">✅ Aşama 5: Hata Analiz Sistemi</h4>
                        <p class="text-sm text-gray-600">Otomatik hata tespiti ve çözüm önerileri</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Tamamlandı</span>
                </div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="text-sm">
                        <strong>Tamamlanan:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>HataAnalizBotService</li>
                            <li>Sistem sağlık kontrolü</li>
                            <li>Hata link kontrolü</li>
                            <li>Otomatik düzeltme</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Aşama 6: Frontend Geliştirme -->
            <div class="border-l-4 border-yellow-500 pl-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">⏳ Aşama 6: Frontend Geliştirme</h4>
                        <p class="text-sm text-gray-600">Modern UI/UX, responsive tasarım</p>
                    </div>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Planlanan</span>
                </div>
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="text-sm">
                        <strong>Yapılacak:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Modern dashboard tasarımı</li>
                            <li>Responsive mobil uyumluluk</li>
                            <li>Dark mode desteği</li>
                            <li>Gelişmiş grafik ve raporlar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teknik Özellikler -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">⚙️ Teknik Özellikler</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-2">🔧 Backend</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Laravel 12 Framework</li>
                    <li>• PHP 8.2+</li>
                    <li>• SQLite Database</li>
                    <li>• Eloquent ORM</li>
                    <li>• Repository Pattern</li>
                </ul>
            </div>
            
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-2">🎨 Frontend</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• TailwindCSS</li>
                    <li>• Alpine.js</li>
                    <li>• Vite Build Tool</li>
                    <li>• Blade Templates</li>
                    <li>• Responsive Design</li>
                </ul>
            </div>
            
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-2">🔗 Entegrasyonlar</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Trendyol API</li>
                    <li>• Hepsiburada API</li>
                    <li>• N11 API</li>
                    <li>• Amazon API</li>
                    <li>• WhatsApp Bot</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Yapılabilir Özellikler -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">💡 Yapılabilir Özellikler</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">🚀 Yüksek Öncelik</h4>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                        <span class="text-sm">Gerçek platform API entegrasyonları</span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                        <span class="text-sm">Otomatik stok senkronizasyonu</span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                        <span class="text-sm">Sipariş yönetim sistemi</span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-3"></span>
                        <span class="text-sm">Fatura ve muhasebe entegrasyonu</span>
                    </li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">⚡ Orta Öncelik</h4>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                        <span class="text-sm">Mobil uygulama (React Native)</span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                        <span class="text-sm">AI destekli ürün önerileri</span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                        <span class="text-sm">Çoklu dil desteği</span>
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></span>
                        <span class="text-sm">Gelişmiş raporlama sistemi</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Eklenen Linkler -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">🔗 Eklenen Linkler</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">📊 Admin Panelleri</h4>
                <div class="space-y-2">
                    <a href="{{ route('super-admin.dashboard') }}" class="block p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <div class="font-medium text-blue-900">Super Admin Dashboard</div>
                        <div class="text-sm text-blue-700">Sistem geneli yönetim</div>
                    </a>
                    <a href="{{ route('store-admin.dashboard') }}" class="block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <div class="font-medium text-green-900">Store Admin Dashboard</div>
                        <div class="text-sm text-green-700">Mağaza yönetimi</div>
                    </a>
                    <a href="{{ route('dealer-admin.dashboard') }}" class="block p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                        <div class="font-medium text-purple-900">Dealer Admin Dashboard</div>
                        <div class="text-sm text-purple-700">Bayi yönetimi</div>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">🛠️ Geliştirici Araçları</h4>
                <div class="space-y-2">
                    <a href="{{ route('super-admin.gelistirici') }}" class="block p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                        <div class="font-medium text-orange-900">Geliştirici Sayfası</div>
                        <div class="text-sm text-orange-700">API, Bot, Hata analiz</div>
                    </a>
                    <a href="{{ route('super-admin.bot-ayarlari') }}" class="block p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition">
                        <div class="font-medium text-pink-900">Bot Ayarları</div>
                        <div class="text-sm text-pink-700">WhatsApp, Telegram, Discord</div>
                    </a>
                    <a href="{{ route('vitrin.index') }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="font-medium text-gray-900">Ana Sayfa</div>
                        <div class="text-sm text-gray-700">Vitrin ve ürün kataloğu</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


