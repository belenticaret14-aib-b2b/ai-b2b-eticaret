<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', $siteAyarlar['site_adi'] ?? 'AI B2B E-Ticaret')</title>
        
        @if(isset($meta_description) || View::hasSection('meta_description'))
        <meta name="description" content="@yield('meta_description', $meta_description ?? $siteAyarlar['site_aciklama'] ?? '')">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- TailwindCSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <nav class="container mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('vitrin.index') }}" class="text-2xl font-bold text-blue-600">
                            {{ $siteAyarlar['site_adi'] ?? 'AI B2B E-Ticaret' }}
                        </a>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-lg mx-8">
                        <form action="{{ route('vitrin.arama') }}" method="GET" class="flex w-full">
                            <input type="text" name="q" value="{{ request('q') }}" 
                                   placeholder="Ürün ara..." 
                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r-md hover:bg-blue-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('vitrin.index') }}" class="text-gray-700 hover:text-blue-600 transition">Ana Sayfa</a>
                        <a href="{{ route('sayfa.hakkimizda') }}" class="text-gray-700 hover:text-blue-600 transition">Hakkımızda</a>
                        <a href="{{ route('sayfa.iletisim') }}" class="text-gray-700 hover:text-blue-600 transition">İletişim</a>
                        
                        <!-- Sepet -->
                        @php
                            $sepetNav = session('sepet', ['items' => []]);
                            $adetToplam = array_sum(array_map(fn($i) => $i['adet'] ?? 0, $sepetNav['items']));
                        @endphp
                        <a href="{{ route('sepet.index') }}" class="relative text-gray-700 hover:text-blue-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13h0m9 4a1 1 0 11-2 0 1 1 0 012 0zM6 18a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                            @if($adetToplam)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">{{ $adetToplam }}</span>
                            @endif
                        </a>
                        
                        <!-- B2B/Admin Links -->
                        <div class="flex items-center space-x-2">
                            <a href="/b2b-login" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition">B2B Giriş</a>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="text-gray-500 hover:text-gray-600" x-data @click="$dispatch('toggle-mobile-menu')">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Navigation -->
                <div class="md:hidden mt-4" x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-transition>
                    <div class="space-y-2">
                        <a href="{{ route('vitrin.index') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600">Ana Sayfa</a>
                        <a href="{{ route('sayfa.hakkimizda') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600">Hakkımızda</a>
                        <a href="{{ route('sayfa.iletisim') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600">İletişim</a>
                        <a href="{{ route('sepet.index') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600">Sepet @if($adetToplam)({{ $adetToplam }})@endif</a>
                        <a href="/b2b-login" class="block px-3 py-2 bg-blue-600 text-white rounded-md text-center">B2B Giriş</a>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mx-4 mt-4 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mx-4 mt-4 rounded relative" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-16">
            <div class="container mx-auto px-4 py-8">
                <div class="grid md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">{{ $siteAyarlar['site_adi'] ?? 'AI B2B E-Ticaret' }}</h3>
                        <p class="text-gray-300 text-sm mb-4">{{ $siteAyarlar['site_aciklama'] ?? 'Modern teknoloji ile ticaretin buluştuğu yenilikçi B2B/B2C e-ticaret platformu.' }}</p>
                        <div class="flex space-x-4">
                            @if(!empty($siteAyarlar['sosyal_facebook']))
                            <a href="{{ $siteAyarlar['sosyal_facebook'] }}" class="text-gray-300 hover:text-white transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            @endif
                            @if(!empty($siteAyarlar['sosyal_twitter']))
                            <a href="{{ $siteAyarlar['sosyal_twitter'] }}" class="text-gray-300 hover:text-white transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/></svg>
                            </a>
                            @endif
                            @if(!empty($siteAyarlar['sosyal_instagram']))
                            <a href="{{ $siteAyarlar['sosyal_instagram'] }}" class="text-gray-300 hover:text-white transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.223.083.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.747 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Hızlı Linkler</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('vitrin.index') }}" class="text-gray-300 hover:text-white transition">Ana Sayfa</a></li>
                            <li><a href="{{ route('sayfa.hakkimizda') }}" class="text-gray-300 hover:text-white transition">Hakkımızda</a></li>
                            <li><a href="{{ route('sayfa.iletisim') }}" class="text-gray-300 hover:text-white transition">İletişim</a></li>
                            <li><a href="/b2b-login" class="text-gray-300 hover:text-white transition">B2B Giriş</a></li>
                        </ul>
                    </div>
                    
                    <!-- Legal -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Yasal</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('sayfa.gizlilik') }}" class="text-gray-300 hover:text-white transition">Gizlilik Politikası</a></li>
                            <li><a href="{{ route('sayfa.kullanim') }}" class="text-gray-300 hover:text-white transition">Kullanım Şartları</a></li>
                        </ul>
                    </div>
                    
                    <!-- Contact -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">İletişim</h3>
                        <ul class="space-y-2 text-sm text-gray-300">
                            <li>📧 {{ $siteAyarlar['iletisim_email'] ?? 'info@aib2b.com' }}</li>
                            <li>📞 {{ $siteAyarlar['iletisim_telefon'] ?? '+90 212 555 0123' }}</li>
                            <li>📍 {{ $siteAyarlar['iletisim_adres'] ?? 'Atatürk Mah., E-Ticaret Sok. No:1 Şişli/İstanbul' }}</li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-300 text-sm">&copy; {{ date('Y') }} {{ $siteAyarlar['site_adi'] ?? 'AI B2B E-Ticaret' }}. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
