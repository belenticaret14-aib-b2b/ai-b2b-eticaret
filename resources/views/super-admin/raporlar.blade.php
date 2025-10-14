@extends('layouts.app')

@section('title', 'Raporlar')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">📊 Raporlar</h1>
                    <p class="mt-2 text-gray-600">Detaylı sistem raporları ve analizler</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('super-admin.dashboard') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        ← Geri Dön
                    </a>
                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        📥 Excel İndir
                    </button>
                </div>
            </div>
        </div>

        <!-- Rapor Kartları -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Kullanıcı Raporu -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Kullanıcı Raporu</h3>
                        <p class="text-sm text-gray-600">Aktif kullanıcı istatistikleri</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Raporu Görüntüle
                    </button>
                </div>
            </div>

            <!-- Sipariş Raporu -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Sipariş Raporu</h3>
                        <p class="text-sm text-gray-600">Sipariş analizi ve trendler</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Raporu Görüntüle
                    </button>
                </div>
            </div>

            <!-- Finansal Rapor -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Finansal Rapor</h3>
                        <p class="text-sm text-gray-600">Gelir ve gider analizi</p>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                        Raporu Görüntüle
                    </button>
                </div>
            </div>
        </div>

        <!-- Detaylı Raporlar -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Detaylı Raporlar</h3>
                <p class="text-gray-600 mt-1">Sistem performansı ve kullanım istatistikleri</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sistem Performansı -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Sistem Performansı</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium">CPU Kullanımı</span>
                                <span class="text-sm text-gray-600">45%</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium">RAM Kullanımı</span>
                                <span class="text-sm text-gray-600">2.1GB / 4GB</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium">Disk Kullanımı</span>
                                <span class="text-sm text-gray-600">15.2GB / 50GB</span>
                            </div>
                        </div>
                    </div>

                    <!-- Veritabanı İstatistikleri -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Veritabanı İstatistikleri</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium">Toplam Tablo</span>
                                <span class="text-sm text-gray-600">25</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium">Toplam Kayıt</span>
                                <span class="text-sm text-gray-600">1,247</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium">Veritabanı Boyutu</span>
                                <span class="text-sm text-gray-600">2.3MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




