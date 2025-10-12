@extends('layouts.app')

@section('title', 'Bayi Seçimi')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Bayi Seçimi
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Yönetmek istediğiniz bayiliği seçin
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('dealer-admin.bayi-ata') }}">
            @csrf
            <div>
                <label for="bayi_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Bayi Seçin
                </label>
                <select name="bayi_id" id="bayi_id" required 
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm">
                    <option value="">Bayi seçin...</option>
                    @foreach($bayiler as $bayi)
                        <option value="{{ $bayi->id }}">
                            {{ $bayi->ad }} 
                            - {{ $bayi->durum ? 'Aktif' : 'Pasif' }}
                        </option>
                    @endforeach
                </select>
                @error('bayi_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Bayiliği Seç
                </button>
            </div>
        </form>

        @if($bayiler->count() === 0)
            <div class="text-center">
                <p class="text-gray-500">Henüz bayi bulunmuyor.</p>
                <p class="text-sm text-gray-400 mt-2">Süper admin ile iletişime geçin.</p>
            </div>
        @endif
    </div>
</div>
@endsection


