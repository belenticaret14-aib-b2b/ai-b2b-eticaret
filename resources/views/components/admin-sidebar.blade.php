@php
    use App\Models\Kategori;
    $kategoriler = Kategori::with('children')->orderBy('sira')->get();
@endphp

<div class="w-64 bg-gray-900 text-white h-full overflow-y-auto">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-800 border-b border-gray-700">
        <h1 class="text-white text-lg font-semibold">⚙️ Admin Panel</h1>
    </div>
    
    <!-- Navigation -->
    <nav class="mt-4">
        <div class="px-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.panel') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('admin.panel') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                </svg>
                📊 Dashboard
            </a>
            
            <!-- Kategoriler (Yeni Eklendi) -->
            <div x-data="{ open: {{ request()->routeIs('admin.kategori.*') ? 'true' : 'false' }} }">
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
                    <!-- Kategori Yönetimi -->
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">➕</span>
                        Yeni Kategori Ekle
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">📋</span>
                        Kategori Listesi
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">🔄</span>
                        Kategori Sıralama
                    </a>
                </div>
            </div>
            
            <!-- Ürünler -->
            <div x-data="{ open: {{ request()->routeIs('admin.urun.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM8 15v-4h4v4H8z" clip-rule="evenodd"></path>
                        </svg>
                        📦 Ürünler
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.urun.index') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('admin.urun.index') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">📋</span>
                        Ürün Listesi
                    </a>
                    <a href="{{ route('admin.urun.create') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('admin.urun.create') ? 'bg-gray-700 text-white' : '' }}">
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
            <div x-data="{ open: {{ request()->routeIs('admin.magaza.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        🏪 Mağazalar
                    </div>
                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-90': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                    <a href="{{ route('admin.magaza.index') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('admin.magaza.index') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">📋</span>
                        Mağaza Listesi
                    </a>
                    <a href="{{ route('admin.magaza.create') }}" 
                       class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition {{ request()->routeIs('admin.magaza.create') ? 'bg-gray-700 text-white' : '' }}">
                        <span class="mr-2">➕</span>
                        Yeni Mağaza
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition">
                        <span class="mr-2">🔄</span>
                        Entegrasyonlar
                    </a>
                </div>
            </div>
            
            <!-- Site Ayarları -->
            <a href="{{ route('admin.site-ayarlari') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('admin.site-ayarlari') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                </svg>
                ⚙️ Site Ayarları
            </a>
            
            <!-- Sayfalar -->
            <a href="{{ route('admin.sayfalar') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition {{ request()->routeIs('admin.sayfalar*') ? 'bg-blue-600 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                </svg>
                📄 Sayfa Yönetimi
            </a>
            
            <!-- AI & Araçlar -->
            <div class="pt-4 border-t border-gray-700">
                <h4 class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">🤖 AI & Araçlar</h4>
                
                <a href="#" onclick="aiUrunOnerisi()" 
                   class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    🧠 AI Ürün Önerisi
                </a>
                
                <a href="#" onclick="barkodFetch()" 
                   class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path>
                    </svg>
                    📱 Barkod Okuyucu
                </a>
                
                <a href="#" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    📊 XML İşlemleri
                </a>
            </div>
        </div>
    </nav>
</div>

