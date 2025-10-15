@extends('layouts.app')

@section('title', 'Adreslerim')
@section('page-title', '📍 Adreslerim')
@section('page-subtitle', 'Teslimat ve fatura adreslerinizi yönetin')

@section('content')
<div class="space-y-6">
    <!-- Adres Ekleme -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Yeni Adres Ekle</h3>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ad Soyad</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                    <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Adres Başlığı</label>
                <input type="text" placeholder="Ev, İş, vs." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">İl</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>İstanbul</option>
                        <option>Ankara</option>
                        <option>İzmir</option>
                        <option>Bursa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">İlçe</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option>Kadıköy</option>
                        <option>Beşiktaş</option>
                        <option>Şişli</option>
                        <option>Beyoğlu</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Posta Kodu</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Detaylı Adres</label>
                <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Teslimat Adresi</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Fatura Adresi</span>
                </label>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                    Adresi Kaydet
                </button>
            </div>
        </form>
    </div>

    <!-- Mevcut Adresler -->
    <div class="space-y-4">
        <h3 class="text-lg font-semibold">Mevcut Adreslerim</h3>
        
        <!-- Adres 1 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-semibold">Ev Adresi</h4>
                    <p class="text-gray-600">Ahmet Yılmaz</p>
                    <p class="text-gray-600">+90 555 123 45 67</p>
                </div>
                <div class="flex space-x-2">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Teslimat</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Fatura</span>
                </div>
            </div>
            
            <div class="text-gray-700 mb-4">
                <p>Kadıköy Mahallesi, Moda Caddesi No:123/5</p>
                <p>34710 Kadıköy/İstanbul</p>
            </div>
            
            <div class="flex space-x-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm">
                    Düzenle
                </button>
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                    Sil
                </button>
            </div>
        </div>

        <!-- Adres 2 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-semibold">İş Adresi</h4>
                    <p class="text-gray-600">Ahmet Yılmaz</p>
                    <p class="text-gray-600">+90 555 123 45 67</p>
                </div>
                <div class="flex space-x-2">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Teslimat</span>
                </div>
            </div>
            
            <div class="text-gray-700 mb-4">
                <p>Levent Mahallesi, Büyükdere Caddesi No:456/12</p>
                <p>34330 Beşiktaş/İstanbul</p>
            </div>
            
            <div class="flex space-x-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm">
                    Düzenle
                </button>
                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                    Sil
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

