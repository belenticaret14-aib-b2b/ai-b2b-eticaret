<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel')</title>
    
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
    <!-- Admin Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo & Title -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('vitrin.index') }}" class="text-2xl font-bold text-blue-600">
                        🏢 AI B2B
                    </a>
                    <div class="h-8 w-px bg-gray-300"></div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Admin Panel')</h1>
                        <p class="text-sm text-gray-600">@yield('page-subtitle', 'Yönetim Paneli')</p>
                    </div>
                </div>
                
                <!-- User Info & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-6H4v6zM4 5h6V1H4v4zM15 1v4h6V1h-6z"></path>
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 text-sm text-gray-700 hover:text-gray-900">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                                {{ substr(Auth::user()->ad ?? 'A', 0, 1) }}
                            </div>
                            <div class="hidden md:block">
                                <p class="font-medium">{{ Auth::user()->ad ?? 'Admin' }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->rol ?? 'admin') }}</p>
                            </div>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                👤 Profil
                            </a>
                            <a href="{{ route('vitrin.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                🌐 Siteye Git
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    🚪 Çıkış Yap
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-sm min-h-screen">
            <nav class="mt-8">
                @yield('sidebar')
            </nav>
        </aside>

        <!-- Page Content -->
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    © {{ date('Y') }} AI B2B E-Ticaret. Tüm hakları saklıdır.
                </div>
                <div class="flex space-x-6 text-sm text-gray-500">
                    <a href="{{ route('vitrin.index') }}" class="hover:text-gray-900">Ana Sayfa</a>
                    <a href="#" class="hover:text-gray-900">Yardım</a>
                    <a href="#" class="hover:text-gray-900">İletişim</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>







