@extends('layouts.app')

@section('title', 'Sepet - ' . config('app.name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🛒 Sepetim</h1>
            <p class="text-gray-600">Sepetinizdeki ürünleri kontrol edin ve ödemeye geçin</p>
        </div>

    @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('status') }}
            </div>
    @endif

    @php
        $items = $sepet['items'] ?? [];
        $total = $sepet['total'] ?? 0;
    @endphp

    @if (empty($items))
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <div class="text-6xl text-gray-300 mb-4">🛒</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Sepetiniz Boş</h2>
                <p class="text-gray-600 mb-8">Henüz sepetinize ürün eklemediniz</p>
                <a href="{{ route('anasayfa') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-colors inline-flex items-center">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Alışverişe Devam Et
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sol: Sepet Ürünleri -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900">Sepetinizdeki Ürünler</h2>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($items as $item)
                            <div class="p-6" x-data="{ adet: {{ $item['adet'] }} }">
                                <div class="flex items-center space-x-4">
                                    <!-- Ürün Resmi -->
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        @if($item['gorsel'])
                                            <img src="{{ asset('storage/' . $item['gorsel']) }}" alt="{{ $item['ad'] }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <i class="fas fa-box text-gray-400 text-2xl"></i>
                                        @endif
                                    </div>
                                    
                                    <!-- Ürün Bilgileri -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $item['ad'] }}</h3>
                                        <p class="text-sm text-gray-600">₺{{ number_format($item['fiyat'], 2) }} / adet</p>
                                    </div>
                                    
                                    <!-- Adet Kontrolü -->
                                    <div class="flex items-center space-x-2">
                                        <button type="button" 
                                                @click="adet = Math.max(1, adet - 1); $dispatch('sepet-guncelle', { urun_id: {{ $item['id'] }}, adet: adet })"
                                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                        <span class="w-12 text-center font-medium" x-text="adet"></span>
                                        <button type="button" 
                                                @click="adet = adet + 1; $dispatch('sepet-guncelle', { urun_id: {{ $item['id'] }}, adet: adet })"
                                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Tutar -->
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">₺{{ number_format($item['fiyat'] * $item['adet'], 2) }}</p>
                                    </div>
                                    
                                    <!-- Sil Butonu -->
                                    <form method="POST" action="{{ route('sepet.sil') }}" class="ml-4">
                                        @csrf
                                        <input type="hidden" name="urun_id" value="{{ $item['id'] }}">
                                        <button type="submit" 
                                                class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sağ: Özet ve Ödeme -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Sipariş Özeti</h2>
                        
                        <!-- Tutarlar -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ara Toplam:</span>
                                <span class="font-medium">₺{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Kargo:</span>
                                <span class="font-medium">
                                    @if($total >= 500)
                                        <span class="text-green-600">Ücretsiz</span>
                                    @elseif($total >= 200)
                                        ₺15
    @else
                                        ₺25
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">KDV (%18):</span>
                                <span class="font-medium">₺{{ number_format($total * 0.18, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Toplam:</span>
                                    <span class="text-blue-600">
                                        @php
                                            $kargo = $total >= 500 ? 0 : ($total >= 200 ? 15 : 25);
                                            $vergi = $total * 0.18;
                                            $toplam = $total + $kargo + $vergi;
                                        @endphp
                                        ₺{{ number_format($toplam, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Ödeme Butonu -->
                        <a href="{{ route('odeme.index') }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition-colors flex items-center justify-center mb-4">
                            <i class="fas fa-credit-card mr-3"></i>
                            Ödemeye Geç
                        </a>
                        
                        <!-- Sepeti Boşalt -->
                        <form method="POST" action="{{ route('sepet.bosalt') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Sepeti Boşalt
                            </button>
                        </form>
                        
                        <p class="text-xs text-gray-500 text-center mt-4">
                            💳 Güvenli ödeme sistemi
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
// Sepet güncelleme event listener
document.addEventListener('sepet-guncelle', function(e) {
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    formData.append('urun_id', e.detail.urun_id);
    formData.append('adet', e.detail.adet);
    
    fetch('{{ route("sepet.guncelle") }}', {
        method: 'POST',
        body: formData
    }).then(() => {
        location.reload();
    });
});
</script>
@endsection
                    @foreach ($items as $it)
                        <tr>
                            <td style="width:90px;">
                                @php
                                    $img = $it['gorsel'] ?? null;
                                    $src = $img ? (Str::startsWith($img, ['http://','https://']) ? $img : asset('storage/'.$img)) : 'https://placehold.co/80x60?text=Urun';
                                @endphp
                                <img src="{{ $src }}" class="img-thumbnail" alt="{{ $it['ad'] }}" style="max-width:80px;">
                            </td>
                            <td>{{ $it['ad'] }}</td>
                            <td>{{ number_format($it['fiyat'], 2) }} ₺</td>
                            <td style="width:160px;">
                                <form action="{{ route('sepet.guncelle') }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="hidden" name="urun_id" value="{{ $it['id'] }}">
                                    <input type="number" class="form-control" name="adet" min="1" value="{{ $it['adet'] }}" style="max-width:100px;">
                                    <button class="btn btn-sm btn-outline-primary" type="submit">Güncelle</button>
                                </form>
                            </td>
                            <td><strong>{{ number_format($it['fiyat'] * $it['adet'], 2) }} ₺</strong></td>
                            <td class="text-end">
                                <form action="{{ route('sepet.sil') }}" method="POST" onsubmit="return confirm('Ürünü kaldırmak istiyor musunuz?');">
                                    @csrf
                                    <input type="hidden" name="urun_id" value="{{ $it['id'] }}">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Kaldır</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Toplam:</strong></td>
                        <td colspan="2"><strong>{{ number_format($total, 2) }} ₺</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('vitrin.index') }}" class="btn btn-outline-secondary">Alışverişe Devam Et</a>
            <div class="d-flex gap-2">
                <form action="{{ route('sepet.bosalt') }}" method="POST" onsubmit="return confirm('Sepeti boşaltmak istiyor musunuz?');">
                    @csrf
                    <button class="btn btn-outline-danger" type="submit">Sepeti Boşalt</button>
                </form>
                <button class="btn btn-success" type="button" disabled>Siparişe Devam Et (yakında)</button>
            </div>
        </div>
    @endif
</div>
@endsection