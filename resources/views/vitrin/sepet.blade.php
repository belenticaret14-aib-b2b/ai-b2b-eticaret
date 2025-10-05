@extends('layouts.app')

@section('title', 'Sepetim')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Sepetim</h1>

    @php
        $sepet = session('sepet', ['items' => [], 'total' => 0, 'adet_toplami' => 0]);
        $items = $sepet['items'] ?? [];
    @endphp

    @if(empty($items))
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-600">Sepetiniz boş.</p>
            <a href="{{ route('vitrin.index') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">Alışverişe Başla</a>
        </div>
    @else
        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-4">
                @foreach($items as $item)
                    <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item['gorsel'] ?? 'https://via.placeholder.com/80' }}" alt="{{ $item['ad'] ?? '' }}" class="w-20 h-20 object-cover rounded">
                            <div>
                                <h3 class="font-semibold">{{ $item['ad'] ?? 'Ürün' }}</h3>
                                <p class="text-gray-500 text-sm">SKU: {{ $item['sku'] ?? '-' }}</p>
                                <p class="text-gray-700 mt-1">Fiyat: <span class="font-semibold">{{ number_format($item['fiyat'] ?? 0, 2) }} ₺</span></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-600">Adet: <span class="font-semibold">{{ $item['adet'] ?? 1 }}</span></p>
                            <p class="text-gray-800 mt-2">Toplam: <span class="font-bold">{{ number_format(($item['fiyat'] ?? 0) * ($item['adet'] ?? 1), 2) }} ₺</span></p>
                        </div>
                    </div>
                @endforeach
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
                    <a href="{{ route('vitrin.odeme') }}" class="block mt-6 bg-green-600 text-white text-center py-2 rounded hover:bg-green-700">Ödemeye Geç</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
