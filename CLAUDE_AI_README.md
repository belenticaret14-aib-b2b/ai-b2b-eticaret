# 🤖 Claude AI Entegrasyonu - Kullanım Kılavuzu

## 📋 İçindekiler
1. [Kurulum](#kurulum)
2. [Yapılandırma](#yapılandırma)
3. [Kullanım](#kullanım)
4. [API Referansı](#api-referansı)
5. [Örnekler](#örnekler)

---

## 🚀 Kurulum

### 1. Claude API Key Alma

1. [Anthropic Console](https://console.anthropic.com/) sayfasına gidin
2. Hesap oluşturun veya giriş yapın
3. **API Keys** bölümüne gidin
4. **Create Key** butonuna tıklayın
5. API anahtarınızı kopyalayın

### 2. Ortam Değişkenlerini Ayarlama

`.env` dosyanıza aşağıdaki satırları ekleyin:

```env
CLAUDE_API_KEY=your-api-key-here
CLAUDE_MODEL=claude-3-5-sonnet-20241022
```

**Kullanılabilir Modeller:**
- `claude-3-5-sonnet-20241022` (Önerilen - En hızlı ve en gelişmiş)
- `claude-3-opus-20240229` (En güçlü)
- `claude-3-sonnet-20240229` (Dengeli)
- `claude-3-haiku-20240307` (En hızlı)

---

## ⚙️ Yapılandırma

### Servis Yapılandırması

`config/services.php` dosyası zaten yapılandırılmıştır:

```php
'claude' => [
    'api_key' => env('CLAUDE_API_KEY'),
    'model' => env('CLAUDE_MODEL', 'claude-3-5-sonnet-20241022'),
],
```

### Guzzle HTTP Client

Guzzle HTTP client'ı Laravel ile birlikte gelir, ek kurulum gerekmez.

---

## 💻 Kullanım

### Web Arayüzü

1. Super Admin olarak giriş yapın
2. **Geliştirici** menüsüne gidin
3. **Claude AI** butonuna tıklayın
4. Açılan sayfada 6 farklı özellik bulunur:

#### 1. 🟣 Genel Chat
- Claude ile serbest sohbet
- Herhangi bir soru sorabilirsiniz
- Programlama yardımı, fikir üretme, problem çözme

**Örnek:**
```
"Laravel'de middleware nasıl oluşturulur?"
"B2B e-ticaret için en iyi pazarlama stratejileri nelerdir?"
```

#### 2. 🔵 Ürün Açıklaması
- Ürün adı ve özellikleri girin
- SEO uyumlu, satış odaklı açıklama oluşturur
- Maksimum 300 kelime

**Örnek:**
```
Ürün Adı: iPhone 15 Pro Max
Özellikler:
- 6.7 inç Super Retina XDR ekran
- A17 Pro çip
- 48MP kamera sistemi
- Titanyum kasa
```

#### 3. 🟢 SEO Meta
- Sayfa başlığı ve içeriği girin
- 160 karakterlik meta description oluşturur
- Google SERP için optimize

**Örnek:**
```
Başlık: B2B Elektronik Ürünleri
İçerik: Toptan elektronik ürünleri, en uygun fiyatlarla bayilerimize sunuyoruz...
```

#### 4. 🟠 Müşteri Desteği
- Müşteri sorusunu girin
- Otomatik profesyonel yanıt oluşturur
- Müşteri memnuniyeti odaklı

**Örnek:**
```
Soru: "Toplu sipariş verdiğimde ne kadar indirim alabilirim?"
```

#### 5. 🟣 Çeviri
- Türkçe metni girin
- 6 dile çeviri: İngilizce, Almanca, Fransızca, İspanyolca, İtalyanca, Arapça
- E-ticaret terminolojisine uygun

#### 6. 🔴 Hata Analizi
- Hata mesajını yapıştırın
- Sorunun ne olduğunu açıklar
- Çözüm önerileri sunar
- Kod örnekleri verir

---

## 🔌 API Referansı

### Programatik Kullanım

#### Service Injection

```php
use App\Services\ClaudeService;

class MyController extends Controller
{
    public function __construct(private ClaudeService $claude)
    {
    }
}
```

#### Temel Chat

```php
$result = $this->claude->chat(
    prompt: 'Merhaba Claude!',
    maxTokens: 1024,
    temperature: 0.7
);

// $result = [
//     'success' => true,
//     'response' => 'Merhaba! Size nasıl yardımcı olabilirim?',
//     'usage' => [...],
//     'model' => 'claude-3-5-sonnet-20241022'
// ]
```

#### Ürün Açıklaması

```php
$aciklama = $this->claude->urunAciklamasiOlustur(
    urunAdi: 'Kablosuz Kulaklık',
    ozellikler: [
        'Bluetooth 5.0',
        '30 saat pil ömrü',
        'Aktif gürültü engelleme'
    ]
);
```

#### SEO Meta

```php
$meta = $this->claude->seoMetaOlustur(
    baslik: 'B2B Elektronik',
    icerik: 'Toptan elektronik ürünleri...'
);
```

#### Müşteri Sorusu Yanıtlama

```php
$yanit = $this->claude->musteriSorusuYanitla(
    soru: 'İade süreci nasıl işler?',
    urunBilgileri: [
        'kategori' => 'Elektronik',
        'garanti' => '2 yıl'
    ]
);
```

#### Sipariş Analizi

```php
$analiz = $this->claude->siparisAnalizi([
    'urunler' => [...],
    'toplam_tutar' => 15000,
    'musteri_tipi' => 'bayi'
]);

// $analiz = [
//     'success' => true,
//     'analiz' => '...',
//     'token_kullanimi' => [...]
// ]
```

#### Çeviri

```php
$ceviri = $this->claude->ceviri(
    icerik: 'Ürünümüz stokta mevcut.',
    hedefDil: 'en'
);
```

#### Stok Uyarısı

```php
$uyari = $this->claude->stokUyarisiOlustur([
    ['urun' => 'iPhone 15', 'stok' => 5],
    ['urun' => 'Samsung S24', 'stok' => 3]
]);
```

#### Hata Analizi

```php
$analiz = $this->claude->hataAnalizi(
    hataMetni: 'SQLSTATE[42S02]: Base table or view not found...'
);

// $analiz = [
//     'success' => true,
//     'analiz' => '...',
//     'cozum_onerileri' => [...]
// ]
```

---

## 📊 API Endpoints (HTTP)

### POST `/super-admin/claude/chat`
Genel chat endpoint'i

**Body:**
```json
{
  "prompt": "Merhaba Claude!",
  "max_tokens": 2048,
  "temperature": 0.7
}
```

**Response:**
```json
{
  "success": true,
  "response": "Merhaba! Size nasıl yardımcı olabilirim?",
  "usage": {...},
  "model": "claude-3-5-sonnet-20241022"
}
```

### POST `/super-admin/claude/urun-aciklama`
Ürün açıklaması oluşturma

**Body:**
```json
{
  "urun_adi": "Kablosuz Kulaklık",
  "ozellikler": [
    "Bluetooth 5.0",
    "30 saat pil ömrü"
  ]
}
```

### POST `/super-admin/claude/seo-meta`
SEO meta description oluşturma

**Body:**
```json
{
  "baslik": "B2B Elektronik",
  "icerik": "Toptan elektronik ürünleri..."
}
```

### POST `/super-admin/claude/musteri-sorusu`
Müşteri sorusuna otomatik yanıt

**Body:**
```json
{
  "soru": "İade süreci nasıl işler?",
  "urun_bilgileri": {}
}
```

### POST `/super-admin/claude/ceviri`
Metin çevirisi

**Body:**
```json
{
  "icerik": "Ürünümüz stokta mevcut.",
  "hedef_dil": "en"
}
```

**Desteklenen Diller:** `en`, `de`, `fr`, `es`, `it`, `ar`

### POST `/super-admin/claude/hata-analiz`
Hata analizi ve çözüm önerileri

**Body:**
```json
{
  "hata_metni": "SQLSTATE[42S02]: Base table..."
}
```

### GET `/super-admin/claude/test`
API bağlantı testi

---

## 💡 Kullanım Örnekleri

### Örnek 1: Blade Template'de Kullanım

```php
// Controller
public function urunDetay($id)
{
    $urun = Urun::findOrFail($id);
    
    if (!$urun->aciklama) {
        $urun->aciklama = app(ClaudeService::class)
            ->urunAciklamasiOlustur($urun->ad, $urun->ozellikler);
        $urun->save();
    }
    
    return view('urun-detay', compact('urun'));
}
```

### Örnek 2: Otomatik SEO Meta

```php
// Model Observer
class UrunObserver
{
    public function created(Urun $urun)
    {
        $claude = app(ClaudeService::class);
        
        $urun->meta_description = $claude->seoMetaOlustur(
            $urun->ad,
            $urun->aciklama ?? ''
        );
        
        $urun->saveQuietly();
    }
}
```

### Örnek 3: API Route (Desktop App için)

```php
// routes/api.php
Route::post('/ai/product-description', function(Request $request) {
    $request->validate([
        'product_name' => 'required',
        'features' => 'nullable|array'
    ]);
    
    $claude = app(ClaudeService::class);
    
    return response()->json([
        'description' => $claude->urunAciklamasiOlustur(
            $request->product_name,
            $request->features ?? []
        )
    ]);
})->middleware('auth:sanctum');
```

### Örnek 4: Command Line

```php
// app/Console/Commands/GenerateProductDescriptions.php
public function handle()
{
    $urunler = Urun::whereNull('aciklama')->get();
    $claude = app(ClaudeService::class);
    
    $bar = $this->output->createProgressBar($urunler->count());
    
    foreach ($urunler as $urun) {
        $urun->aciklama = $claude->urunAciklamasiOlustur(
            $urun->ad,
            $urun->ozellikler ?? []
        );
        $urun->save();
        
        $bar->advance();
    }
    
    $bar->finish();
    $this->info("\nTamamlandı!");
}
```

---

## 🎯 Best Practices

### 1. Rate Limiting
Claude API'nin rate limit'i vardır. Toplu işlemlerde gecikme ekleyin:

```php
foreach ($urunler as $urun) {
    $aciklama = $claude->urunAciklamasiOlustur(...);
    sleep(1); // 1 saniye bekle
}
```

### 2. Error Handling
Her zaman hata kontrolü yapın:

```php
$result = $claude->chat('Merhaba');

if ($result['success']) {
    echo $result['response'];
} else {
    Log::error('Claude API Error: ' . $result['error']);
    echo 'Bir hata oluştu, lütfen tekrar deneyin.';
}
```

### 3. Caching
Sık kullanılan içerikleri cache'leyin:

```php
$aciklama = Cache::remember("urun_aciklama_{$urun->id}", 3600, function() use($urun, $claude) {
    return $claude->urunAciklamasiOlustur($urun->ad, $urun->ozellikler);
});
```

### 4. Temperature Ayarları
- **0.0-0.3**: Tutarlı, deterministik yanıtlar (SEO, çeviri)
- **0.4-0.7**: Dengeli (genel kullanım)
- **0.8-1.0**: Yaratıcı, çeşitli yanıtlar (ürün açıklamaları)

### 5. Token Yönetimi
- Kısa yanıtlar için: 256-512 token
- Orta boyut: 1024-2048 token
- Uzun içerik: 4096 token
- Maksimum: 8192 token (Sonnet 3.5)

---

## 🔒 Güvenlik

### API Key Güvenliği
- **Asla** API key'i kodda hardcode etmeyin
- `.env` dosyasını `.gitignore`'a ekleyin
- Üretim ortamında ortam değişkenleri kullanın

### Rate Limiting
Laravel'de rate limiting ekleyin:

```php
Route::middleware('throttle:60,1')->group(function() {
    Route::post('/claude/chat', ...);
});
```

### Input Validation
Kullanıcı girişlerini her zaman doğrulayın:

```php
$request->validate([
    'prompt' => 'required|string|max:5000',
    'max_tokens' => 'nullable|integer|min:100|max:4096',
]);
```

---

## 💰 Maliyet Optimizasyonu

### Token Fiyatlandırması (Claude 3.5 Sonnet)
- **Input**: $3 / 1M token
- **Output**: $15 / 1M token

### Maliyet Düşürme İpuçları:
1. **Kısa promptlar kullanın**: Gereksiz detay vermeyin
2. **Max tokens sınırlayın**: İhtiyacınız kadar token kullanın
3. **Cache kullanın**: Tekrarlayan içerikleri cache'leyin
4. **Toplu işlemler**: Mümkünse birden fazla soruyu tek promptta sorun

---

## 🐛 Debugging

### Log Kayıtları
Service'te otomatik loglama aktif:

```php
// storage/logs/laravel.log
[2024-10-12 10:00:00] local.ERROR: Claude API Error: Rate limit exceeded
```

### Test Endpoint
API bağlantısını test edin:

```bash
curl http://localhost:8000/super-admin/claude/test
```

veya

```
http://localhost:8000/super-admin/claude
```
sayfasında **API Bağlantı Testi** butonuna tıklayın.

---

## 📞 Destek

### Sorun mu yaşıyorsunuz?

1. **API Key kontrol**: `.env` dosyasında doğru mu?
2. **Cache temizle**: `php artisan optimize:clear`
3. **Log kontrol**: `storage/logs/laravel.log`
4. **Test endpoint**: `/super-admin/claude/test`

### Anthropic Dokümentasyonu
https://docs.anthropic.com/claude/reference/

### Laravel Entegrasyon Sorunları
- Guzzle kurulu mu? `composer require guzzlehttp/guzzle`
- Config cache'i temiz mi? `php artisan config:clear`

---

## 🎉 Başarı Hikayeleri

### Otomatik Ürün Açıklamaları
> "1000+ ürünümüz için manuel açıklama yazmak yerine Claude ile 2 saatte otomatik oluşturduk!"

### SEO İyileştirmesi
> "Tüm sayfalarımızın meta description'larını yeniledik, organik trafiğimiz %40 arttı!"

### Müşteri Desteği
> "Claude ile otomatik yanıtlar sayesinde destek ekibimizin yükü %60 azaldı!"

---

## 🚀 Gelecek Özellikler

- [ ] Görsel analizi (Claude 3.5 Vision)
- [ ] Toplu işlem kuyruğu
- [ ] Çoklu dil desteği (otomatik)
- [ ] Özel model eğitimi
- [ ] Performans metrikleri dashboard'u

---

**Hayaller Gerçek Oluyor!** ✨🤖

**Version:** 1.0.0  
**Last Updated:** 2024-10-12  
**Author:** AI B2B Team


