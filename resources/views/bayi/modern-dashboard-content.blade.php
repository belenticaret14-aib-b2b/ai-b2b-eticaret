<!-- Bayi Dashboard İçeriği -->
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Bayi Dashboard</h1>
            <p class="mt-2 text-gray-600">Size tahsis edilen ürünler ve satış işlemleriniz</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Tahsis Edilen Ürünler -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-box text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Tahsis Edilen Ürün</dt>
                                <dd class="text-lg font-medium text-gray-900">247</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-green-600 font-medium">+8</span>
                        <span class="text-gray-500">bu hafta</span>
                    </div>
                </div>
            </div>

            <!-- Bu Ay Satış -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Bu Ay Satış</dt>
                                <dd class="text-lg font-medium text-gray-900">₺45K</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-green-600 font-medium">+12%</span>
                        <span class="text-gray-500">geçen aya göre</span>
                    </div>
                </div>
            </div>

            <!-- Bekleyen Siparişler -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Bekleyen Sipariş</dt>
                                <dd class="text-lg font-medium text-gray-900">12</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-blue-600 font-medium">3</span>
                        <span class="text-gray-500">yeni sipariş</span>
                    </div>
                </div>
            </div>

            <!-- Stok Uyarıları -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Stok Uyarısı</dt>
                                <dd class="text-lg font-medium text-gray-900">5</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-red-600 font-medium">Düşük</span>
                        <span class="text-gray-500">stok seviyesi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Hızlı İşlemler</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-green-50 text-green-700 ring-4 ring-white">
                            <i class="fas fa-eye text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Ürünleri Görüntüle
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">Tahsis edilen ürünleri incele</p>
                    </div>
                </button>

                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white">
                            <i class="fas fa-shipping-fast text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Sevk İste
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">Ürünleri adresine gönder</p>
                    </div>
                </button>

                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-purple-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 ring-4 ring-white">
                            <i class="fas fa-download text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            XML Export
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">Platformlara gönder</p>
                    </div>
                </button>

                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-yellow-50 text-yellow-700 ring-4 ring-white">
                            <i class="fas fa-plus text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Kendi Ürün Ekle
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">Yeni ürün ekle</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Recent Orders & Stock Alerts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Son Siparişler</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-shopping-cart text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Sipariş #12345 - <span class="font-medium text-gray-900">₺1,250</span></p>
                                                <p class="text-xs text-gray-400">15 ürün</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>2 saat önce</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-shopping-cart text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Sipariş #12344 - <span class="font-medium text-gray-900">₺890</span></p>
                                                <p class="text-xs text-gray-400">8 ürün</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>5 saat önce</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-shopping-cart text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Sipariş #12343 - <span class="font-medium text-gray-900">₺2,100</span></p>
                                                <p class="text-xs text-gray-400">22 ürün</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>1 gün önce</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Stock Alerts -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Stok Uyarıları</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Samsung Galaxy S23</p>
                                    <p class="text-xs text-gray-500">Stok: 2 adet</p>
                                </div>
                            </div>
                            <span class="text-sm text-red-600 font-medium">Düşük</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">iPhone 15 Pro</p>
                                    <p class="text-xs text-gray-500">Stok: 5 adet</p>
                                </div>
                            </div>
                            <span class="text-sm text-yellow-600 font-medium">Orta</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">MacBook Air M2</p>
                                    <p class="text-xs text-gray-500">Stok: 1 adet</p>
                                </div>
                            </div>
                            <span class="text-sm text-red-600 font-medium">Kritik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Status -->
        <div class="mt-8 bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Platform Durumu</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-bag text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Trendyol</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-cart text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Hepsiburada</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-store text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-900">N11</span>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Beklemede
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


