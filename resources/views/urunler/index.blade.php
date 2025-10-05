@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ürünler</h1>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach($urunler as $urun)
            <div style="border: 1px solid #ccc; padding: 15px; width: 200px;">
                <h3>{{ $urun->ad }}</h3>
                <p>{{ $urun->aciklama }}</p>
                <p><strong>{{ $urun->fiyat }} TL</strong></p>
                <a href="{{ route('urunler.sepeteEkle', $urun->id) }}">Sepete Ekle</a>
            </div>
        @endforeach
    </div>
</div>
@endsection
