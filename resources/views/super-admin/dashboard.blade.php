@extends('layouts.admin')

@section('title', 'Süper Admin Dashboard')
@section('page-title', 'Süper Admin Dashboard')
@section('page-subtitle', 'Sistem geneli yönetim paneli')

@section('sidebar')
<div class="px-4 space-y-2">
    <!-- Dashboard -->
    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md">
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
</div>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Toplam Kullanıcı</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['toplam_kullanici'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">Kayıtlı kullanıcı sayısı</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktif Mağaza</h3>
        <p class="text-3xl font-bold text-green-600">{{ $stats['aktif_magaza'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">Platform entegrasyonları</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Toplam Bayi</h3>
        <p class="text-3xl font-bold text-purple-600">{{ $stats['toplam_bayi'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">B2B bayiler</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ana Mağaza</h3>
        <p class="text-3xl font-bold text-orange-600">{{ $stats['ana_magaza'] ?? 0 }}</p>
        <p class="text-sm text-gray-600">Ana mağaza sayısı</p>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Son Siparişler</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sipariş No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Müşteri</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($son_siparisler ?? [] as $siparis)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #{{ $siparis->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $siparis->kullanici->ad ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ₺{{ number_format($siparis->toplam_tutar, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($siparis->durum == 'tamamlandi') bg-green-100 text-green-800
                            @elseif($siparis->durum == 'beklemede') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($siparis->durum) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $siparis->created_at->format('d.m.Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Henüz sipariş bulunmuyor</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Store Statistics -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Mağaza İstatistikleri</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($magaza_istatistikleri ?? [] as $magaza)
            <div class="border rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">{{ $magaza->ad }}</h4>
                <div class="space-y-1 text-sm text-gray-600">
                    <p>Platform: {{ ucfirst($magaza->platform ?? 'N/A') }}</p>
                    <p>Durum: {{ $magaza->durum ? 'Aktif' : 'Pasif' }}</p>
                    <p>Son Senkron: {{ $magaza->son_senkron ? $magaza->son_senkron->format('d.m.Y H:i') : 'Hiç' }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-500 py-8">Henüz mağaza bulunmuyor</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Hızlı İşlemler</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('super-admin.kullanicilar') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900">👥 Kullanıcı Yönetimi</p>
                    <p class="text-sm text-gray-600">Kullanıcıları görüntüle ve yönet</p>
                </div>
            </a>
            
            <a href="{{ route('super-admin.magazalar') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900">🏪 Mağaza Yönetimi</p>
                    <p class="text-sm text-gray-600">Platform entegrasyonlarını yönet</p>
                </div>
            </a>
            
            <a href="{{ route('super-admin.gelistirici') }}" class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                <svg class="w-8 h-8 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                </svg>
                <div>
                    <p class="font-medium text-gray-900">🚀 Geliştirici</p>
                    <p class="text-sm text-gray-600">API, Bot ve Geliştirici Araçları</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection