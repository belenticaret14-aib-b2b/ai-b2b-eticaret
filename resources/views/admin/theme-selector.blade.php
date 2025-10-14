@extends('layouts.app')

@section('title', 'Tema Yönetimi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">🎨 Tema Yönetimi</h1>
                    <p class="mt-2 text-gray-600">Platformunuzun görünümünü değiştirin</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('super-admin.dashboard') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        ← Süper Admin Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Mevcut Tema Bilgisi -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">📍 Aktif Tema</h2>
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-palette text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $themeData[$currentTheme]['name'] ?? 'Bilinmeyen Tema' }}</h3>
                    <p class="text-gray-600">{{ $themeData[$currentTheme]['info']['description'] ?? 'Tema açıklaması' }}</p>
                </div>
                <div class="ml-auto">
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Tema Listesi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($themeData as $themeKey => $theme)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 {{ $themeKey === $currentTheme ? 'ring-2 ring-blue-500' : '' }}">
                    <!-- Tema Önizleme -->
                    <div class="relative">
                        <img src="{{ $theme['preview'] }}" 
                             alt="{{ $theme['name'] }}" 
                             class="w-full h-48 object-cover">
                        
                        @if($themeKey === $currentTheme)
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                <i class="fas fa-check mr-1"></i>Aktif
                            </div>
                        @endif
                    </div>

                    <!-- Tema Bilgileri -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $theme['name'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $theme['info']['description'] ?? 'Tema açıklaması' }}</p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-code mr-1"></i>v{{ $theme['info']['version'] ?? '1.0.0' }}</span>
                            <span><i class="fas fa-user mr-1"></i>{{ $theme['info']['author'] ?? 'NetMarketiniz' }}</span>
                        </div>

                        <!-- Aksiyon Butonları -->
                        <div class="flex space-x-2">
                            @if($themeKey !== $currentTheme)
                                <button onclick="switchTheme('{{ $themeKey }}')" 
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                                    <i class="fas fa-check mr-2"></i>Seç
                                </button>
                            @else
                                <button disabled 
                                        class="flex-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-semibold cursor-not-allowed">
                                    <i class="fas fa-check mr-2"></i>Seçili
                                </button>
                            @endif
                            
                            <a href="{{ route('theme.preview', $themeKey) }}" 
                               target="_blank"
                               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-300">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tema Ayarları -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">⚙️ Tema Ayarları</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('super-admin.theme.settings') }}" 
                   class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <i class="fas fa-cogs text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Tema Ayarları</h3>
                        <p class="text-gray-600 text-sm">Özel CSS ve tema konfigürasyonu</p>
                    </div>
                </a>
                
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <i class="fas fa-info-circle text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Tema Sistemi</h3>
                        <p class="text-gray-600 text-sm">Yapıyı bozmadan tasarım değişiklikleri</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function switchTheme(theme) {
    if (confirm('Temayı değiştirmek istediğinizden emin misiniz?')) {
        // Loading göster
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Değiştiriliyor...';
        button.disabled = true;

        // AJAX isteği
        fetch('{{ route("super-admin.theme.switch") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ theme: theme })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Başarılı mesajı göster
                showNotification(data.message, 'success');
                
                // Sayfayı yenile
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message, 'error');
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Tema değiştirme sırasında bir hata oluştu.', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
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
