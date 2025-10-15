<!DOCTYPE html>
<html lang="tr" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NetMarketiniz - Bayi Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="h-full" x-data="dealerDashboard()">
    <!-- Modern Sidebar -->
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex flex-col flex-grow pt-5 bg-white overflow-y-auto border-r border-gray-200">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-600 to-teal-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                        <span class="ml-3 text-xl font-bold text-gray-900">Bayi Panel</span>
                    </div>
                </div>
                
                <!-- Bayi Bilgileri -->
                <div class="mt-6 px-4">
                    <div class="bg-gradient-to-r from-green-50 to-teal-50 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-600 to-teal-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-store text-white"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">Bayi Adı</h3>
                                <p class="text-xs text-gray-500">Bayi ID: #12345</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Aktif Bayi
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="mt-8 flex-grow flex flex-col">
                    <nav class="flex-1 px-2 space-y-1">
                        <!-- Dashboard -->
                        <a href="#" @click="activeTab = 'dashboard'" 
                           :class="activeTab === 'dashboard' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        
                        <!-- Tahsis Edilen Ürünler -->
                        <a href="#" @click="activeTab = 'products'" 
                           :class="activeTab === 'products' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-box mr-3"></i>
                            Tahsis Edilen Ürünler
                        </a>
                        
                        <!-- Satış Yönetimi -->
                        <a href="#" @click="activeTab = 'sales'" 
                           :class="activeTab === 'sales' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-chart-line mr-3"></i>
                            Satış Yönetimi
                        </a>
                        
                        <!-- Sevk İstekleri -->
                        <a href="#" @click="activeTab = 'shipping'" 
                           :class="activeTab === 'shipping' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-shipping-fast mr-3"></i>
                            Sevk İstekleri
                        </a>
                        
                        <!-- Platform Export -->
                        <a href="#" @click="activeTab = 'export'" 
                           :class="activeTab === 'export' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-download mr-3"></i>
                            Platform Export
                        </a>
                        
                        <!-- Kendi Ürünlerim -->
                        <a href="#" @click="activeTab = 'my-products'" 
                           :class="activeTab === 'my-products' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-boxes mr-3"></i>
                            Kendi Ürünlerim
                        </a>
                        
                        <!-- Siparişlerim -->
                        <a href="#" @click="activeTab = 'orders'" 
                           :class="activeTab === 'orders' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Siparişlerim
                        </a>
                        
                        <!-- Raporlar -->
                        <a href="#" @click="activeTab = 'reports'" 
                           :class="activeTab === 'reports' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-chart-bar mr-3"></i>
                            Raporlar
                        </a>
                        
                        <!-- Profil -->
                        <a href="#" @click="activeTab = 'profile'" 
                           :class="activeTab === 'profile' ? 'bg-green-50 border-r-2 border-green-600 text-green-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-user mr-3"></i>
                            Profil
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
                                       placeholder="Ürün ara..." type="search">
                            </div>
                        </div>
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Notifications -->
                        <button class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-bell"></i>
                            <span class="absolute -mt-1 -mr-1 h-3 w-3 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <button @click="open = !open" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Bayi+User&background=10b981&color=fff" alt="">
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
                    @include('bayi.modern-dashboard-content')
                </div>
                
                <!-- Diğer tablar için placeholder -->
                <div x-show="activeTab === 'products'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Tahsis Edilen Ürünler</h1>
                            <p class="mt-2 text-gray-600">Süper admin tarafından size tahsis edilen ürünler.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'sales'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Satış Yönetimi</h1>
                            <p class="mt-2 text-gray-600">Satış işlemlerinizi yönetin ve takip edin.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'shipping'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Sevk İstekleri</h1>
                            <p class="mt-2 text-gray-600">Ürünleri adresinize gönderim için talep edin.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'export'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Platform Export</h1>
                            <p class="mt-2 text-gray-600">XML ve Excel formatında export işlemleri.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'my-products'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Kendi Ürünlerim</h1>
                            <p class="mt-2 text-gray-600">Kendi ürünlerinizi platformlara gönderin.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'orders'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Siparişlerim</h1>
                            <p class="mt-2 text-gray-600">Verdiğiniz siparişlerin takibi.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'reports'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Raporlar</h1>
                            <p class="mt-2 text-gray-600">Satış ve performans raporlarınız.</p>
                        </div>
                    </div>
                </div>
                
                <div x-show="activeTab === 'profile'" x-transition>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            <h1 class="text-2xl font-semibold text-gray-900">Profil</h1>
                            <p class="mt-2 text-gray-600">Bayi profil bilgilerinizi düzenleyin.</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function dealerDashboard() {
            return {
                activeTab: 'dashboard',
                
                init() {
                    // Bayi dashboard başlangıç işlemleri
                    console.log('Dealer Dashboard loaded');
                }
            }
        }
    </script>
</body>
</html>




