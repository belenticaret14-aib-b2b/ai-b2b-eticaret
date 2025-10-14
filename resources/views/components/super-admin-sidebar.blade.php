@php
    use App\Models\Kategori;
    $kategoriler = Kategori::with('children')->orderBy('sira')->get();
@endphp

<div class="w-64 bg-gray-900 text-white h-full overflow-y-auto">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-800 border-b border-gray-700">
        <h1 class="text-white text-lg font-semibold">👑 Super Admin</h1>
    </div>
    
    <!-- Navigation -->
    <nav class="mt-4">
        <div class="px-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('super-admin.dashboard') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.dashboard') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                </svg>
                📊 Dashboard
            </a>
            
            <!-- Kullanıcılar -->
            <a href="{{ route('super-admin.kullanicilar') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.kullanicilar') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                </svg>
                👥 Kullanıcılar
            </a>
            
            <!-- Kategoriler (Yeni Eklendi) -->
            <div x-data="{ open: {{ request()->routeIs('super-admin.kategoriler.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path>
                        </svg>
                        📂 Kategoriler
                        <span class="ml-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">{{ $kategoriler->count() }}</span>
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('super-admin.kategoriler.index') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('super-admin.kategoriler.index') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">📋</span>
                        Kategori Listesi
                    </a>
                    <a href="{{ route('super-admin.kategoriler.create') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('super-admin.kategoriler.create') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">➕</span>
                        Yeni Kategori
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">🔄</span>
                        Kategori Sıralama
                    </a>
                </div>
            </div>
            
            <!-- Ürünler -->
            <div x-data="{ open: {{ request()->routeIs('super-admin.urunler.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM10 18V8.5L4 12v5h12v-5l-6-3.5z" clip-rule="evenodd"></path>
                        </svg>
                        📦 Ürünler
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('super-admin.urunler.index') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('super-admin.urunler.index') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">📋</span>
                        Ürün Listesi
                    </a>
                    <a href="{{ route('super-admin.urunler.create') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('super-admin.urunler.create') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">➕</span>
                        Yeni Ürün
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">📊</span>
                        Toplu İşlemler
                    </a>
                </div>
            </div>
            
            <!-- Mağazalar -->
            <a href="{{ route('super-admin.magazalar') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.magazalar') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                🏪 Mağazalar
            </a>
            
            <!-- Bayiler -->
            <a href="{{ route('super-admin.bayiler') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.bayiler') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                </svg>
                🤝 Bayiler
            </a>
            
            <!-- Modül Yönetimi -->
            <div x-data="{ open: {{ request()->routeIs('super-admin.modules.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        🔧 Modül Yönetimi
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('super-admin.modules.index') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('super-admin.modules.index') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">📋</span>
                        Modül Listesi
                    </a>
                    <a href="{{ route('super-admin.modules.create') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('super-admin.modules.create') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">➕</span>
                        Yeni Modül
                    </a>
                    <a href="{{ route('super-admin.modules.stats') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">📊</span>
                        Modül İstatistikleri
                    </a>
                </div>
            </div>
            
            <!-- Tema Yönetimi -->
            <div x-data="{ open: {{ request()->routeIs('super-admin.theme.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"></path>
                        </svg>
                        🎨 Tema Yönetimi
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('super-admin.theme') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('super-admin.theme') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">🎨</span>
                        Tema Seçimi
                    </a>
                    <a href="{{ route('super-admin.theme.settings') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">⚙️</span>
                        Tema Ayarları
                    </a>
                </div>
            </div>
            
            <!-- Sistem Ayarları -->
            <a href="{{ route('super-admin.sistem-ayarlari') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.sistem-ayarlari') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                </svg>
                ⚙️ Sistem Ayarları
            </a>
            
            <!-- Raporlar -->
            <a href="{{ route('super-admin.raporlar') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.raporlar') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                📊 Raporlar
            </a>
            
            <!-- AI & Bot Araçları -->
            <div class="pt-4 border-t border-gray-700">
                <h4 class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">🤖 AI & Bot Araçları</h4>
                
                <div x-data="{ open: {{ request()->routeIs('super-admin.claude.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" 
                            class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            🧠 Claude AI
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                        <a href="{{ route('super-admin.claude') }}" 
                           class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                            <span class="mr-2">💬</span>
                            AI Chat
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                            <span class="mr-2">📝</span>
                            Ürün Açıklaması
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                            <span class="mr-2">🔍</span>
                            SEO Meta
                        </a>
                    </div>
                </div>
                
                <a href="{{ route('super-admin.bot-ayarlari') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.bot-ayarlari') ? 'bg-blue-600 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    🤖 Bot Ayarları
                </a>
            </div>
            
            <!-- Geliştirici -->
            <a href="{{ route('super-admin.gelistirici') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.gelistirici') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                💻 Geliştirici
            </a>
            
            <!-- Proje Detayları -->
            <a href="{{ route('super-admin.proje-detaylari') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('super-admin.proje-detaylari') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path>
                </svg>
                📋 Proje Detayları
            </a>
        </div>
    </nav>
</div>
