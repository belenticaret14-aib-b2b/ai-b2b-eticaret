@extends('layouts.app')

@section('title', 'Sipariş Detayı - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">📦 Sipariş Detayı</h1>
                    <p class="text-gray-600">Sipariş No: <span class="font-mono font-medium">{{ $siparis->siparis_no }}</span></p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                        @if($siparis->durum === 'yeni') bg-blue-100 text-blue-800
                        @elseif($siparis->durum === 'onaylandi') bg-green-100 text-green-800
                        @elseif($siparis->durum === 'hazirlandi') bg-yellow-100 text-yellow-800
                        @elseif($siparis->durum === 'kargolandi') bg-purple-100 text-purple-800
                        @elseif($siparis->durum === 'teslim_edildi') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $siparis->getDurumText() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sol: Sipariş Bilgileri -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Sipariş Ürünleri -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">🛍️ Sipariş Ürünleri</h2>
                    <div class="space-y-4">
                        @foreach($siparis->urunler as $siparisUrunu)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-box text-gray-400 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $siparisUrunu->urun_adi }}</h3>
                                <p class="text-sm text-gray-600">{{ $siparisUrunu->adet }} adet × ₺{{ number_format($siparisUrunu->urun_fiyati, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-900">₺{{ number_format($siparisUrunu->toplam_tutar, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Teslimat Bilgileri -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">📍 Teslimat Bilgileri</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ad Soyad</label>
                            <p class="text-gray-900">{{ $siparis->teslimat_bilgileri['ad_soyad'] ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Telefon</label>
                            <p class="text-gray-900">{{ $siparis->teslimat_bilgileri['telefon'] ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">E-posta</label>
                            <p class="text-gray-900">{{ $siparis->teslimat_bilgileri['email'] ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Şehir</label>
                            <p class="text-gray-900">{{ $siparis->teslimat_bilgileri['sehir'] ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Adres</label>
                            <p class="text-gray-900">{{ $siparis->teslimat_bilgileri['adres'] ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Sipariş Notları -->
                @if($siparis->notlar)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">📝 Sipariş Notları</h2>
                    <p class="text-gray-700">{{ $siparis->notlar }}</p>
                </div>
                @endif
            </div>

            <!-- Sağ: Özet Bilgiler -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">💰 Ödeme Özeti</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Ara Toplam:</span>
                            <span class="font-medium">₺{{ number_format($siparis->toplam_tutar, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Kargo:</span>
                            <span class="font-medium">₺{{ number_format($siparis->kargo_tutari, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">KDV:</span>
                            <span class="font-medium">₺{{ number_format($siparis->vergi_tutari, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Toplam:</span>
                                <span class="text-blue-600">₺{{ number_format($siparis->net_tutar, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ödeme Bilgileri -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="font-bold text-gray-900 mb-3">💳 Ödeme Bilgileri</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ödeme Yöntemi:</span>
                                <span class="font-medium">
                                    @switch($siparis->odeme_yontemi)
                                        @case('kredi_karti')
                                            <i class="fas fa-credit-card mr-1"></i>Kredi Kartı
                                            @break
                                        @case('banka_havalesi')
                                            <i class="fas fa-university mr-1"></i>Banka Havalesi
                                            @break
                                        @case('kapida_odeme')
                                            <i class="fas fa-hand-holding-usd mr-1"></i>Kapıda Ödeme
                                            @break
                                        @default
                                            {{ ucfirst($siparis->odeme_yontemi) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ödeme Durumu:</span>
                                <span class="font-medium 
                                    @if($siparis->odeme_durumu === 'odendi') text-green-600
                                    @elseif($siparis->odeme_durumu === 'bekliyor') text-yellow-600
                                    @else text-red-600 @endif">
                                    {{ $siparis->getOdemeDurumuText() }}
                                </span>
                            </div>
                            @if($siparis->kargo_takip_no)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kargo Takip:</span>
                                <span class="font-mono text-sm">{{ $siparis->kargo_takip_no }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tarih Bilgileri -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="font-bold text-gray-900 mb-3">📅 Tarih Bilgileri</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sipariş Tarihi:</span>
                                <span class="font-medium">{{ $siparis->siparis_tarihi->format('d.m.Y H:i') }}</span>
                            </div>
                            @if($siparis->onay_tarihi)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Onay Tarihi:</span>
                                <span class="font-medium">{{ $siparis->onay_tarihi->format('d.m.Y H:i') }}</span>
                            </div>
                            @endif
                            @if($siparis->kargo_tarihi)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kargo Tarihi:</span>
                                <span class="font-medium">{{ $siparis->kargo_tarihi->format('d.m.Y H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Aksiyon Butonları -->
                    <div class="border-t border-gray-200 pt-6 space-y-3">
                        @if($siparis->canCancel())
                        <form method="POST" action="{{ route('siparis.iptal', $siparis->id) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Siparişi İptal Et
                            </button>
                        </form>
                        @endif
                        
                        <a href="{{ route('anasayfa') }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-center">
                            <i class="fas fa-home mr-2"></i>
                            Ana Sayfaya Dön
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



