<!DOCTYPE html>
<html lang="tr" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NetMarketiniz - Süper Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="h-full" x-data="dashboard()">
    <!-- Modern Sidebar -->
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex flex-col flex-grow pt-5 bg-white overflow-y-auto border-r border-gray-200">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-white text-sm"></i>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-900">NetMarketiniz</span>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="mt-8 flex-grow flex flex-col">
                    <nav class="flex-1 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="#" @click="activeTab = 'dashboard'" 
                           :class="activeTab === 'dashboard' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        
                        <!-- Menü Yönetimi -->
                        <a href="#" @click="activeTab = 'menu-control'" 
                           :class="activeTab === 'menu-control' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-bars mr-3"></i>
                            Menü Kontrolü
                        </a>
                        
                        <!-- Ürün Yönetimi -->
                        <a href="#" @click="activeTab = 'products'" 
                           :class="activeTab === 'products' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-box mr-3"></i>
                            Ürün Yönetimi
                        </a>
                        
                        <!-- Bayi Yönetimi -->
                        <a href="#" @click="activeTab = 'dealers'" 
                           :class="activeTab === 'dealers' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-users mr-3"></i>
                            Bayi Yönetimi
                        </a>
                        
                        <!-- Mağaza Yönetimi -->
                        <a href="#" @click="activeTab = 'stores'" 
                           :class="activeTab === 'stores' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-store mr-3"></i>
                            Mağaza Yönetimi
                        </a>
                        
                        <!-- Sipariş Yönetimi -->
                        <a href="#" @click="activeTab = 'orders'" 
                           :class="activeTab === 'orders' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Sipariş Yönetimi
                        </a>
                        
                        <!-- Platform Entegrasyonları -->
                        <a href="#" @click="activeTab = 'integrations'" 
                           :class="activeTab === 'integrations' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-plug mr-3"></i>
                            Platform Entegrasyonları
                        </a>
                        
                        <!-- Claude AI -->
                        <a href="#" @click="activeTab = 'claude'" 
                           :class="activeTab === 'claude' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-robot mr-3"></i>
                            Claude AI
                        </a>
                        
                        <!-- Raporlar -->
                        <a href="#" @click="activeTab = 'reports'" 
                           :class="activeTab === 'reports' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Raporlar
                        </a>
                        
                        <!-- Sistem Ayarları -->
                        <a href="#" @click="activeTab = 'settings'" 
                           :class="activeTab === 'settings' ? 'bg-blue-50 border-r-2 border-blue-600 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-cog mr-3"></i>
                            Sistem Ayarları
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:pl-64 flex flex-col flex-1">
            <!-- Top Navigation -->
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <div class="w-full flex md:ml-0">
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm" 
                                       placeholder="Ara..." type="search">
                            </div>
                        </div>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notifications -->
                        <button class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-bell"></i>
                        </button>
                        
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <button @click="open = !open" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Süper+Admin&background=6366f1&color=fff" alt="">
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                 style="display: none;">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ayarlar</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Çıkış</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-1">
                <!-- Dashboard Tab -->
                <div x-show="activeTab === 'dashboard'" x-transition>
                    @include('super-admin.modern-dashboard-content')
                </div>
                
                <!-- Menü Kontrolü Tab -->
                <div x-show="activeTab === 'menu-control'" x-transition>
                    @include('super-admin.modern-menu-control')
                </div>
                
                <!-- Diğer tablar için placeholder -->
                <div x-show="activeTab === 'products'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Ürün Yönetimi</h1>
                            <p class="mt-2 text-gray-600">Ürün ekleme, düzenleme ve bayi tahsis işlemleri.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'dealers'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Bayi Yönetimi</h1>
                            <p class="mt-2 text-gray-600">Bayi ekleme, yetki verme ve yönetim işlemleri.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'stores'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Mağaza Yönetimi</h1>
                            <p class="mt-2 text-gray-600">Ana mağaza ve bayi mağazalarının yönetimi.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'orders'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Sipariş Yönetimi</h1>
                            <p class="mt-2 text-gray-600">Tüm siparişlerin takibi ve yönetimi.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'integrations'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Platform Entegrasyonları</h1>
                            <p class="mt-2 text-gray-600">Trendyol, Hepsiburada, N11 entegrasyon yönetimi.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'claude'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Claude AI</h1>
                            <p class="mt-2 text-gray-600">AI destekli içerik üretimi ve analiz.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'reports'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Raporlar</h1>
                            <p class="mt-2 text-gray-600">Satış, stok ve performans raporları.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'settings'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Sistem Ayarları</h1>
                            <p class="mt-2 text-gray-600">Genel sistem ayarları ve konfigürasyon.</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function dashboard() {
            return {
                activeTab: 'dashboard',
                
                init() {
                    // Dashboard başlangıç işlemleri
                    console.log('Modern Dashboard loaded');
                }
            }
        }
    </script>
</body>
</html>




