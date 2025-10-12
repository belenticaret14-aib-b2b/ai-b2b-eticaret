@extends('layouts.app')

@section('title', $sayfa->baslik)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $sayfa->baslik }}</h1>
            <div class="prose max-w-none">
                {!! $sayfa->icerik !!}
            </div>
        </div>
    </div>
</div>
@endsection