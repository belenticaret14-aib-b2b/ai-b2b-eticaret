@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">B2B Bayi Girişi</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('b2b.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
