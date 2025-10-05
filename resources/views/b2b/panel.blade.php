@extends('layouts.app')

@section('title', 'B2B Panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">B2B Panel</h1>
        <div class="text-sm text-gray-600">Hoş geldiniz, {{ auth()->user()->ad ?? 'Bayi' }}</div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <a href="{{ route('vitrin.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold mb-2">Ürün Kataloğu</h2>
            <p class="text-gray-600 text-sm">Tüm ürünleri görüntüleyin ve bayiye özel fiyatlarınızı görün.</p>
        </a>

        <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold mb-2">Toplu Sipariş</h2>
            <p class="text-gray-600 text-sm">CSV/Excel ile toplu sipariş verin. (Yakında)</p>
        </a>

        <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold mb-2">Cari Hesap</h2>
            <p class="text-gray-600 text-sm">Bakiye, vade ve limitlerinizi görüntüleyin. (Yakında)</p>
        </a>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Duyurular</h3>
        <ul class="list-disc list-inside text-gray-700 text-sm">
            <li>Bayi paneli ilk sürüm. Geri bildirimlerinizi bekliyoruz.</li>
        </ul>
    </div>
</div>
@endsection
