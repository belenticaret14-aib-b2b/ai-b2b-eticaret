@extends('layouts.app')

@section('title', 'Ödeme')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Ödeme</h1>

    @php
        $sepet = session('sepet', ['items' => [], 'total' => 0, 'adet_toplami' => 0]);
        $items = $sepet['items'] ?? [];
    @endphp

    @if(empty($items))
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-600">Sepetiniz boş. Ödeme sayfasına geçebilmek için sepete ürün ekleyin.</p>
            <a href="{{ route('vitrin.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">Alışverişe Dön</a>
        </div>
    @else
        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-lg font-semibold mb-4">Teslimat Bilgileri</h2>
                    <form method="POST" action="#">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ad Soyad</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" placeholder="Ad Soyad">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefon</label>
                                <input type="text" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" placeholder="Telefon">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Adres</label>
                                <textarea class="mt-1 block w-full border border-gray-300 rounded px-3 py-2" rows="3" placeholder="Adres"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Siparişi Tamamla</button>
                    </form>
                </div>
            </div>
            <div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-lg font-semibold mb-4">Sipariş Özeti</h2>
                    <div class="flex justify-between text-gray-700">
                        <span>Ara Toplam</span>
                        <span>{{ number_format($sepet['total'] ?? 0, 2) }} ₺</span>
                    </div>
                    <div class="flex justify-between text-gray-700 mt-2">
                        <span>Ürün Adedi</span>
                        <span>{{ $sepet['adet_toplami'] ?? 0 }}</span>
                    </div>
                    <a href="{{ route('vitrin.sepet') }}" class="block mt-6 text-blue-600 hover:underline">Sepete Dön</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
