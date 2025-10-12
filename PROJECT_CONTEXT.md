# NetMarketiniz - Proje Bağlamı ve Geliştirme Kılavuzu

## 🎯 Proje Genel Bakış

**NetMarketiniz**, Laravel 12 tabanlı, çoklu platform entegrasyonuna sahip, B2B ve B2C satış yapabilen kapsamlı bir e-ticaret çözümüdür.

---

## 🏗️ Mimari Yapı

### Repository Pattern
```
app/Repositories/
├── Contracts/           # Interface'ler
│   ├── UrunRepositoryInterface.php
│   ├── MagazaRepositoryInterface.php
│   └── SiparisRepositoryInterface.php
└── Eloquent/           # Implementasyonlar
    ├── UrunRepository.php
    ├── MagazaRepository.php
    └── SiparisRepository.php
```

### Service Layer
```
app/Services/
├── UrunService.php              # Ürün business logic
├── MagazaService.php            # Mağaza yönetimi
├── SiparisService.php           # Sipariş işlemleri
├── PlatformEntegrasyonService.php  # API entegrasyonları
└── StokService.php              # Stok yönetimi
```

---

## 📦 Platform Entegrasyonları

### Trendyol
- API Endpoint: https://api.trendyol.com/
- Rate Limit: 100 req/min
- Kategori mapping gerekli
- Stok güncelleme: Gerçek zamanlı

### Hepsiburada
- API Endpoint: https://mpop.hepsiburada.com/
- Rate Limit: 60 req/min
- Ürün onay süreci var
- Toplu ürün aktarımı destekliyor

### N11
- API Endpoint: https://api.n11.com/
- Rate Limit: 120 req/min
- XML tabanlı entegrasyon
- Kategori listesi güncel tutulmalı

---

## 🔄 Senkronizasyon Mantığı

1. **Ürün Senkronizasyonu:** 30 dakikada bir (cron)
2. **Stok Senkronizasyonu:** 15 dakikada bir (cron)
3. **Sipariş Senkronizasyonu:** 5 dakikada bir (cron)
4. **Fiyat Güncelleme:** Manuel veya otomatik (ayarlanabilir)

---

## 💾 Veritabanı İlişkileri

### Ana Tablolar
- **kullanicilar:** Tüm kullanıcı tipleri (rol ile ayrım)
- **magazalar:** Platform mağazaları (ana_magaza field'ı önemli)
- **bayiler:** B2B müşteriler
- **urunler:** Ana ürün tablosu
- **siparisler:** Sipariş master
- **siparis_urunleri:** Sipariş detayları
- **senkron_loglar:** Platform senkron kayıtları

---

## 🎨 Frontend

- **Tailwind CSS:** Utility-first styling
- **Alpine.js:** Lightweight reactivity
- **Responsive:** Mobile-first approach
- **Admin Panel:** Modern dashboard

---

## 🔐 Güvenlik

- Sanctum API authentication
- Role-based access control (RBAC)
- CSRF protection
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade escaping)

---

## 🧪 Testing

```bash
# Unit tests
php artisan test --testsuite=Unit

# Feature tests
php artisan test --testsuite=Feature

# Specific test
php artisan test --filter=UrunTest
```

---

## 📝 Geliştirme Notları

### BURAYA CLAUDE.AI WEB'DEKİ ÖZEL BAĞLAMINIZI EKLEYİN
### Örnek:
### - "Ürün fiyatlarında KDV hesaplaması var, fiyat_kdv_dahil boolean field'ı kontrol et"
### - "Trendyol kategori eşleştirmesi trendyol_kategori_mapping tablosunda"
### - "Stok 0 olduğunda otomatik platformlarda pasife çekiliyor"
### - vs...

---

## 🚀 Deployment

### Production Checklist
- [ ] .env dosyası güncelle
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `php artisan migrate --force`
- [ ] Cron job'ları ayarla
- [ ] SSL sertifikası
- [ ] Backup stratejisi

---

## 📞 API Endpoints

### Public API
- `GET /api/v1/urunler` - Ürün listesi
- `GET /api/v1/urun/{id}` - Ürün detay
- `POST /api/v1/siparis` - Sipariş oluştur

### Admin API
- `POST /api/v1/admin/urun` - Ürün ekle
- `PUT /api/v1/admin/urun/{id}` - Ürün güncelle
- `POST /api/v1/admin/senkron` - Manuel senkron başlat

---

## 🔧 Troubleshooting

### Sık Karşılaşılan Sorunlar
1. **Platform API timeout:** Rate limit kontrolü yap
2. **Stok uyumsuzluğu:** Senkron log'larını kontrol et
3. **Kategori hatası:** Mapping tablosunu güncelle

---

**Son Güncelleme:** 2025-10-12
**Versiyon:** 1.0.0

