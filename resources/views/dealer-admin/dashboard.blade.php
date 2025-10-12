@extends('layouts.app')

@section('title', 'Bayi Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Bayi Admin Dashboard</h1>
                    <p class="text-gray-600">{{ $bayi->ad ?? 'Bayi' }} yönetim paneli</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        Bayi Admin
                    </span>
                    <a href="{{ route('vitrin.index') }}" class="text-blue-600 hover:text-blue-800">
                        Siteye Git
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Toplam Ürün</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['toplam_urun'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Bayi Ürün</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['bayi_urun'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Toplam Sipariş</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['toplam_siparis'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Toplam Tutar</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['toplam_tutar'], 2) }} ₺</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bu Ay Siparişler</h3>
                <p class="text-3xl font-bold text-green-600">{{ $stats['bu_ay_siparis'] }}</p>
                <p class="text-sm text-gray-600">Bu ay oluşturulan siparişler</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bekleyen Siparişler</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['bekleyen_siparis'] }}</p>
                <p class="text-sm text-gray-600">Onay bekleyen siparişler</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bayi Bilgileri</h3>
                <p class="text-lg font-bold text-blue-600">{{ $bayi->ad ?? 'Bayi' }}</p>
                <p class="text-sm text-gray-600">{{ $bayi->durum ? 'Aktif' : 'Pasif' }} durumda</p>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Son Siparişler -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Son Siparişler</h3>
                </div>
                <div class="p-6">
                    @if($son_siparisler->count() > 0)
                        <div class="space-y-4">
                            @foreach($son_siparisler as $siparis)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">#{{ $siparis->id }}</p>
                                        <p class="text-sm text-gray-600">{{ $siparis->kullanici->ad ?? 'Misafir' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ number_format($siparis->toplam_tutar ?? 0, 2) }} ₺</p>
                                        <p class="text-sm text-gray-600">{{ $siparis->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Henüz sipariş bulunmuyor</p>
                    @endif
                </div>
            </div>

            <!-- Popüler Ürünler -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Popüler Ürünler</h3>
                </div>
                <div class="p-6">
                    @if($populer_urunler->count() > 0)
                        <div class="space-y-4">
                            @foreach($populer_urunler as $urun)
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $urun->ad }}</p>
                                        <p class="text-sm text-gray-600">{{ $urun->sku }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ $urun->siparis_urunleri_count }} sipariş</p>
                                        <p class="text-sm text-gray-600">{{ number_format($urun->fiyat, 2) }} ₺</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Henüz ürün bulunmuyor</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Hızlı İşlemler</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('dealer-admin.urunler') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Ürün Kataloğu</p>
                        <p class="text-sm text-gray-600">Ürünleri görüntüle</p>
                    </div>
                </a>

                <a href="{{ route('dealer-admin.siparisler') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Sipariş Yönetimi</p>
                        <p class="text-sm text-gray-600">Siparişleri yönet</p>
                    </div>
                </a>

                <a href="{{ route('dealer-admin.bayi-ayarlari') }}" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                    <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Bayi Ayarları</p>
                        <p class="text-sm text-gray-600">Bayi ayarlarını yönet</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


