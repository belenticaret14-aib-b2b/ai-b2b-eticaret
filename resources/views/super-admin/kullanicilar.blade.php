@extends('layouts.app')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">👥 Kullanıcı Yönetimi</h1>
                    <p class="mt-2 text-gray-600">Sistem kullanıcılarını yönetin</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('super-admin.panel') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        ← Geri Dön
                    </a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        + Yeni Kullanıcı
                    </button>
                </div>
            </div>
        </div>

        <!-- Kullanıcı Listesi -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kullanıcı</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kayıt Tarihi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(\App\Models\Kullanici::with(['magaza', 'bayi'])->get() as $kullanici)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">{{ substr($kullanici->ad, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $kullanici->ad }}</div>
                                            <div class="text-sm text-gray-500">{{ $kullanici->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $kullanici->rol === 'super_admin' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $kullanici->rol === 'store_admin' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $kullanici->rol === 'dealer_admin' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $kullanici->rol === 'admin' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $kullanici->rol === 'bayi' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $kullanici->rol === 'musteri' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $kullanici->rol)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $kullanici->durum ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $kullanici->durum ? 'Aktif' : 'Pasif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $kullanici->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900">Düzenle</button>
                                        <button class="text-red-600 hover:text-red-900">Sil</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


