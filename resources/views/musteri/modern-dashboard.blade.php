<!DOCTYPE html>
<html lang="tr" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NetMarketiniz - Müşteri Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="h-full" x-data="customerDashboard()">
    <!-- Modern Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-orange-600 to-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-white text-sm"></i>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-900">NetMarketiniz</span>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-900 hover:text-orange-600 transition-colors duration-200">Ana Sayfa</a>
                    <a href="#" class="text-gray-600 hover:text-orange-600 transition-colors duration-200">Ürünler</a>
                    <a href="#" class="text-gray-600 hover:text-orange-600 transition-colors duration-200">Kategoriler</a>
                    <a href="#" class="text-gray-600 hover:text-orange-600 transition-colors duration-200">İletişim</a>
                </nav>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Cart -->
                    <button class="relative p-2 text-gray-600 hover:text-orange-600 transition-colors duration-200">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-orange-600 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- Profile -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors duration-200">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Müşteri+User&background=f97316&color=fff" alt="">
                            <span class="hidden md:block text-sm font-medium">Müşteri</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                             style="display: none;">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Siparişlerim</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Favorilerim</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Çıkış</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Hoş Geldiniz!</h1>
                    <p class="text-orange-100">NetMarketiniz'de en iyi ürünleri keşfedin</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Toplam Sipariş -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-blue-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900">24</h3>
                        <p class="text-sm text-gray-500">Toplam Sipariş</p>
                    </div>
                </div>
            </div>

            <!-- Bekleyen Sipariş -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900">3</h3>
                        <p class="text-sm text-gray-500">Bekleyen Sipariş</p>
                    </div>
                </div>
            </div>

            <!-- Favoriler -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-red-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900">12</h3>
                        <p class="text-sm text-gray-500">Favori Ürün</p>
                    </div>
                </div>
            </div>

            <!-- Toplam Harcama -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lira-sign text-green-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-2xl font-bold text-gray-900">₺2,450</h3>
                        <p class="text-sm text-gray-500">Toplam Harcama</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Hızlı İşlemler</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-left">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-shopping-cart text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Siparişlerim</h3>
                            <p class="text-sm text-gray-500">Siparişlerimi görüntüle</p>
                        </div>
                    </div>
                </button>

                <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-left">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-heart text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Favorilerim</h3>
                            <p class="text-sm text-gray-500">Beğendiğim ürünler</p>
                        </div>
                    </div>
                </button>

                <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-left">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-user text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Profil</h3>
                            <p class="text-sm text-gray-500">Bilgilerimi düzenle</p>
                        </div>
                    </div>
                </button>

                <button class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 text-left">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-headset text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Destek</h3>
                            <p class="text-sm text-gray-500">Yardım al</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Recent Orders & Recommendations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Son Siparişlerim</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-box text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Sipariş #12345</h4>
                                    <p class="text-sm text-gray-500">3 ürün • ₺450</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Teslim Edildi
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-shipping-fast text-yellow-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Sipariş #12344</h4>
                                    <p class="text-sm text-gray-500">2 ürün • ₺320</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Kargoda
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-clock text-orange-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Sipariş #12343</h4>
                                    <p class="text-sm text-gray-500">1 ürün • ₺180</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Hazırlanıyor
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Recommendations -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Önerilen Ürünler</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg"></div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">Samsung Galaxy S23</h4>
                                <p class="text-sm text-gray-500">₺25,999</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(4.8)</span>
                                </div>
                            </div>
                            <button class="text-orange-600 hover:text-orange-700">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg"></div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">iPhone 15 Pro</h4>
                                <p class="text-sm text-gray-500">₺52,999</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(4.9)</span>
                                </div>
                            </div>
                            <button class="text-orange-600 hover:text-orange-700">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg"></div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">MacBook Air M2</h4>
                                <p class="text-sm text-gray-500">₺28,999</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(4.7)</span>
                                </div>
                            </div>
                            <button class="text-orange-600 hover:text-orange-700">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function customerDashboard() {
            return {
                init() {
                    // Müşteri dashboard başlangıç işlemleri
                    console.log('Customer Dashboard loaded');
                }
            }
        }
    </script>
</body>
</html>




