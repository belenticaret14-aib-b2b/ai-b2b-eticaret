@extends('layouts.app')

@section('content')
<div class="py-4">
    <h1 class="h4 mb-3">Sepet</h1>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @php
        $items = $sepet['items'] ?? [];
        $total = $sepet['total'] ?? 0;
    @endphp

    @if (empty($items))
        <div class="alert alert-info">Sepetiniz boş.</div>
        <a href="{{ route('vitrin.index') }}" class="btn btn-primary">Alışverişe Devam Et</a>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Ürün</th>
                        <th>Ad</th>
                        <th>Fiyat</th>
                        <th>Adet</th>
                        <th>Tutar</th>
                        <th class="text-end">İşlem</th>
                    </tr>
                </thead>
                <tbody>
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