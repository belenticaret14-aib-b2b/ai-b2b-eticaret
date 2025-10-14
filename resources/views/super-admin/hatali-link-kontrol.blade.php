@extends('super-admin.layouts.app')

@section('title', 'Süper Admin - Hatalı Link Kontrolü')
@section('page-title', '🔍 Hatalı Link Kontrolü')
@section('page-subtitle', 'Sistemdeki bozuk linkleri tespit edin ve otomatik düzeltin')

@section('content')
<div class="space-y-8" x-data="hataliLinkKontrol()">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-600 to-orange-600 rounded-xl shadow-lg p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-2">🔍 Hatalı Link Kontrol Sistemi</h2>
                <p class="text-red-100 text-lg">Sistemdeki tüm linkleri tarayın ve bozuk olanları otomatik düzeltin</p>
            </div>
            <div class="bg-white bg-opacity-20 p-4 rounded-full">
                <i class="fas fa-search text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Kontrol Butonları -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <button @click="linkTara()" 
                    :disabled="taramada"
                    class="flex-1 bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 text-white px-8 py-4 rounded-lg font-medium transition-colors flex items-center justify-center">
                <i class="fas fa-search mr-3" :class="{ 'animate-spin': taramada }"></i>
                <span x-text="taramada ? 'Taranıyor...' : '🔍 Linkleri Tara'"></span>
            </button>
            
            <button @click="otomatikDuzelt()" 
                    :disabled="duzeltmede || !taramaTamamlandi"
                    class="flex-1 bg-green-500 hover:bg-green-600 disabled:bg-gray-400 text-white px-8 py-4 rounded-lg font-medium transition-colors flex items-center justify-center">
                <i class="fas fa-wrench mr-3" :class="{ 'animate-spin': duzeltmede }"></i>
                <span x-text="duzeltmede ? 'Düzeltiliyor...' : '🔧 Otomatik Düzelt'"></span>
            </button>
        </div>
    </div>

    <!-- Sonuçlar -->
    <div x-show="sonuclar" x-transition class="space-y-6">
        <!-- Özet -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">📊 Tarama Sonuçları</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                <div class="bg-red-50 p-6 rounded-lg text-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-3"></i>
                    <p class="text-2xl font-bold text-red-600" x-text="sonuclar.toplam_hata || 0"></p>
                    <p class="text-red-600 font-medium">Toplam Hata</p>
                </div>
                
                <div class="bg-orange-50 p-6 rounded-lg text-center">
                    <i class="fas fa-route text-orange-500 text-3xl mb-3"></i>
                    <p class="text-2xl font-bold text-orange-600" x-text="sonuclar.kategoriler?.route || 0"></p>
                    <p class="text-orange-600 font-medium">Route Hataları</p>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <i class="fas fa-file-code text-blue-500 text-3xl mb-3"></i>
                    <p class="text-2xl font-bold text-blue-600" x-text="sonuclar.kategoriler?.view || 0"></p>
                    <p class="text-blue-600 font-medium">View Hataları</p>
                </div>
                
                <div class="bg-purple-50 p-6 rounded-lg text-center">
                    <i class="fas fa-folder text-purple-500 text-3xl mb-3"></i>
                    <p class="text-2xl font-bold text-purple-600" x-text="sonuclar.kategoriler?.asset || 0"></p>
                    <p class="text-purple-600 font-medium">Asset Hataları</p>
                </div>
                
                <div class="bg-green-50 p-6 rounded-lg text-center">
                    <i class="fas fa-clock text-green-500 text-3xl mb-3"></i>
                    <p class="text-2xl font-bold text-green-600" x-text="sonuclar.analiz_suresi || '0ms'"></p>
                    <p class="text-green-600 font-medium">Analiz Süresi</p>
                </div>
            </div>
        </div>

        <!-- Öncelik Analizi -->
        <div x-show="sonuclar.oncelikler" class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">⚠️ Öncelik Analizi</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-red-100 p-4 rounded-lg text-center">
                    <i class="fas fa-fire text-red-600 text-2xl mb-2"></i>
                    <p class="text-xl font-bold text-red-700" x-text="sonuclar.oncelikler?.kritik || 0"></p>
                    <p class="text-red-700 font-medium text-sm">Kritik</p>
                </div>
                
                <div class="bg-orange-100 p-4 rounded-lg text-center">
                    <i class="fas fa-exclamation-circle text-orange-600 text-2xl mb-2"></i>
                    <p class="text-xl font-bold text-orange-700" x-text="sonuclar.oncelikler?.yuksek || 0"></p>
                    <p class="text-orange-700 font-medium text-sm">Yüksek</p>
                </div>
                
                <div class="bg-yellow-100 p-4 rounded-lg text-center">
                    <i class="fas fa-exclamation text-yellow-600 text-2xl mb-2"></i>
                    <p class="text-xl font-bold text-yellow-700" x-text="sonuclar.oncelikler?.orta || 0"></p>
                    <p class="text-yellow-700 font-medium text-sm">Orta</p>
                </div>
                
                <div class="bg-blue-100 p-4 rounded-lg text-center">
                    <i class="fas fa-info-circle text-blue-600 text-2xl mb-2"></i>
                    <p class="text-xl font-bold text-blue-700" x-text="sonuclar.oncelikler?.dusuk || 0"></p>
                    <p class="text-blue-700 font-medium text-sm">Düşük</p>
                </div>
            </div>
        </div>

        <!-- Detaylı Sonuçlar -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">📋 Detaylı Hata Listesi</h3>
            
            <!-- Hata Listesi -->
            <div class="space-y-4">
                <template x-for="(hata, index) in sonuclar.hatalar || []" :key="index">
                    <div class="border rounded-lg p-4" 
                         :class="{
                             'border-red-200 bg-red-50': hata.oncelik === 'kritik',
                             'border-orange-200 bg-orange-50': hata.oncelik === 'yuksek',
                             'border-yellow-200 bg-yellow-50': hata.oncelik === 'orta',
                             'border-blue-200 bg-blue-50': hata.oncelik === 'dusuk'
                         }">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span :class="{
                                        'bg-red-100 text-red-700': hata.oncelik === 'kritik',
                                        'bg-orange-100 text-orange-700': hata.oncelik === 'yuksek',
                                        'bg-yellow-100 text-yellow-700': hata.oncelik === 'orta',
                                        'bg-blue-100 text-blue-700': hata.oncelik === 'dusuk'
                                    }" 
                                    class="px-2 py-1 rounded-full text-xs font-medium mr-3"
                                    x-text="hata.oncelik?.toUpperCase() || 'BİLİNMİYOR'"></span>
                                    
                                    <span class="text-sm font-medium text-gray-600" x-text="hata.tip?.toUpperCase() || 'GENEL'"></span>
                                </div>
                                
                                <h4 class="font-semibold text-gray-900 mb-2" x-text="hata.hata || 'Hata açıklaması bulunamadı'"></h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                                    <div x-show="hata.route">
                                        <strong>Route:</strong> <span class="font-mono" x-text="hata.route"></span>
                                    </div>
                                    <div x-show="hata.dosya">
                                        <strong>Dosya:</strong> <span class="font-mono" x-text="hata.dosya"></span>
                                    </div>
                                    <div x-show="hata.view">
                                        <strong>View:</strong> <span class="font-mono" x-text="hata.view"></span>
                                    </div>
                                    <div x-show="hata.satir">
                                        <strong>Satır:</strong> <span x-text="hata.satir"></span>
                                    </div>
                                </div>
                                
                                <div x-show="hata.cozum" class="mt-3 p-3 bg-green-100 rounded-lg">
                                    <strong class="text-green-800">💡 Çözüm Önerisi:</strong>
                                    <p class="text-green-700 text-sm mt-1" x-text="hata.cozum"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Çözüm Önerileri -->
        <div x-show="sonuclar.cozum_onerileri?.length" class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">💡 Çözüm Önerileri</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <template x-for="oneri in sonuclar.cozum_onerileri || []" :key="oneri.kategori">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-2" x-text="oneri.kategori?.replace('_', ' ').toUpperCase() || 'GENEL'"></h4>
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-medium" x-text="oneri.sayi || 0"></span> hata tespit edildi
                        </p>
                        <p class="text-sm text-green-700" x-text="oneri.ornek_cozum || 'Çözüm önerisi bulunamadı'"></p>
                    </div>
                </template>
            </div>
        </div>

            <!-- View Linkler -->
            <div x-show="sonuclar.detaylar?.view_linkler" class="mb-8">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-file-code text-green-500 mr-2"></i>
                    View Linkler
                    <span class="ml-2 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                        <span x-text="sonuclar.detaylar.view_linkler?.toplam || 0"></span> link
                    </span>
                </h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Dosya</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Route</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">URL</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="link in sonuclar.detaylar.view_linkler?.liste || []" :key="link.dosya + link.route">
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-3 font-mono text-sm" x-text="link.dosya"></td>
                                    <td class="px-4 py-3 font-mono text-sm" x-text="link.route"></td>
                                    <td class="px-4 py-3">
                                        <span x-text="link.url || 'N/A'" 
                                              :class="link.durum === 'hatali' ? 'text-red-600' : 'text-gray-700'"></span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span :class="link.durum === 'hatali' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'" 
                                              class="px-2 py-1 rounded-full text-xs font-medium"
                                              x-text="link.durum === 'hatali' ? '❌ Hatalı' : '✅ Çalışıyor'"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Asset Dosyalar -->
            <div x-show="sonuclar.detaylar?.asset_dosyalar">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-folder text-purple-500 mr-2"></i>
                    Asset Dosyalar
                    <span class="ml-2 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">
                        <span x-text="sonuclar.detaylar.asset_dosyalar?.toplam || 0"></span> dosya
                    </span>
                </h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Dosya</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Yol</th>
                                <th class="px-4 py-3 text-left font-medium text-gray-700">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="dosya in sonuclar.detaylar.asset_dosyalar?.liste || []" :key="dosya.dosya">
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-3 font-mono text-sm" x-text="dosya.dosya"></td>
                                    <td class="px-4 py-3 text-gray-600" x-text="dosya.yol"></td>
                                    <td class="px-4 py-3">
                                        <span :class="dosya.durum === 'hatali' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'" 
                                              class="px-2 py-1 rounded-full text-xs font-medium"
                                              x-text="dosya.durum === 'hatali' ? '❌ Hatalı' : '✅ Mevcut'"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Düzeltme Sonuçları -->
    <div x-show="duzeltmeSonuclar" x-transition class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">🔧 Otomatik Düzeltme Sonuçları</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-50 p-6 rounded-lg text-center">
                <i class="fas fa-tools text-blue-500 text-3xl mb-3"></i>
                <p class="text-2xl font-bold text-blue-600" x-text="duzeltmeSonuclar.toplam || 0"></p>
                <p class="text-blue-600 font-medium">Toplam İşlem</p>
            </div>
            
            <div class="bg-green-50 p-6 rounded-lg text-center">
                <i class="fas fa-check-circle text-green-500 text-3xl mb-3"></i>
                <p class="text-2xl font-bold text-green-600" x-text="duzeltmeSonuclar.basarili || 0"></p>
                <p class="text-green-600 font-medium">Başarılı</p>
            </div>
            
            <div class="bg-red-50 p-6 rounded-lg text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-3"></i>
                <p class="text-2xl font-bold text-red-600" x-text="duzeltmeSonuclar.hatali || 0"></p>
                <p class="text-red-600 font-medium">Hatalı</p>
            </div>
        </div>

        <!-- Düzeltme Detayları -->
        <div x-show="duzeltmeSonuclar.detaylar">
            <div x-show="duzeltmeSonuclar.detaylar?.view_dosyalar">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">📄 Oluşturulan View Dosyaları</h4>
                <div class="space-y-2">
                    <template x-for="dosya in duzeltmeSonuclar.detaylar.view_dosyalar?.liste || []" :key="dosya.view">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-mono text-sm" x-text="dosya.view"></span>
                            <span :class="dosya.durum === 'olusturuldu' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" 
                                  class="px-2 py-1 rounded-full text-xs font-medium"
                                  x-text="dosya.durum === 'olusturuldu' ? '✅ Oluşturuldu' : '❌ Hatalı'"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div x-show="taramada || duzeltmede" 
         x-transition 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
            <p class="text-gray-700 font-medium" x-text="taramada ? 'Linkler taranıyor...' : 'Otomatik düzeltme yapılıyor...'"></p>
        </div>
    </div>
</div>

<script>
function hataliLinkKontrol() {
    return {
        taramada: false,
        duzeltmede: false,
        sonuclar: null,
        duzeltmeSonuclar: null,
        taramaTamamlandi: false,

        async linkTara() {
            this.taramada = true;
            this.sonuclar = null;
            this.taramaTamamlandi = false;

            try {
                const response = await fetch('{{ route("super-admin.hatali-link-kontrol.tara") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({})
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                
                if (data.success) {
                    this.sonuclar = data;
                    this.taramaTamamlandi = true;
                    console.log('Analiz tamamlandı:', data);
                } else {
                    alert('Hata: ' + (data.error || data.message || 'Bilinmeyen hata'));
                }
            } catch (error) {
                alert('Bağlantı hatası: ' + error.message);
            } finally {
                this.taramada = false;
            }
        },

        async otomatikDuzelt() {
            this.duzeltmede = true;
            this.duzeltmeSonuclar = null;

            try {
                const response = await fetch('{{ route("super-admin.hatali-link-kontrol.duzelt") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    this.duzeltmeSonuclar = data.data;
                    // Taramayı yeniden yap
                    setTimeout(() => this.linkTara(), 2000);
                } else {
                    alert('Hata: ' + data.message);
                }
            } catch (error) {
                alert('Bağlantı hatası: ' + error.message);
            } finally {
                this.duzeltmede = false;
            }
        }
    }
}
</script>
@endsection
