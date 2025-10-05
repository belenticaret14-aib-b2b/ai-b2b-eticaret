# AI B2B E-Ticaret Platformu - Copilot Talimatları

## Proje Mimarisi

Bu proje, Laravel 12 tabanlı kapsamlı bir B2B/B2C e-ticaret platformudur. Ana bileşenler:
- **B2C Vitrin**: Genel müşteriler için session-tabanlı sepet sistemi
- **B2B Panel**: Bayiler için özel fiyatlandırma ve toplu sipariş 
- **Admin Panel**: Ürün/mağaza yönetimi, AI entegrasyonu, çoklu platform senkronizasyonu
- **API Entegrasyonları**: Trendyol, Hepsiburada, N11, Amazon vb. platformlarla XML/API senkronizasyonu

## Önemli Türkçe Konvensiyonlar

### Model ve Tablo İsimlendirme
- Tüm model isimleri ve field'lar Türkçe: `Kullanici`, `Urun`, `Magaza`, `Bayi`, `Sepet`, `Kategori`, `Marka`
- Tablo isimleri çoğul: `kullanicilar`, `urunler`, `magazalar`, `bayiler`, `sepetler`, `kategoriler`
- Primary key her zaman `id`, foreign key'ler `{model}_id` formatında (örn: `kullanici_id`, `kategori_id`)

### Temel Model İlişkileri
```php
// Kullanici -> Bayi (1:1)
// Kullanici.rol = 'admin'|'bayi'|'musteri' 
// Urun -> Kategori, Marka (BelongsTo)
// Magaza <-> Urun (Many-to-Many) via magaza_urun pivot
// Siparis -> SiparisUrunu (HasMany)
```

## Kimlik Doğrulama ve Yetkilendirme

### Çok Rollü Auth + API Tokens
- Ana model: `Kullanici` (`app/Models/Kullanici.php`) - Laravel Sanctum destekli
- `rol` field'ı ile admin/bayi/müşteri ayrımı
- B2B login: `/b2b-login` (sadece admin ve bayi)
- API Routes: `/api/v1/*` (Sanctum token auth)
- Middleware: `AdminMiddleware`, `BayiMiddleware`

### Route Grupları
```php
// Public: vitrin, sepet (session-based)
// API B2C: /api/v1/* (public + auth:sanctum)
// API B2B: /api/v1/b2b/* (middleware: auth:sanctum, bayi)
// API Admin: /api/v1/admin/* (middleware: auth:sanctum, admin)
```

## Sepet Sistemi

**SESSION-TABANLI** (B2C): Veritabanı değil, Laravel session kullanılır
- Controller: `Api\V1\SepetController`
- Session yapısı: `['items' => [...], 'total' => 0, 'adet_toplami' => 0]`
- Her item: `id, ad, sku, fiyat, adet, gorsel, stok`
- Otomatik stok kontrolü ve fiyat güncelleme

## Platform Entegrasyonları

### Mağaza Platformları
- **Desteklenen**: Trendyol, Hepsiburada, N11, Amazon, Pazarama, GittiGidiyor
- **Service**: `App\Services\PlatformEntegrasyonService`
- **Config**: `config/eticaret.php` - platform-specific ayarlar
- **Senkronizasyon**: Ürün, stok, fiyat, sipariş webhooks

### XML/API Feeds
- **XML Controller**: `Api\V1\XmlController`
- **Feed Types**: `/api/v1/xml/{urunler|stok|fiyat}?platform=trendyol`
- **Import/Export**: Admin panel üzerinden XML import/export
- **Cache**: Platform-specific cache süreleri

### Webhook Handlers
```php
// Platform webhook endpoints
POST /api/webhook/trendyol
POST /api/webhook/hepsiburada  
POST /api/webhook/n11
POST /api/webhook/amazon
```

## Özel Entegrasyonlar

### AI Sistemi
- `Admin\AIController`: Ürün önerisi endpoint'i (`/admin/ai/urun-onerisi`)
- Şu an mock data, gerçek AI entegrasyonu için hazır yapı

### Barkod Sistemi  
- `Admin\BarkodController`: Barkod ile ürün çekme (`/admin/barkod/fetch`)
- Mock data ile çalışır, dış API entegrasyonu için hazır

### B2B Özellikler
- Bayi-specific fiyatlandırma (`BayiFiyat` model)
- Toplu sipariş API'leri
- Kredi limiti ve vade takibi
- Özel indirim oranları

## API Yapısı

### RESTful API Design
```php
// Public B2C APIs
GET /api/v1/urunler - Ürün listesi (filtreleme, sayfalama)
GET /api/v1/urun/{id} - Ürün detayı
GET /api/v1/urunler/arama?q=arama - Ürün arama
POST /api/v1/sepet/ekle - Sepete ürün ekle

// B2B APIs  
GET /api/v1/b2b/urunler - Bayi fiyatlı ürünler
POST /api/v1/b2b/siparis/toplu - Toplu sipariş
GET /api/v1/b2b/cari-hesap - Bayi cari hesap

// Admin APIs
POST /api/v1/admin/urunler - Ürün oluştur
PUT /api/v1/admin/urun/{id} - Ürün güncelle
POST /api/v1/admin/urunler/toplu-guncelleme - Toplu güncelleme
```

## Development Workflow

### Migration ve Seeding
```bash
php artisan migrate:fresh --seed  # Tam reset + test data
php artisan migrate                # Sadece yeni migration'lar
```

### Asset Build  
```bash
npm run dev    # Development (Vite + TailwindCSS)
npm run build  # Production build
```

### API Testing
- Sanctum token authentication
- Postman/Insomnia collection hazır
- Request validation Türkçe error messages

## Kod Yazma Kuralları

1. **Field isimleri Türkçe**: `ad`, `fiyat`, `stok`, `aciklama`, `kategori_id`
2. **API Response format**:
   ```php
   ['success' => true, 'data' => $data, 'message' => 'İşlem başarılı']
   ['success' => false, 'message' => 'Hata mesajı', 'errors' => []]
   ```
3. **Route isimleri**: `api.urun.index`, `admin.magaza.senkronize`
4. **Controller metodları Türkçe**: `ekle()`, `guncelle()`, `sil()`, `senkronize()`
5. **Session-based sepet korunmalı** - API'de de session kullan
6. **Platform entegrasyonları**: `PlatformEntegrasyonService` üzerinden
7. **Error handling**: Try-catch blokları ve detaylı loglama

## Dosya Yapısı

### Önemli Dizinler
- `app/Http/Controllers/Api/V1/`: API controller'ları
- `app/Services/`: Business logic (PlatformEntegrasyonService)
- `app/Models/`: Türkçe model isimleri, ilişkiler
- `config/eticaret.php`: Platform-specific ayarlar
- `database/migrations/`: Enhanced tabular structure
- `routes/api.php`: Kapsamlı API route tanımları

### Frontend Stack
- **TailwindCSS + AlpineJS**: Responsive, modern UI
- **Blade Templates**: Server-side rendering
- **Vite**: Modern asset bundling
- **Laravel Sanctum**: SPA authentication

Bu talimatları takip ederek modern, ölçeklenebilir ve çoklu platform destekli B2B/B2C e-ticaret sistemi geliştirilebilir.