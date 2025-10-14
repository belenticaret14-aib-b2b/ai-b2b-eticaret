@extends('layouts.app')

@section('title', 'Modül Yönetimi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">🔧 Modül Yönetimi</h1>
                    <p class="mt-2 text-gray-600">Sistem modüllerini yönetin ve bayilere özel yetkilendirmeler yapın</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('super-admin.dashboard') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        ← Dashboard
                    </a>
                    <a href="{{ route('super-admin.modules.create') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        + Yeni Modül
                    </a>
                </div>
            </div>
        </div>

        <!-- İstatistikler -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Toplam Modül</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-puzzle-piece text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Aktif Modüller</p>
                        <p class="text-2xl font-bold text-green-600">{{ $stats['active'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pasif Modüller</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['inactive'] ?? 0 }}</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Kullanım Oranı</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['usage_percentage'] ?? 0 }}%</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-chart-pie text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modül Listesi -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($modules as $key => $module)
                <div class="bg-white rounded-lg shadow-md overflow-hidden {{ $module['active'] ? 'ring-2 ring-green-500' : 'ring-2 ring-gray-200' }}">
                    <!-- Modül Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-{{ $module['color'] ?? 'blue' }}-100 p-3 rounded-full">
                                    <i class="{{ $module['icon'] ?? 'fas fa-puzzle-piece' }} text-{{ $module['color'] ?? 'blue' }}-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $module['name'] }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $module['description'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if($module['active'])
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-check mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                                        <i class="fas fa-times mr-1"></i>Pasif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modül İçerik -->
                    <div class="p-6">
                        <!-- Yetkilendirmeler -->
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Yetkilendirmeler:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($module['permissions'] as $permission)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                        @switch($permission)
                                            @case('super_admin')
                                                👑 Süper Admin
                                                @break
                                            @case('admin')
                                                ⚙️ Admin
                                                @break
                                            @case('bayi')
                                                🤝 Bayi
                                                @break
                                            @case('musteri')
                                                👤 Müşteri
                                                @break
                                        @endswitch
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Route'lar -->
                        @if(isset($module['routes']) && count($module['routes']) > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Route'lar ({{ count($module['routes']) }}):</h4>
                                <div class="space-y-1">
                                    @foreach(array_slice($module['routes'], 0, 3) as $route => $name)
                                        <div class="text-sm text-gray-600">
                                            <code class="bg-gray-100 px-2 py-1 rounded">{{ $route }}</code>
                                            <span class="ml-2">{{ $name }}</span>
                                        </div>
                                    @endforeach
                                    @if(count($module['routes']) > 3)
                                        <div class="text-sm text-gray-500">
                                            +{{ count($module['routes']) - 3 }} daha...
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Aksiyonlar -->
                        <div class="flex space-x-2 pt-4 border-t border-gray-200">
                            <button onclick="toggleModule('{{ $key }}', {{ $module['active'] ? 'false' : 'true' }})"
                                    class="flex-1 {{ $module['active'] ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                                <i class="fas {{ $module['active'] ? 'fa-times' : 'fa-check' }} mr-2"></i>
                                {{ $module['active'] ? 'Pasif Et' : 'Aktif Et' }}
                            </button>
                            
                            <a href="{{ route('super-admin.modules.show', $key) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                                <i class="fas fa-cog mr-2"></i>Ayarlar
                            </a>
                            
                            @if($key !== 'core')
                                <button onclick="deleteModule('{{ $key }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Yedekleme/Geri Yükleme -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">💾 Yedekleme & Geri Yükleme</h2>
            <div class="flex space-x-4">
                <a href="{{ route('super-admin.modules.backup') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-download mr-2"></i>Yedekle
                </a>
                
                <form action="{{ route('super-admin.modules.restore') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                    @csrf
                    <input type="file" name="backup_file" accept=".json" class="border border-gray-300 rounded px-3 py-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-upload mr-2"></i>Geri Yükle
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function toggleModule(moduleKey, active) {
    if (confirm(`Modülü ${active ? 'aktif' : 'pasif'} etmek istediğinizden emin misiniz?`)) {
        fetch(`/super-admin/modules/${moduleKey}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ active: active })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Modül durumu değiştirilirken bir hata oluştu.', 'error');
        });
    }
}

function deleteModule(moduleKey) {
    if (confirm(`"${moduleKey}" modülünü silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.`)) {
        fetch(`/super-admin/modules/${moduleKey}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Modül silinirken bir hata oluştu.', 'error');
        });
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection

