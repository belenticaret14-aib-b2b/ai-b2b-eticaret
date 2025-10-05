# AI B2B E-Ticaret Platformu

Modern Laravel 12 tabanlı kapsamlı B2B/B2C e-ticaret platformu. Çoklu platform entegrasyonu, AI destekli ürün yönetimi ve gelişmiş API altyapısı ile.

## 🚀 Özellikler

### 🛍️ E-Ticaret Özellikleri
- **B2C Vitrin**: Genel müşteriler için modern vitrin sistemi
- **B2B Panel**: Bayiler için özel fiyatlandırma ve toplu sipariş
- **Session-tabanlı Sepet**: Hızlı ve güvenli sepet yönetimi
- **Gelişmiş Ürün Yönetimi**: Kategori, marka, özellik yönetimi
- **Stok ve Fiyat Takibi**: Otomatik stok kontrolü ve fiyat güncellemeleri

### 🔗 Platform Entegrasyonları
- **Trendyol API**: Tam entegrasyon (ürün, stok, fiyat, sipariş)
- **Hepsiburada API**: Kapsamlı marketplace entegrasyonu
- **N11 API**: Ürün ve sipariş senkronizasyonu
- **Amazon Marketplace**: Global e-ticaret entegrasyonu
- **XML Feed'ler**: Platform-bağımsız veri paylaşımı
- **Webhook Desteği**: Gerçek zamanlı senkronizasyon

### 🤖 AI ve Otomasyon
- **AI Ürün Önerisi**: Akıllı ürün öneri sistemi
- **Barkod Entegrasyonu**: Otomatik ürün tanımlama
- **Otomatik Senkronizasyon**: Zamanlanmış platform senkronizasyonu
- **Akıllı Stok Yönetimi**: Kritik stok seviyesi takibi

### 📊 B2B Özellikleri
- **Bayi Yönetimi**: Çoklu bayi desteği ve yetkilendirme
- **Özel Fiyatlandırma**: Bayi-specific fiyat listeleri
- **Toplu Sipariş**: API destekli bulk order sistemi
- **Kredi Limiti**: Bayi kredi takibi ve vade yönetimi
- **Cari Hesap**: Detaylı finansal raporlama

### 🔌 API Altyapısı
- **RESTful API**: Kapsamlı v1 API
- **Laravel Sanctum**: Modern token authentication
- **Rate Limiting**: Platform-specific API sınırları
- **Webhook Support**: Gerçek zamanlı event handling
- **XML/JSON Export**: Esnek veri formatları

## 🛠️ Teknoloji Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: TailwindCSS, AlpineJS, Blade Templates
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Sanctum (API Tokens)
- **Build Tools**: Vite, NPM
- **Cache**: Redis (opsiyonel)
- **Queue**: Database/Redis queue support

## 📋 Gereksinimler

- PHP 8.2 veya üzeri
- Composer
- Node.js 18+ ve NPM
- MySQL 8.0+ veya SQLite
- Apache/Nginx web server

## ⚡ Kurulum

### 1. Projeyi Klonlayın
```bash
git clone https://github.com/your-repo/ai-b2b.git
cd ai-b2b
```

### 2. Bağımlılıkları Yükleyin
```bash
composer install
npm install
```

### 3. Çevre Değişkenlerini Ayarlayın
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Veritabanını Kurun
```bash
# SQLite için (development)
touch database/database.sqlite

# MySQL için .env dosyasında:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=ai_b2b
# DB_USERNAME=root
# DB_PASSWORD=

php artisan migrate:fresh --seed
```

### 5. Asset'leri Derleyin
```bash
npm run dev   # Development için
npm run build # Production için
```

### 6. Sunucuyu Başlatın
```bash
php artisan serve
```

## 🔐 API Authentication

### Token Alma
```bash
POST /api/auth/login
{
    "email": "admin@example.com",
    "password": "password"
}
```

### API Kullanımı
```bash
# Header'da token kullanın
Authorization: Bearer {your-token}

# Örnek API çağrıları
GET /api/v1/urunler
POST /api/v1/sepet/ekle
GET /api/v1/b2b/urunler  # B2B endpoints
```

## 🌐 Platform Entegrasyonları

### Trendyol Kurulumu
```php
// .env dosyasında
TRENDYOL_API_KEY=your_api_key
TRENDYOL_API_SECRET=your_api_secret

// Admin panelinden mağaza ekleyin
POST /api/v1/admin/magazalar
{
    "ad": "Trendyol Mağazam",
    "platform": "trendyol",
    "api_anahtari": "your_api_key",
    "api_gizli_anahtar": "your_api_secret"
}
```

### XML Feed'ler
```bash
# Ürün feed'i
GET /api/v1/xml/urunler?platform=trendyol

# Stok feed'i  
GET /api/v1/xml/stok?platform=hepsiburada

# Fiyat feed'i
GET /api/v1/xml/fiyat?platform=n11
```

## 📚 API Dokümantasyonu

### B2C Endpoints
```bash
GET    /api/v1/urunler                 # Ürün listesi
GET    /api/v1/urun/{id}               # Ürün detayı
GET    /api/v1/urunler/arama?q=term    # Ürün arama
POST   /api/v1/sepet/ekle              # Sepete ekle
GET    /api/v1/sepet                   # Sepet içeriği
PUT    /api/v1/sepet/guncelle          # Sepet güncelle
DELETE /api/v1/sepet/sil               # Sepetten sil
```

### B2B Endpoints
```bash
GET  /api/v1/b2b/urunler               # Bayi fiyatlı ürünler
POST /api/v1/b2b/siparis/toplu         # Toplu sipariş
GET  /api/v1/b2b/profil                # Bayi profili
GET  /api/v1/b2b/cari-hesap            # Cari hesap
```

### Admin Endpoints
```bash
POST   /api/v1/admin/urunler                    # Ürün oluştur
PUT    /api/v1/admin/urun/{id}                  # Ürün güncelle
POST   /api/v1/admin/urunler/toplu-guncelleme   # Toplu güncelleme
POST   /api/v1/admin/magaza/{id}/urun-esitle    # Platform ürün eşitle
POST   /api/v1/admin/xml/import                 # XML import
```

## 🔧 Geliştirme

### Code Style
- PSR-12 PHP standartları
- Türkçe field isimleri: `ad`, `fiyat`, `stok`
- RESTful API conventions
- Laravel best practices

### Testing
```bash
# Unit testler
php artisan test

# Feature testler
php artisan test --testsuite=Feature
```

### Debugging
```bash
# Log dosyalarını izleyin
tail -f storage/logs/laravel.log

# API debugging için
php artisan tinker
```

## 📊 Monitoring ve Logs

### Senkronizasyon Logları
```bash
# Platform senkronizasyon durumu
GET /api/v1/admin/senkron-loglar

# Hata logları
tail -f storage/logs/platform-sync.log
```

### Performance Monitoring
- Cache kullanımı (Redis/File)
- Database query optimization
- API response time tracking

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit edin (`git commit -m 'Add amazing feature'`)
4. Push edin (`git push origin feature/amazing-feature`)
5. Pull Request açın

## 📄 Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasına bakın.

## 🆘 Destek

- 📧 E-posta: support@example.com
- 📖 Dokümantasyon: [Wiki](https://github.com/your-repo/ai-b2b/wiki)
- 🐛 Bug Report: [Issues](https://github.com/your-repo/ai-b2b/issues)

## 🏗️ Roadmap

- [ ] Mobil uygulama API'leri
- [ ] GraphQL desteği
- [ ] Gerçek zamanlı chat desteği
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Cryptocurrency payment integration

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
