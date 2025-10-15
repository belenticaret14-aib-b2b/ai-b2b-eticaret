@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-indigo-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">
                🤖 Claude AI Yardımcı
            </h1>
            <p class="text-gray-600">Yapay zeka destekli içerik oluşturma ve analiz araçları</p>
            <div class="mt-2 inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></span>
                Model: {{ $model }}
            </div>
        </div>

        <!-- Özellikler Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Genel Chat -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-purple-100">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
                    <div class="text-white">
                        <div class="text-4xl mb-3">💬</div>
                        <h3 class="text-xl font-bold">Genel Chat</h3>
                        <p class="text-purple-100 text-sm mt-1">Claude ile sohbet edin</p>
                    </div>
                </div>
                <div class="p-6">
                    <textarea id="chat-prompt" rows="4" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Bir soru sorun veya yardım isteyin..."></textarea>
                    <button onclick="testChat()" 
                        class="mt-4 w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                        Gönder
                    </button>
                    <div id="chat-response" class="mt-4 hidden">
                        <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded">
                            <p class="text-sm font-semibold text-purple-900 mb-2">Claude'un Yanıtı:</p>
                            <p class="text-gray-700 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ürün Açıklaması -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-blue-100">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                    <div class="text-white">
                        <div class="text-4xl mb-3">📦</div>
                        <h3 class="text-xl font-bold">Ürün Açıklaması</h3>
                        <p class="text-blue-100 text-sm mt-1">SEO uyumlu açıklama</p>
                    </div>
                </div>
                <div class="p-6">
                    <input type="text" id="urun-adi" 
                        class="w-full border border-gray-300 rounded-lg p-3 mb-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Ürün adı...">
                    <textarea id="urun-ozellikler" rows="3" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Özellikler (her satıra bir tane)..."></textarea>
                    <button onclick="urunAciklamasi()" 
                        class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                        Açıklama Oluştur
                    </button>
                    <div id="urun-response" class="mt-4 hidden">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                            <p class="text-sm font-semibold text-blue-900 mb-2">Oluşturulan Açıklama:</p>
                            <p class="text-gray-700 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Meta -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-green-100">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
                    <div class="text-white">
                        <div class="text-4xl mb-3">🔍</div>
                        <h3 class="text-xl font-bold">SEO Meta</h3>
                        <p class="text-green-100 text-sm mt-1">Meta description oluştur</p>
                    </div>
                </div>
                <div class="p-6">
                    <input type="text" id="seo-baslik" 
                        class="w-full border border-gray-300 rounded-lg p-3 mb-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Sayfa başlığı...">
                    <textarea id="seo-icerik" rows="3" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Sayfa içeriği..."></textarea>
                    <button onclick="seoMeta()" 
                        class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                        Meta Oluştur
                    </button>
                    <div id="seo-response" class="mt-4 hidden">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <p class="text-sm font-semibold text-green-900 mb-2">Meta Description:</p>
                            <p class="text-gray-700"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Müşteri Sorusu -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-orange-100">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6">
                    <div class="text-white">
                        <div class="text-4xl mb-3">💭</div>
                        <h3 class="text-xl font-bold">Müşteri Desteği</h3>
                        <p class="text-orange-100 text-sm mt-1">Otomatik yanıt</p>
                    </div>
                </div>
                <div class="p-6">
                    <textarea id="musteri-soru" rows="4" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Müşteri sorusu..."></textarea>
                    <button onclick="musteriSorusu()" 
                        class="mt-4 w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                        Yanıt Oluştur
                    </button>
                    <div id="musteri-response" class="mt-4 hidden">
                        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
                            <p class="text-sm font-semibold text-orange-900 mb-2">Önerilen Yanıt:</p>
                            <p class="text-gray-700 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Çeviri -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-indigo-100">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6">
                    <div class="text-white">
                        <div class="text-4xl mb-3">🌍</div>
                        <h3 class="text-xl font-bold">Çeviri</h3>
                        <p class="text-indigo-100 text-sm mt-1">Profesyonel çeviri</p>
                    </div>
                </div>
                <div class="p-6">
                    <textarea id="ceviri-icerik" rows="3" 
                        class="w-full border border-gray-300 rounded-lg p-3 mb-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Çevrilecek metin (Türkçe)..."></textarea>
                    <select id="ceviri-dil" 
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="en">İngilizce</option>
                        <option value="de">Almanca</option>
                        <option value="fr">Fransızca</option>
                        <option value="es">İspanyolca</option>
                        <option value="it">İtalyanca</option>
                        <option value="ar">Arapça</option>
                    </select>
                    <button onclick="ceviri()" 
                        class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                        Çevir
                    </button>
                    <div id="ceviri-response" class="mt-4 hidden">
                        <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded">
                            <p class="text-sm font-semibold text-indigo-900 mb-2">Çeviri:</p>
                            <p class="text-gray-700 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hata Analizi -->
            <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-red-100">
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-6">
                    <div class="text-white">
                        <div class="text-4xl mb-3">🔧</div>
                        <h3 class="text-xl font-bold">Hata Analizi</h3>
                        <p class="text-red-100 text-sm mt-1">Kod hatası çözümü</p>
                    </div>
                </div>
                <div class="p-6">
                    <textarea id="hata-metni" rows="4" 
                        class="w-full border border-gray-300 rounded-lg p-3 font-mono text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="Hata mesajını yapıştırın..."></textarea>
                    <button onclick="hataAnalizi()" 
                        class="mt-4 w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 shadow-md hover:shadow-lg">
                        Analiz Et
                    </button>
                    <div id="hata-response" class="mt-4 hidden">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <p class="text-sm font-semibold text-red-900 mb-2">Analiz ve Çözüm:</p>
                            <p class="text-gray-700 whitespace-pre-wrap text-sm"></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- API Test -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">🧪 API Bağlantı Testi</h3>
                <button onclick="apiTest()" 
                    class="bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                    Test Et
                </button>
            </div>
            <div id="test-response" class="hidden">
                <pre class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm overflow-x-auto"></pre>
            </div>
        </div>

    </div>
</div>

<script>
async function testChat() {
    const prompt = document.getElementById('chat-prompt').value;
    const responseDiv = document.getElementById('chat-response');
    
    if (!prompt) {
        alert('Lütfen bir mesaj girin!');
        return;
    }

    try {
        responseDiv.classList.remove('hidden');
        responseDiv.querySelector('p').textContent = 'Yanıt bekleniyor...';
        
        const response = await fetch('/super-admin/claude/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ prompt })
        });
        
        const data = await response.json();
        responseDiv.querySelector('p').textContent = data.response || data.error || 'Yanıt alınamadı';
    } catch (error) {
        responseDiv.querySelector('p').textContent = 'Hata: ' + error.message;
    }
}

async function urunAciklamasi() {
    const urunAdi = document.getElementById('urun-adi').value;
    const ozelliklerText = document.getElementById('urun-ozellikler').value;
    const ozellikler = ozelliklerText.split('\n').filter(o => o.trim());
    const responseDiv = document.getElementById('urun-response');
    
    if (!urunAdi) {
        alert('Lütfen ürün adı girin!');
        return;
    }

    try {
        responseDiv.classList.remove('hidden');
        responseDiv.querySelector('p').textContent = 'Açıklama oluşturuluyor...';
        
        const response = await fetch('/super-admin/claude/urun-aciklama', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ urun_adi: urunAdi, ozellikler })
        });
        
        const data = await response.json();
        responseDiv.querySelector('p').textContent = data.aciklama || 'Açıklama oluşturulamadı';
    } catch (error) {
        responseDiv.querySelector('p').textContent = 'Hata: ' + error.message;
    }
}

async function seoMeta() {
    const baslik = document.getElementById('seo-baslik').value;
    const icerik = document.getElementById('seo-icerik').value;
    const responseDiv = document.getElementById('seo-response');
    
    if (!baslik || !icerik) {
        alert('Lütfen başlık ve içerik girin!');
        return;
    }

    try {
        responseDiv.classList.remove('hidden');
        responseDiv.querySelector('p').textContent = 'Meta oluşturuluyor...';
        
        const response = await fetch('/super-admin/claude/seo-meta', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ baslik, icerik })
        });
        
        const data = await response.json();
        responseDiv.querySelector('p').textContent = data.meta || 'Meta oluşturulamadı';
    } catch (error) {
        responseDiv.querySelector('p').textContent = 'Hata: ' + error.message;
    }
}

async function musteriSorusu() {
    const soru = document.getElementById('musteri-soru').value;
    const responseDiv = document.getElementById('musteri-response');
    
    if (!soru) {
        alert('Lütfen bir soru girin!');
        return;
    }

    try {
        responseDiv.classList.remove('hidden');
        responseDiv.querySelector('p').textContent = 'Yanıt oluşturuluyor...';
        
        const response = await fetch('/super-admin/claude/musteri-sorusu', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ soru })
        });
        
        const data = await response.json();
        responseDiv.querySelector('p').textContent = data.yanit || 'Yanıt oluşturulamadı';
    } catch (error) {
        responseDiv.querySelector('p').textContent = 'Hata: ' + error.message;
    }
}

async function ceviri() {
    const icerik = document.getElementById('ceviri-icerik').value;
    const hedefDil = document.getElementById('ceviri-dil').value;
    const responseDiv = document.getElementById('ceviri-response');
    
    if (!icerik) {
        alert('Lütfen çevrilecek metni girin!');
        return;
    }

    try {
        responseDiv.classList.remove('hidden');
        responseDiv.querySelector('p').textContent = 'Çeviriliyor...';
        
        const response = await fetch('/super-admin/claude/ceviri', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ icerik, hedef_dil: hedefDil })
        });
        
        const data = await response.json();
        responseDiv.querySelector('p').textContent = data.ceviri || 'Çeviri yapılamadı';
    } catch (error) {
        responseDiv.querySelector('p').textContent = 'Hata: ' + error.message;
    }
}

async function hataAnalizi() {
    const hataMetni = document.getElementById('hata-metni').value;
    const responseDiv = document.getElementById('hata-response');
    
    if (!hataMetni) {
        alert('Lütfen hata mesajını girin!');
        return;
    }

    try {
        responseDiv.classList.remove('hidden');
        responseDiv.querySelector('p').textContent = 'Analiz ediliyor...';
        
        const response = await fetch('/super-admin/claude/hata-analiz', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ hata_metni: hataMetni })
        });
        
        const data = await response.json();
        responseDiv.querySelector('p').textContent = data.analiz || data.error || 'Analiz yapılamadı';
    } catch (error) {
        responseDiv.querySelector('p').textContent = 'Hata: ' + error.message;
    }
}

async function apiTest() {
    const responseDiv = document.getElementById('test-response');
    
    try {
        responseDiv.classList.remove('hidden');
        responseDiv.querySelector('pre').textContent = 'Test ediliyor...';
        
        const response = await fetch('/super-admin/claude/test');
        const data = await response.json();
        
        responseDiv.querySelector('pre').textContent = JSON.stringify(data, null, 2);
    } catch (error) {
        responseDiv.querySelector('pre').textContent = 'Hata: ' + error.message;
    }
}
</script>
@endsection







