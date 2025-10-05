@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 m-0">Ürünler</h1>
        <a href="{{ route('admin.urun.create') }}" class="btn btn-primary">Yeni Ürün</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Görsel</th>
                    <th>Ad</th>
                    <th>Fiyat</th>
                    <th>Stok</th>
                    <th>Barkod</th>
                    <th>Mağazalar</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($urunler as $urun)
                    <tr>
                        <td>{{ $urun->id }}</td>
                        <td>
                            @if($urun->gorsel)
                                <img src="{{ Str::startsWith($urun->gorsel, ['http://','https://']) ? $urun->gorsel : asset('storage/'.$urun->gorsel) }}" alt="{{ $urun->ad }}" style="height:40px;" class="rounded">
                            @endif
                        </td>
                        <td>{{ $urun->ad }}</td>
                        <td>{{ number_format($urun->fiyat, 2) }} ₺</td>
                        <td>{{ $urun->stok }}</td>
                        <td>{{ $urun->barkod }}</td>
                        <td>
                            @php($ms = $urunMagazalari[$urun->id] ?? [])
                            @if(empty($ms))
                                <span class="text-muted">—</span>
                            @else
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($ms as $m)
                                        <span class="badge text-bg-light border">{{ $m['ad'] }}@if(!empty($m['platform'])) <small class="text-muted">({{ $m['platform'] }})</small>@endif</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="text-end d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.urun.edit', $urun) }}" class="btn btn-sm btn-outline-secondary">Düzenle</a>
                            <form action="{{ route('admin.urun.destroy', $urun) }}" method="POST" onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Sil</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Kayıt bulunamadı.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $urunler->links() }}
    </div>
</div>
@endsection
