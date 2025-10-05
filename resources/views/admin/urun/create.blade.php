@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Yeni Ürün</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.urun.store') }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Ad</label>
            <input type="text" name="ad" value="{{ old('ad') }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Fiyat</label>
            <input type="number" step="0.01" name="fiyat" value="{{ old('fiyat') }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" value="{{ old('stok') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Barkod</label>
            <input type="text" name="barkod" value="{{ old('barkod') }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Görsel URL</label>
            <input type="url" name="gorsel" value="{{ old('gorsel') }}" class="form-control" placeholder="https://...">
        </div>
        <div class="col-md-6">
            <label class="form-label">Görsel Dosya</label>
            <input type="file" name="gorsel_dosya" class="form-control" accept="image/*">
        </div>
        <div class="col-12">
            <label class="form-label">Açıklama</label>
            <textarea name="aciklama" rows="4" class="form-control">{{ old('aciklama') }}</textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Satılacağı Mağazalar</label>
            <div class="row g-2">
                @php($magazalar = \App\Models\Magaza::orderBy('ad')->get())
                @forelse($magazalar as $magaza)
                    <div class="col-sm-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="magazalar[]" id="magaza_{{ $magaza->id }}" value="{{ $magaza->id }}" {{ in_array($magaza->id, old('magazalar', [])) ? 'checked' : '' }}>
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
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="{{ route('admin.urun.index') }}" class="btn btn-secondary">Vazgeç</a>
        </div>
    </form>
</div>
@endsection
