@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Mağaza Ekle</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.magaza.store') }}" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Mağaza Adı</label>
            <input type="text" name="ad" value="{{ old('ad') }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Platform</label>
            <input type="text" name="platform" value="{{ old('platform') }}" class="form-control" placeholder="Trendyol, Hepsiburada, N11...">
        </div>
        <div class="col-12">
            <label class="form-label">API Anahtarı</label>
            <input type="text" name="api_anahtari" value="{{ old('api_anahtari') }}" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Kaydet</button>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Vazgeç</a>
        </div>
    </form>
</div>
@endsection
