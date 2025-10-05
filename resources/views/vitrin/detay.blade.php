@extends('layouts.app')

@section('content')
<div class="row py-4">
    <div class="col-md-6 mb-3">
    <img src="{{ $urun->gorsel ? (Str::startsWith($urun->gorsel, ['http://','https://']) ? $urun->gorsel : asset('storage/'.$urun->gorsel)) : 'https://placehold.co/800x600?text=Urun' }}" class="img-fluid rounded" alt="{{ $urun->ad }}">
    </div>
    <div class="col-md-6">
        <h1 class="h4">{{ $urun->ad }}</h1>
        <p class="lead">{{ number_format($urun->fiyat, 2) }} ₺</p>
        <p class="text-muted">Stok: {{ $urun->stok ?? '-' }}</p>
        @if(isset($magazalar) && $magazalar->count())
            <div class="mb-2">
                <div class="text-muted small mb-1">Satıldığı Mağazalar</div>
                <div class="d-flex flex-wrap gap-1">
                    @foreach($magazalar as $m)
                        <span class="badge text-bg-light border">{{ $m->ad }}@if(!empty($m->platform)) <small class="text-muted">({{ $m->platform }})</small>@endif</span>
                    @endforeach
                </div>
            </div>
        @endif
        @if($urun->aciklama)
            <div class="mb-3">{!! nl2br(e($urun->aciklama)) !!}</div>
        @endif
        <form action="{{ route('sepet.ekle') }}" method="POST" class="d-flex gap-2">
            @csrf
            <input type="hidden" name="urun_id" value="{{ $urun->id }}">
            <input type="number" name="adet" value="1" min="1" class="form-control" style="max-width:120px;">
            <button class="btn btn-success" type="submit">Sepete Ekle</button>
        </form>
    </div>
</div>
@endsection
