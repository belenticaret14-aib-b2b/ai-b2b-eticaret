@extends('layouts.admin')

@section('title', 'Geliştirici Araçları')
@section('page-title', 'Geliştirici Araçları')
@section('page-subtitle', 'API, Bot entegrasyonları ve hata analiz sistemi')

@section('sidebar')
<div class="px-4 space-y-2">
    <!-- Dashboard -->
    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
        </svg>
        Dashboard
    </a>

    <!-- Kullanıcılar -->
    <a href="{{ route('super-admin.kullanicilar') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
        </svg>
        Kullanıcılar
    </a>

    <!-- Mağazalar -->
    <a href="{{ route('super-admin.magazalar') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        Mağazalar
    </a>

    <!-- Bayiler -->
    <a href="{{ route('super-admin.bayiler') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        Bayiler
    </a>

    <!-- Sistem Ayarları -->
    <a href="{{ route('super-admin.sistem-ayarlari') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Sistem Ayarları
    </a>

    <!-- Raporlar -->
    <a href="{{ route('super-admin.raporlar') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        Raporlar
    </a>

    <!-- Geliştirici - Active -->
    <a href="{{ route('super-admin.gelistirici') }}" class="flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
        </svg>
        Geliştirici
    </a>

    <!-- Proje Detayları -->
    <a href="{{ route('super-admin.proje-detaylari') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
        </svg>
        Proje Detayları
    </a>
</div>
@endsection

@section('content')
<!-- Sistem Sağlık Göstergesi -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">🏥 Sistem Sağlık Durumu</h3>
                    <p class="text-sm text-gray-600">Gerçek zamanlı sistem durumu</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <div id="sistem-durum" class="text-sm">
                    <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800">Kontrol ediliyor...</span>
                </div>
                <button onclick="hizliKontrol()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition mr-2">
                    ⚡ Hızlı Kontrol
                </button>
                <button onclick="sistemSaglikKontrol()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    🔄 Detaylı Kontrol
                </button>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div id="sistem-saglik-detay" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Sistem sağlık detayları buraya gelecek -->
        </div>
    </div>
</div>

<!-- Hata Analiz Bot -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">🤖 Hata Analiz Bot</h3>
                    <p class="text-sm text-gray-600">Sistem hatalarını otomatik tespit eder ve çözüm önerir</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <button onclick="hataAnalizEt()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    🔍 Hata Analiz Et
                </button>
                <button onclick="otomatikDuzelt()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    🔧 Otomatik Düzelt
                </button>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div id="hata-analiz-sonuc" class="hidden">
            <!-- Analiz sonuçları buraya gelecek -->
        </div>
        
        <div id="hata-analiz-bekle" class="text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-600">Sistem analiz ediliyor...</p>
        </div>
    </div>
</div>

<!-- API Documentation -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 ml-3">API Dokümantasyonu</h3>
        </div>
        <p class="text-gray-600 mb-4">RESTful API endpoints ve kullanım örnekleri</p>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="font-medium">Base URL</span>
                <code class="bg-gray-200 px-2 py-1 rounded text-sm">{{ url('/api/v1') }}</code>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="font-medium">Authentication</span>
                <span class="text-sm text-gray-600">Bearer Token</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="font-medium">Rate Limit</span>
                <span class="text-sm text-gray-600">1000 req/hour</span>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">API Dokümantasyonu →</a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center mb-4">
            <div class="p-3 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 ml-3">Bot Entegrasyonları</h3>
        </div>
        <p class="text-gray-600 mb-4">WhatsApp, Telegram ve Discord bot ayarları</p>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="font-medium">WhatsApp Bot</span>
                <span class="text-sm text-green-600">Aktif</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="font-medium">Telegram Bot</span>
                <span class="text-sm text-green-600">Aktif</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="font-medium">Discord Bot</span>
                <span class="text-sm text-yellow-600">Beklemede</span>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('super-admin.bot-ayarlari') }}" class="text-blue-600 hover:text-blue-800 font-medium">Bot Ayarları →</a>
        </div>
    </div>
</div>

<!-- Webhook Endpoints -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">🔗 Webhook Endpoints</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">WhatsApp</h4>
                <code class="text-sm text-gray-600 break-all">{{ url('/webhook/bot/whatsapp') }}</code>
            </div>
            <div class="border rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Telegram</h4>
                <code class="text-sm text-gray-600 break-all">{{ url('/webhook/bot/telegram') }}</code>
            </div>
            <div class="border rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Discord</h4>
                <code class="text-sm text-gray-600 break-all">{{ url('/webhook/bot/discord') }}</code>
            </div>
        </div>
    </div>
</div>

<!-- Hatalı Link Kontrolü -->
<div class="bg-white rounded-lg shadow mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">🔗 Hatalı Link Kontrolü</h3>
                    <p class="text-sm text-gray-600">Route, View ve Controller hatalarını tespit eder ve otomatik düzeltir</p>
                </div>
            </div>
            <div class="flex space-x-2">
                <button onclick="hizliLinkKontrol()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    ⚡ Hızlı Link Kontrol
                </button>
                <button onclick="hataliLinkKontrol()" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">
                    🔍 Detaylı Link Kontrol
                </button>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div id="hatali-link-sonuc" class="hidden">
            <!-- Link kontrol sonuçları buraya gelecek -->
        </div>
    </div>
</div>

<!-- Hızlı Araçlar -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">⚡ Hızlı Araçlar</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <button onclick="cacheTemizle()" class="p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition text-left">
                <div class="text-2xl mb-2">🗑️</div>
                <div class="font-medium text-gray-900">Cache Temizle</div>
                <div class="text-sm text-gray-600">Sistem cache'ini temizle</div>
            </button>
            
            <button onclick="logTemizle()" class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition text-left">
                <div class="text-2xl mb-2">📝</div>
                <div class="font-medium text-gray-900">Log Temizle</div>
                <div class="text-sm text-gray-600">Eski log dosyalarını sil</div>
            </button>
            
            <button onclick="sistemKontrol()" class="p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition text-left">
                <div class="text-2xl mb-2">🔍</div>
                <div class="font-medium text-gray-900">Sistem Kontrol</div>
                <div class="text-sm text-gray-600">Sistem durumunu kontrol et</div>
            </button>
            
            <button onclick="backupOlustur()" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition text-left">
                <div class="text-2xl mb-2">💾</div>
                <div class="font-medium text-gray-900">Backup Oluştur</div>
                <div class="text-sm text-gray-600">Sistem yedeği al</div>
            </button>
            
            <a href="{{ route('super-admin.proje-detaylari') }}" class="p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition text-left">
                <div class="text-2xl mb-2">📋</div>
                <div class="font-medium text-gray-900">Proje Detayları</div>
                <div class="text-sm text-gray-600">Geliştirme aşamaları</div>
            </a>
            
            <a href="{{ route('super-admin.claude') }}" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition text-left">
                <div class="text-2xl mb-2">🤖</div>
                <div class="font-medium text-gray-900">Claude AI</div>
                <div class="text-sm text-gray-600">Yapay zeka yardımcı</div>
            </a>
        </div>
    </div>
</div>

<script>
function hataAnalizEt() {
    document.getElementById('hata-analiz-bekle').classList.remove('hidden');
    document.getElementById('hata-analiz-sonuc').classList.add('hidden');
    
    fetch('/super-admin/hata-analiz', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('hata-analiz-bekle').classList.add('hidden');
        document.getElementById('hata-analiz-sonuc').classList.remove('hidden');
        document.getElementById('hata-analiz-sonuc').innerHTML = hataAnalizSonucGoster(data);
    })
    .catch(error => {
        console.error('Hata:', error);
        document.getElementById('hata-analiz-bekle').classList.add('hidden');
        alert('Hata analizi başarısız: ' + error.message);
    });
}

function otomatikDuzelt() {
    if (confirm('Otomatik düzeltme işlemini başlatmak istediğinizden emin misiniz?')) {
        fetch('/super-admin/otomatik-duzelt', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Otomatik düzeltme tamamlandı: ' + data.message);
            } else {
                alert('Düzeltme başarısız: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Hata:', error);
            alert('Düzeltme hatası: ' + error.message);
        });
    }
}

function hataAnalizSonucGoster(data) {
    let html = '<div class="space-y-4">';
    
    // Genel durum
    const durumRenk = data.genel_durum === 'kritik' ? 'red' : data.genel_durum === 'uyari' ? 'yellow' : 'green';
    html += `<div class="p-4 bg-${durumRenk}-50 border border-${durumRenk}-200 rounded-lg">
        <h4 class="font-semibold text-${durumRenk}-800">Sistem Durumu: ${data.genel_durum.toUpperCase()}</h4>
    </div>`;
    
    // Kritik hatalar
    if (data.kritik_hatalar && data.kritik_hatalar.length > 0) {
        html += '<div class="p-4 bg-red-50 border border-red-200 rounded-lg">';
        html += '<h4 class="font-semibold text-red-800 mb-2">🚨 Kritik Hatalar</h4>';
        data.kritik_hatalar.forEach(hata => {
            html += `<div class="mb-2">
                <div class="font-medium text-red-700">${hata.mesaj}</div>
                <div class="text-sm text-red-600">${hata.detay}</div>
                <div class="text-sm text-red-500">Çözüm: ${hata.cozum}</div>
            </div>`;
        });
        html += '</div>';
    }
    
    // Uyarılar
    if (data.uyarilar && data.uyarilar.length > 0) {
        html += '<div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">';
        html += '<h4 class="font-semibold text-yellow-800 mb-2">⚠️ Uyarılar</h4>';
        data.uyarilar.forEach(uyari => {
            html += `<div class="mb-2">
                <div class="font-medium text-yellow-700">${uyari.mesaj}</div>
                <div class="text-sm text-yellow-600">${uyari.detay}</div>
                <div class="text-sm text-yellow-500">Çözüm: ${uyari.cozum}</div>
            </div>`;
        });
        html += '</div>';
    }
    
    // Sistem sağlığı
    if (data.sistem_sagligi) {
        const saglikRenk = data.sistem_sagligi.genel_durum === 'iyi' ? 'green' : 
                          data.sistem_sagligi.genel_durum === 'uyari' ? 'yellow' : 'red';
        html += `<div class="p-4 bg-${saglikRenk}-50 border border-${saglikRenk}-200 rounded-lg">`;
        html += '<h4 class="font-semibold text-blue-800 mb-2">🏥 Sistem Sağlığı</h4>';
        html += `<div class="grid grid-cols-2 gap-4 text-sm">
            <div>Veritabanı: <span class="font-medium text-${data.sistem_sagligi.veritabani === 'iyi' ? 'green' : 'red'}-600">${data.sistem_sagligi.veritabani}</span></div>
            <div>Cache: <span class="font-medium text-${data.sistem_sagligi.cache === 'iyi' ? 'green' : 'red'}-600">${data.sistem_sagligi.cache}</span></div>
            <div>Dosya Sistemi: <span class="font-medium text-${data.sistem_sagligi.dosya_sistemi === 'iyi' ? 'green' : 'red'}-600">${data.sistem_sagligi.dosya_sistemi}</span></div>
            <div>API Bağlantıları: <span class="font-medium text-${data.sistem_sagligi.api_baglantilari === 'iyi' ? 'green' : 'red'}-600">${data.sistem_sagligi.api_baglantilari}</span></div>
        </div>`;
        html += '</div>';
    }

    // Performans metrikleri
    if (data.performans_metrikleri) {
        html += '<div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">';
        html += '<h4 class="font-semibold text-blue-800 mb-2">📊 Performans Metrikleri</h4>';
        html += `<div class="grid grid-cols-2 gap-4 text-sm">
            <div>Toplam Sipariş: ${data.performans_metrikleri.toplam_siparis}</div>
            <div>Bugün Sipariş: ${data.performans_metrikleri.bugun_siparis}</div>
            <div>Aktif Ürün: ${data.performans_metrikleri.aktif_urun}</div>
            <div>Aktif Mağaza: ${data.performans_metrikleri.aktif_magaza}</div>
            <div>Senkron Başarı: %${data.performans_metrikleri.senkron_basarisi}</div>
            <div>Ortalama Tutar: ₺${data.performans_metrikleri.ortalama_siparis_tutari}</div>
        </div>`;
        html += '</div>';
    }
    
    html += '</div>';
    return html;
}

function cacheTemizle() {
    if (confirm('Cache temizleme işlemini başlatmak istediğinizden emin misiniz?')) {
        alert('Cache temizleme işlemi başlatıldı!');
    }
}

function logTemizle() {
    if (confirm('Log temizleme işlemini başlatmak istediğinizden emin misiniz?')) {
        alert('Log temizleme işlemi başlatıldı!');
    }
}

function sistemKontrol() {
    alert('Sistem kontrol işlemi başlatıldı!');
}

function backupOlustur() {
    if (confirm('Backup oluşturma işlemini başlatmak istediğinizden emin misiniz?')) {
        alert('Backup oluşturma işlemi başlatıldı!');
    }
}

function sistemSaglikKontrol() {
    document.getElementById('sistem-durum').innerHTML = '<span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">Kontrol ediliyor...</span>';
    
    fetch('/super-admin/sistem-saglik', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Sistem durumu güncelle
        const durumRenk = data.genel_durum === 'iyi' ? 'green' : data.genel_durum === 'uyari' ? 'yellow' : 'red';
        const durumText = data.genel_durum === 'iyi' ? 'Sağlıklı' : data.genel_durum === 'uyari' ? 'Uyarı' : 'Kritik';
        document.getElementById('sistem-durum').innerHTML = `<span class="px-2 py-1 rounded-full bg-${durumRenk}-100 text-${durumRenk}-800">${durumText}</span>`;
        
        // Sistem sağlık detayları
        if (data.sistem_sagligi) {
            let html = '';
            const servisler = [
                { name: 'Veritabanı', key: 'veritabani', icon: '🗄️' },
                { name: 'Cache', key: 'cache', icon: '💾' },
                { name: 'Dosya Sistemi', key: 'dosya_sistemi', icon: '📁' },
                { name: 'API Bağlantıları', key: 'api_baglantilari', icon: '🔗' }
            ];
            
            servisler.forEach(servis => {
                const durum = data.sistem_sagligi[servis.key] || 'bilinmiyor';
                const renk = durum === 'iyi' ? 'green' : durum === 'uyari' ? 'yellow' : 'red';
                const durumText = durum === 'iyi' ? 'Sağlıklı' : durum === 'uyari' ? 'Uyarı' : 'Hata';
                
                html += `
                    <div class="p-4 border rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">${servis.icon} ${servis.name}</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-${renk}-100 text-${renk}-800">${durumText}</span>
                        </div>
                        <div class="text-xs text-gray-500">Son kontrol: ${data.timestamp}</div>
                    </div>
                `;
            });
            
            document.getElementById('sistem-saglik-detay').innerHTML = html;
        }
    })
    .catch(error => {
        console.error('Hata:', error);
        document.getElementById('sistem-durum').innerHTML = '<span class="px-2 py-1 rounded-full bg-red-100 text-red-800">Hata</span>';
    });
}

function hizliKontrol() {
    document.getElementById('sistem-durum').innerHTML = '<span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">Hızlı kontrol ediliyor...</span>';
    
    fetch('/super-admin/hizli-kontrol', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Sistem durumu güncelle
        const durumRenk = data.durum === 'iyi' ? 'green' : 'red';
        const durumText = data.durum === 'iyi' ? 'Sağlıklı' : 'Hata';
        document.getElementById('sistem-durum').innerHTML = `<span class="px-2 py-1 rounded-full bg-${durumRenk}-100 text-${durumRenk}-800">${durumText}</span>`;
        
        // Hızlı sistem sağlık detayları
        if (data.performans) {
            let html = '';
            const servisler = [
                { name: 'Veritabanı', key: 'veritabani', icon: '🗄️' },
                { name: 'Cache', key: 'cache', icon: '💾' },
                { name: 'Dosya Sistemi', key: 'dosya_sistemi', icon: '📁' },
                { name: 'API Bağlantıları', key: 'api_baglantilari', icon: '🔗' }
            ];
            
            servisler.forEach(servis => {
                const durum = data.performans[servis.key] || 'bilinmiyor';
                const renk = durum === 'iyi' ? 'green' : 'red';
                const durumText = durum === 'iyi' ? 'Sağlıklı' : 'Hata';
                
                html += `
                    <div class="p-4 border rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">${servis.icon} ${servis.name}</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-${renk}-100 text-${renk}-800">${durumText}</span>
                        </div>
                        <div class="text-xs text-gray-500">Hızlı kontrol: ${data.timestamp}</div>
                    </div>
                `;
            });
            
            document.getElementById('sistem-saglik-detay').innerHTML = html;
        }
    })
    .catch(error => {
        console.error('Hata:', error);
        document.getElementById('sistem-durum').innerHTML = '<span class="px-2 py-1 rounded-full bg-red-100 text-red-800">Hızlı kontrol hatası</span>';
    });
}

function hizliLinkKontrol() {
    document.getElementById('hatali-link-sonuc').innerHTML = '<p class="text-center text-gray-500">Hızlı link kontrol ediliyor...</p>';
    document.getElementById('hatali-link-sonuc').classList.remove('hidden');

    fetch('/super-admin/hizli-link-kontrol', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        let html = '<div class="space-y-4">';
        
        // Genel durum
        const durumRenk = data.durum === 'iyi' ? 'green' : data.durum === 'duzeltildi' ? 'blue' : 'red';
        const durumText = data.durum === 'iyi' ? 'Tüm linkler sağlıklı' : 
                         data.durum === 'duzeltildi' ? 'Linkler düzeltildi' : 'Link hataları tespit edildi';
        
        html += `<div class="p-4 bg-${durumRenk}-100 text-${durumRenk}-800 rounded-lg font-semibold">${durumText}</div>`;
        
        // Kontrol sonuçları
        html += '<div class="grid grid-cols-3 gap-4 text-sm">';
        html += `<div class="p-3 bg-gray-50 rounded-lg"><strong>Kontrol Edilen:</strong> ${data.kontrol_edilen_linkler}</div>`;
        html += `<div class="p-3 bg-red-50 rounded-lg"><strong>Hatalı Link:</strong> ${data.hatali_linkler}</div>`;
        html += `<div class="p-3 bg-green-50 rounded-lg"><strong>Düzeltilen:</strong> ${data.duzeltilen_linkler}</div>`;
        html += '</div>';
        
        if (data.mesaj) {
            html += `<div class="p-3 bg-yellow-50 text-yellow-800 rounded-lg">${data.mesaj}</div>`;
        }
        
        html += '</div>';
        document.getElementById('hatali-link-sonuc').innerHTML = html;
    })
    .catch(error => {
        console.error('Hata:', error);
        document.getElementById('hatali-link-sonuc').innerHTML = '<p class="text-red-600">Hızlı link kontrolü sırasında bir hata oluştu.</p>';
    });
}

function hataliLinkKontrol() {
    document.getElementById('hatali-link-sonuc').innerHTML = '<p class="text-center text-gray-500">Detaylı link kontrol ediliyor...</p>';
    document.getElementById('hatali-link-sonuc').classList.remove('hidden');

    fetch('/super-admin/hatali-link-kontrol', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        let html = '<div class="space-y-4">';
        
        // Genel durum
        const durumRenk = data.genel_durum === 'mukemmel' ? 'green' : 
                         data.genel_durum === 'iyilestirildi' ? 'blue' : 'orange';
        const durumText = data.genel_durum === 'mukemmel' ? 'Mükemmel - Hiç hata yok' :
                         data.genel_durum === 'iyilestirildi' ? 'İyileştirildi - Hatalar düzeltildi' :
                         'Dikkat - Hatalar tespit edildi';
        
        html += `<div class="p-4 bg-${durumRenk}-100 text-${durumRenk}-800 rounded-lg font-semibold">${durumText}</div>`;
        
        // Tespit edilen hatalar
        if (data.tespit_edilen_hatalar && data.tespit_edilen_hatalar.length > 0) {
            html += '<div class="p-4 bg-red-50 border border-red-200 rounded-lg">';
            html += '<h4 class="font-semibold text-red-800 mb-2">🚨 Tespit Edilen Hatalar</h4>';
            html += '<ul class="list-disc pl-5 space-y-1">';
            data.tespit_edilen_hatalar.forEach(hata => {
                const oncelikRenk = hata.oncelik === 'yuksek' ? 'red' : hata.oncelik === 'orta' ? 'yellow' : 'blue';
                html += `<li class="text-sm">
                    <strong class="text-${oncelikRenk}-600">[${hata.tip}]</strong> ${hata.mesaj}<br>
                    <span class="text-gray-600">${hata.detay}</span><br>
                    <span class="text-green-600">💡 ${hata.cozum}</span>
                </li>`;
            });
            html += '</ul>';
            html += '</div>';
        }
        
        // Düzeltilen hatalar
        if (data.duzeltilen_hatalar && data.duzeltilen_hatalar.length > 0) {
            html += '<div class="p-4 bg-green-50 border border-green-200 rounded-lg">';
            html += '<h4 class="font-semibold text-green-800 mb-2">✅ Düzeltilen Hatalar</h4>';
            html += '<ul class="list-disc pl-5 space-y-1">';
            data.duzeltilen_hatalar.forEach(duzeltme => {
                const durumRenk = duzeltme.durum === 'duzeltildi' ? 'green' : 'red';
                html += `<li class="text-sm">
                    <strong>${duzeltme.hata}</strong><br>
                    <span class="text-${durumRenk}-600">${duzeltme.duzeltme}</span>
                </li>`;
            });
            html += '</ul>';
            html += '</div>';
        }
        
        // Düzeltme önerileri
        if (data.duzeltme_onerileri && data.duzeltme_onerileri.length > 0) {
            html += '<div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">';
            html += '<h4 class="font-semibold text-blue-800 mb-2">💡 Düzeltme Önerileri</h4>';
            html += '<ul class="list-disc pl-5 space-y-1">';
            data.duzeltme_onerileri.forEach(oneri => {
                html += `<li class="text-sm">${oneri}</li>`;
            });
            html += '</ul>';
            html += '</div>';
        }
        
        html += '</div>';
        document.getElementById('hatali-link-sonuc').innerHTML = html;
    })
    .catch(error => {
        console.error('Hata:', error);
        document.getElementById('hatali-link-sonuc').innerHTML = '<p class="text-red-600">Detaylı link kontrolü sırasında bir hata oluştu.</p>';
    });
}

// Sayfa yüklendiğinde hızlı kontrol yap
document.addEventListener('DOMContentLoaded', function() {
    hizliKontrol();
});
</script>
@endsection