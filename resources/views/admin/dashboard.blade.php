@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Admin Dashboard</h4>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-primary rounded-circle">
                                <i class="mdi mdi-account-multiple text-white font-size-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Toplam Kullanıcı</p>
                            <h5 class="mb-0">{{ $stats['toplam_kullanici'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-success rounded-circle">
                                <i class="mdi mdi-store text-white font-size-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Toplam Bayi</p>
                            <h5 class="mb-0">{{ $stats['toplam_bayi'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-info rounded-circle">
                                <i class="mdi mdi-package-variant text-white font-size-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Toplam Ürün</p>
                            <h5 class="mb-0">{{ $stats['toplam_urun'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm bg-warning rounded-circle">
                                <i class="mdi mdi-cart text-white font-size-18"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="text-muted mb-1">Toplam Sipariş</p>
                            <h5 class="mb-0">{{ $stats['toplam_siparis'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detaylı İstatistikler -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sistem Durumu</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-success">{{ $stats['aktif_bayiler'] }}</h5>
                                <p class="text-muted mb-0">Aktif Bayi</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h5 class="text-warning">{{ $stats['bekleyen_siparisler'] }}</h5>
                                <p class="text-muted mb-0">Bekleyen Sipariş</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Son Siparişler</h4>
                </div>
                <div class="card-body">
                    @if($stats['son_siparisler']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Sipariş No</th>
                                        <th>Müşteri</th>
                                        <th>Durum</th>
                                        <th>Tarih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['son_siparisler'] as $siparis)
                                    <tr>
                                        <td>#{{ $siparis->id }}</td>
                                        <td>{{ $siparis->kullanici->ad ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $siparis->durum == 'tamamlandi' ? 'success' : 'warning' }}">
                                                {{ ucfirst($siparis->durum) }}
                                            </span>
                                        </td>
                                        <td>{{ $siparis->created_at->format('d.m.Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Henüz sipariş bulunmuyor.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hızlı Aksiyonlar -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Hızlı Aksiyonlar</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.urun.index') }}" class="btn btn-primary w-100">
                                <i class="mdi mdi-plus"></i> Yeni Ürün
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.magaza.index') }}" class="btn btn-success w-100">
                                <i class="mdi mdi-store"></i> Bayi Yönetimi
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.kategoriler.index') }}" class="btn btn-info w-100">
                                <i class="mdi mdi-folder"></i> Kategori Yönetimi
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.site-ayarlari') }}" class="btn btn-warning w-100">
                                <i class="mdi mdi-cog"></i> Site Ayarları
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection