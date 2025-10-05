@extends('layouts.app')

@section('content')
<div class="row align-items-center py-5">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold">AI Destekli B2B E-Ticaret Platformu</h1>
        <p class="lead">Bayi, mağaza ve admin yönetimi ile ürünlerinizi kolayca yönetin. Hepsiburada, Trendyol entegrasyonu ve AI ile akıllı öneriler burada!</p>
        <a href="/b2b-login" class="btn btn-primary btn-lg me-2">B2B Giriş</a>
        <a href="/admin/panel" class="btn btn-outline-success btn-lg">Admin Paneli</a>
    </div>
    <div class="col-md-6 text-center">
        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded shadow" alt="AI B2B E-Ticaret">
    </div>
</div>
@endsection
