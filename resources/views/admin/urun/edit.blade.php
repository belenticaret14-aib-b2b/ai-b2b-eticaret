@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Ürün Düzenle</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.urun.update', $urun) }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">Ad</label>
            <input type="text" name="ad" value="{{ old('ad', $urun->ad) }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Fiyat</label>
            <input type="number" step="0.01" name="fiyat" value="{{ old('fiyat', $urun->fiyat) }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $urun->stok) }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Barkod</label>
            <input type="text" name="barkod" value="{{ old('barkod', $urun->barkod) }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Görsel URL</label>
            <input type="url" name="gorsel" value="{{ old('gorsel', $urun->gorsel) }}" class="form-control" placeholder="https://...">
        </div>
        <div class="col-md-6">
            <label class="form-label">Görsel Dosya</label>
            <input type="file" name="gorsel_dosya" class="form-control" accept="image/*">
        </div>
        @if($urun->gorsel)
        <div class="col-12">
            <label class="form-label d-block">Mevcut Görsel</label>
            <img src="{{ Str::startsWith($urun->gorsel, ['http://','https://']) ? $urun->gorsel : asset('storage/'.$urun->gorsel) }}" alt="{{ $urun->ad }}" class="img-thumbnail" style="max-height:150px;">
        </div>
        @endif
        <div class="col-12">
            <label class="form-label">Açıklama</label>
            <textarea name="aciklama" rows="4" class="form-control">{{ old('aciklama', $urun->aciklama) }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Satılacağı Mağazalar</label>
            <div class="row g-2">
                @php($magazalar = \App\Models\Magaza::orderBy('ad')->get())
                @php($secili = old('magazalar', isset($urun) ? \Illuminate\Support\Facades\DB::table('magaza_urun')->where('urun_id',$urun->id)->pluck('magaza_id')->toArray() : []))
                @forelse($magazalar as $magaza)
                    <div class="col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="magazalar[]" id="magaza_{{ $magaza->id }}" value="{{ $magaza->id }}" {{ in_array($magaza->id, $secili) ? 'checked' : '' }}>
                            <label class="form-check-label" for="magaza_{{ $magaza->id }}">
                                {{ $magaza->ad }} @if($magaza->platform) <small class="text-muted">({{ $magaza->platform }})</small>@endif
                            </label>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-warning mb-0">Kayıtlı mağaza yok. Önce mağaza ekleyin.</div></div>
                @endforelse
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="{{ route('admin.urun.index') }}" class="btn btn-secondary">Geri</a>
        </div>
    </form>
</div>
@endsection
