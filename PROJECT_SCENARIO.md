# NetMarketiniz AI-B2B Platform - Kullanıcı Senaryosu

## 🎯 **PLATFORM MİMARİSİ**

### **👑 SÜPER ADMIN (Ana Kontrol Merkezi)**
- **Tam Yetki:** Projenin tamamına müdahale edebilir
- **Menü Yönetimi:** Panelleri aktif/pasif yapabilir
- **Ana Mağaza:** E-ticaret sitesinin kalbi
- **XML/Excel Import:** Sadece süper admin yetkisi
- **Ürün Kontrolü:** Bayilere tahsis edilecek ürünleri belirler

### **🤖 BAYİLER (Özel Bayi Sistemi)**
- **Bayi Paneli:** Süper adminin verdiği yetkilerle
- **Tahsis Edilen Ürünler:** Ana mağazadan seçilen ürünler
- **Satış Yetkisi:** Bayi panelinden satış yapabilir
- **Sevk İsteği:** Ürünleri adresine gönderim isteyebilir
- **Platform Entegrasyonu:** XML/Excel export yapabilir
- **Kendi Ürünleri:** Platformlara (Trendyol, Hepsiburada, N11) gönderebilir

### **👥 MÜŞTERİLER (Çoklu Mağaza Sistemi)**
- **Üyelik:** Ana mağaza + bayi mağazalarına üye olabilir
- **Sipariş:** Her iki mağazadan da sipariş verebilir
- **Ödeme:** Tam e-ticaret deneyimi
- **Sevkiyat:** Çoklu metod desteği (Kargo, PTT, MNG)

### **🌐 MAĞAZA TANITIM (Marketing)**
- **Bayi Başvuru Linkleri:** Yeni bayi kayıtları
- **Giriş Linkleri:** Mevcut bayi girişleri
- **Tanıtım Sayfaları:** Platform tanıtımı
- **Ana Sayfa:** Tanıtım ve e-ticaret karışımı

## 🔄 **İŞ AKIŞI**

### **1. Süper Admin İşlemleri:**
```
XML/Excel Import → Ürün Kontrol → Bayilere Tahsis → Menü Yönetimi
```

### **2. Bayi İşlemleri:**
```
Giriş → Tahsis Edilen Ürünleri Gör → Satış/Sevk → Platform Export
```

### **3. Müşteri İşlemleri:**
```
Üyelik → Mağaza Seç → Ürün Seç → Sipariş → Ödeme → Sevkiyat
```

## 🎨 **TASARIM PRENSİPLERİ**

- **Modern UI/UX:** Tailwind CSS + Alpine.js
- **Responsive Design:** Mobil uyumlu
- **Dark/Light Mode:** Kullanıcı tercihi
- **Dashboard Cards:** Görsel veri sunumu
- **Real-time Updates:** Canlı veri güncellemeleri
- **Intuitive Navigation:** Kolay menü sistemi

## 🚀 **TEKNİK GEREKSİNİMLER**

- **Laravel 12:** Backend framework
- **SQLite/MySQL:** Veritabanı
- **Repository Pattern:** Temiz kod mimarisi
- **Service Layer:** Business logic
- **API Endpoints:** Desktop uygulama entegrasyonu
- **Claude AI:** Otomatik içerik üretimi
- **Platform APIs:** Trendyol, Hepsiburada, N11 entegrasyonu

## 📊 **VERİTABANI İLİŞKİLERİ**

```
Süper Admin → Mağazalar → Bayiler → Ürünler → Siparişler → Müşteriler
```

## 🔐 **GÜVENLİK**

- **Role-based Access:** Kullanıcı yetkileri
- **API Authentication:** Desktop uygulama güvenliği
- **Webhook Verification:** Platform entegrasyon güvenliği
- **Rate Limiting:** API koruması
- **CSRF Protection:** Form güvenliği




