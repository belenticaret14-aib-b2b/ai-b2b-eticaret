@extends('layouts.app')

@section('title', 'Mağaza Seçimi')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-blue-100">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Mağaza Seçimi
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Yönetmek istediğiniz mağazayı seçin
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('store-admin.magaza-ata') }}">
            @csrf
            <div>
                <label for="magaza_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Mağaza Seçin
                </label>
                <select name="magaza_id" id="magaza_id" required 
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm">
                    <option value="">Mağaza seçin...</option>
                    @foreach($magazalar as $magaza)
                        <option value="{{ $magaza->id }}">
                            {{ $magaza->ad }} 
                            @if($magaza->platform)
                                ({{ ucfirst($magaza->platform) }})
                            @endif
                            @if($magaza->ana_magaza)
                                - 🏢 Ana Mağaza
                            @endif
                            - {{ $magaza->durum ? 'Aktif' : 'Pasif' }}
                        </option>
                    @endforeach
                </select>
                @error('magaza_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Mağazayı Seç
                </button>
            </div>
        </form>

        @if($magazalar->count() === 0)
            <div class="text-center">
                <p class="text-gray-500">Henüz mağaza bulunmuyor.</p>
                <p class="text-sm text-gray-400 mt-2">Süper admin ile iletişime geçin.</p>
            </div>
        @endif
    </div>
</div>
@endsection
