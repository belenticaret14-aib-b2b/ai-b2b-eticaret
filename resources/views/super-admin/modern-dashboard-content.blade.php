<!-- Dashboard İçeriği -->
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Süper Admin Dashboard</h1>
            <p class="mt-2 text-gray-600">NetMarketiniz AI-B2B platformunun ana kontrol merkezi</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <!-- Toplam Ürün -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-box text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Toplam Ürün</dt>
                                <dd class="text-lg font-medium text-gray-900">1,247</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-green-600 font-medium">+12%</span>
                        <span class="text-gray-500">bu ay</span>
                    </div>
                </div>
            </div>

            <!-- Aktif Bayiler -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Aktif Bayiler</dt>
                                <dd class="text-lg font-medium text-gray-900">156</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-green-600 font-medium">+8%</span>
                        <span class="text-gray-500">bu ay</span>
                    </div>
                </div>
            </div>

            <!-- Bekleyen Siparişler -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Bekleyen Sipariş</dt>
                                <dd class="text-lg font-medium text-gray-900">23</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-red-600 font-medium">-3%</span>
                        <span class="text-gray-500">bu hafta</span>
                    </div>
                </div>
            </div>

            <!-- Aylık Ciro -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Aylık Ciro</dt>
                                <dd class="text-lg font-medium text-gray-900">₺247K</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <span class="text-green-600 font-medium">+15%</span>
                        <span class="text-gray-500">bu ay</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Hızlı İşlemler</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white">
                            <i class="fas fa-upload text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            XML/Excel Import
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">Ürün verilerini toplu olarak içe aktar</p>
                    </div>
                </button>

                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-green-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-green-50 text-green-700 ring-4 ring-white">
                            <i class="fas fa-user-plus text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Yeni Bayi Ekle
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">Sisteme yeni bayi kullanıcısı ekle</p>
                    </div>
                </button>

                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-purple-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-purple-50 text-purple-700 ring-4 ring-white">
                            <i class="fas fa-robot text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Claude AI
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">AI destekli içerik üretimi</p>
                    </div>
                </button>

                <button class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                    <div>
                        <span class="rounded-lg inline-flex p-3 bg-yellow-50 text-yellow-700 ring-4 ring-white">
                            <i class="fas fa-chart-bar text-lg"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-medium">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            Raporlar
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">Detaylı analiz ve raporlar</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Recent Activity & System Status -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Son Aktiviteler</h3>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <i class="fas fa-plus text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Yeni bayi <span class="font-medium text-gray-900">Ahmet Yılmaz</span> eklendi</p>
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
                                                <i class="fas fa-box text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500"><span class="font-medium text-gray-900">125 ürün</span> XML'den import edildi</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>4 saat önce</time>
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
                                                <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500"><span class="font-medium text-gray-900">15 ürün</span> stok uyarısı</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time>6 saat önce</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Sistem Durumu</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-900">Ana Mağaza</span>
                            </div>
                            <span class="text-sm text-green-600">Çevrimiçi</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-900">Database</span>
                            </div>
                            <span class="text-sm text-green-600">Çevrimiçi</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-900">Claude AI</span>
                            </div>
                            <span class="text-sm text-green-600">Çevrimiçi</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-900">Trendyol API</span>
                            </div>
                            <span class="text-sm text-yellow-600">Beklemede</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                <span class="text-sm font-medium text-gray-900">Hepsiburada API</span>
                            </div>
                            <span class="text-sm text-green-600">Çevrimiçi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modül Yönetimi Kartı -->
        <div class="mt-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                    <i class="fas fa-puzzle-piece text-white"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Modül Yönetimi</h3>
                                <p class="text-sm text-gray-500">Sistem modüllerini yönetin</p>
                            </div>
                        </div>
                        <a href="{{ route('super-admin.modules.index') }}" 
                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Modül Paneli
                        </a>
                    </div>
                    <div class="text-sm text-gray-600">
                        <p>Ödeme, Bayi, XML/Excel, Claude AI, Bot gibi modülleri yönetin. Bayilere istediğiniz modülleri aktif edebilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tema Yönetimi Kartı -->
        <div class="mt-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-pink-500 rounded-md flex items-center justify-center">
                                    <i class="fas fa-palette text-white"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">Tema Yönetimi</h3>
                                <p class="text-sm text-gray-500">Platform görünümünü değiştirin</p>
                            </div>
                        </div>
                        <a href="{{ route('super-admin.theme') }}" 
                           class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Tema Seçici
                        </a>
                    </div>
                    <div class="text-sm text-gray-600">
                        <p>Sisteminizin görünümünü değiştirin ve farklı temalar arasında geçiş yapın. Yapıyı bozmadan tasarım değişiklikleri yapabilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

