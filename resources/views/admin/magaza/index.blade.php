@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 m-0">Mağazalar</h1>
        <a href="{{ route('admin.magaza.create') }}" class="btn btn-primary">Yeni Mağaza</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ad</th>
                    <th>Platform</th>
                    <th>API Anahtarı</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($magazalar as $m)
                    <tr>
                        <td>{{ $m->id }}</td>
                        <td>{{ $m->ad }}</td>
                        <td>{{ $m->platform ?? '—' }}</td>
                        <td><code>{{ $m->api_anahtari ? Str::limit($m->api_anahtari, 20) : '—' }}</code></td>
                        <td class="text-end">
                            <a href="{{ route('admin.magaza.edit', $m) }}" class="btn btn-sm btn-outline-secondary">Düzenle</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Kayıt bulunamadı.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $magazalar->links() }}
    </div>
</div>
@endsection
