@extends('layouts.app')

@section('title', 'Ayarlarım')
@section('page-title', '⚙️ Ayarlarım')
@section('page-subtitle', 'Bayi hesap ve iş ayarları')

@section('content')
<div class="space-y-6">
    <!-- Bayi Bilgileri -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Bayi Bilgileri</h3>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bayi Adı</label>
                    <input type="text" value="Örnek Bayi Ltd." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vergi No</label>
                    <input type="text" value="1234567890" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Yetkili Kişi</label>
                    <input type="text" value="Ahmet Yılmaz" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                    <input type="tel" value="+90 555 123 45 67" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">E-posta</label>
                <input type="email" value="bayi@example.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Adres</label>
                <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">Kadıköy Mahallesi, Moda Caddesi No:123/5
34710 Kadıköy/İstanbul</textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Bilgileri Güncelle
                </button>
            </div>
        </form>
    </div>

    <!-- Komisyon Ayarları -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Komisyon Ayarları</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h4 class="font-medium">Elektronik Kategorisi</h4>
                    <p class="text-sm text-gray-600">Komisyon oranı</p>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="number" value="8" class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <span class="text-sm text-gray-600">%</span>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h4 class="font-medium">Giyim Kategorisi</h4>
                    <p class="text-sm text-gray-600">Komisyon oranı</p>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="number" value="12" class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <span class="text-sm text-gray-600">%</span>
                </div>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h4 class="font-medium">Ev & Yaşam Kategorisi</h4>
                    <p class="text-sm text-gray-600">Komisyon oranı</p>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="number" value="10" class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <span class="text-sm text-gray-600">%</span>
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-4">
            <button class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                Komisyonları Güncelle
            </button>
        </div>
    </div>

    <!-- Bildirim Ayarları -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Bildirim Ayarları</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-medium">Yeni Sipariş Bildirimleri</h4>
                    <p class="text-sm text-gray-600">Yeni sipariş geldiğinde bildirim al</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-medium">Stok Uyarıları</h4>
                    <p class="text-sm text-gray-600">Stok azaldığında bildirim al</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-medium">Ödeme Bildirimleri</h4>
                    <p class="text-sm text-gray-600">Ödeme alındığında bildirim al</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
            
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-medium">Sistem Güncellemeleri</h4>
                    <p class="text-sm text-gray-600">Sistem güncellemeleri hakkında bildirim al</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Güvenlik Ayarları -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Güvenlik Ayarları</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mevcut Şifre</label>
                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Yeni Şifre</label>
                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Yeni Şifre (Tekrar)</label>
                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div class="flex items-center">
                <input type="checkbox" id="2fa" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="2fa" class="ml-2 text-sm text-gray-700">İki faktörlü kimlik doğrulama</label>
            </div>
            
            <div class="flex justify-end">
                <button class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                    Şifreyi Değiştir
                </button>
            </div>
        </div>
    </div>

    <!-- Hesap Durumu -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Hesap Durumu</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                <div>
                    <h4 class="font-medium text-green-800">Hesap Durumu</h4>
                    <p class="text-sm text-green-600">Hesabınız aktif</p>
                </div>
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                    Aktif
                </span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                <div>
                    <h4 class="font-medium text-blue-800">Üyelik Tarihi</h4>
                    <p class="text-sm text-blue-600">15 Mart 2024</p>
                </div>
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    10 Ay
                </span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
                <div>
                    <h4 class="font-medium text-purple-800">Toplam Satış</h4>
                    <p class="text-sm text-purple-600">Bu ay: ₺45,230</p>
                </div>
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                    ₺125,430
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

