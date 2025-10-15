# Proje Kararları ve Notlar

## 📋 Mimari Kararlar

### 1. Repository Pattern ✅
**Karar:** Her model için Repository oluşturulacak
**Sebep:** 
- Veri erişim mantığını ayırmak
- Test edilebilirliği artırmak
- SOLID prensipleri

**Örnek:**
```php
// app/Repositories/UrunRepository.php
class UrunRepository extends BaseRepository
{
    public function tumunuGetir() { }
    public function idyeGoreGetir($id) { }
    public function kategoriyeGoreGetir($kategoriId) { }
}
```

---

### 2. Service Layer ✅
**Karar:** İş mantığı Service katmanında
**Sebep:**
- Controller'ları ince tutmak
- İş mantığını yeniden kullanabilmek
- Transaction yönetimi

**Örnek:**
```php
// app/Services/SiparisService.php
class SiparisService
{
    public function olustur(array $data)
    {
        DB::beginTransaction();
        try {
            $siparis = $this->repository->kaydet($data);
            $this->stokService->azalt($data['urunler']);
            DB::commit();
            return $siparis;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
```

---

### 3. Türkçe İsimlendirme ✅
**Karar:** Tüm method, değişken ve route isimleri Türkçe
**Sebep:**
- BELEN için daha anlaşılır
- Excel VBA geçmişi ile uyumlu
- Ekip için daha doğal

**Örnekler:**
```php
// ✅ DOĞRU
public function urunleriGetir()
public function siparisOlustur()
$toplam_fiyat = 0;

// ❌ YANLIŞ
public function getProducts()
public function createOrder()
$total_price = 0;
```

---

### 4. Panel → Pano ✅
**Karar:** Admin paneli için "pano" kelimesi kullanılacak
**Sebep:** BELEN'in tercihi

```php
// Routes
Route::prefix('pano')->group(...);

// Views
resources/views/pano/anasayfa.blade.php

// URL
https://netmarketiniz.com/pano
```

---

## 🔧 Teknik Kararlar

### 5. Claude Entegrasyonu ✅
**Karar:** ClaudeService + ClaudeContextService
**Sebep:**
- AI destekli özellikler
- Ürün açıklaması oluşturma
- Müşteri yanıtları için öneri

**Kullanım Alanları:**
- Ürün açıklaması otomatik oluşturma
- SEO metni yazma
- Müşteri mesajlarına yanıt önerisi
- Sipariş özeti oluşturma

---

### 6. Context Yönetimi ✅
**Karar:** .claude klasöründe JSON bazlı context
**Sebep:**
- Konuşmalar arası bağlam kaybı yaşandı
- Cursor ile entegrasyon
- Otomatik senkronizasyon

**Dosyalar:**
```
.claude/
├── context.json        → Tam proje durumu
├── decisions.md        → Bu dosya
└── cursor-context.md   → Hızlı özet
```

---

### 7. Validation Strategy ✅
**Karar:** Form Request sınıfları kullanılacak
**Sebep:**
- Controller'ları temiz tutmak
- Validation mantığını ayırmak
- Yeniden kullanılabilirlik

```bash
php artisan make:request UrunKaydetRequest
php artisan make:request SiparisOlusturRequest
```

---

## 🎨 UI/UX Kararları

### 8. Blade + Alpine.js ✅
**Karar:** Frontend için Blade templating + Alpine.js
**Sebep:**
- Laravel ile native entegrasyon
- Basit interaktivite için Alpine yeterli
- Vue/React gibi ağır framework'e gerek yok

---

### 9. Tailwind CSS ✅
**Karar:** Styling için Tailwind CSS
**Sebep:**
- Hızlı geliştirme
- Modern görünüm
- Özelleştirilebilirlik

---

## 📊 Veritabanı Kararları

### 10. Soft Deletes ✅
**Karar:** Önemli tablolarda soft delete kullanılacak
**Sebep:**
- Veri güvenliği
- Geri alma imkanı
- Audit trail

**Tablolar:**
- urunler
- siparisler
- bayiler
- kullanicilar

---

### 11. Türkçe Tablo İsimleri ✅
**Karar:** Tablo isimleri Türkçe çoğul
**Sebep:**
- Kod tutarlılığı
- BELEN için anlaşılır

**Örnekler:**
```
urunler (not products)
siparisler (not orders)
bayiler (not dealers)
kategoriler (not categories)
```

---

## 🚀 Deployment Kararları

### 12. Context Auto-Sync ✅
**Karar:** Her deployment'ta context sync
**Sebep:**
- Cursor güncel kalır
- Bağlam kaybı önlenir

**composer.json:**
```json
{
    "scripts": {
        "post-update-cmd": [
            "@php artisan cursor:sync-context"
        ]
    }
}
```

---

## 📝 Kod Standartları

### 13. Comment Standard ✅
**Karar:** Türkçe comment + PHPDoc
**Sebep:**
- BELEN için okunabilirlik
- IDE desteği için PHPDoc

```php
/**
 * Ürünleri kategoriye göre getirir
 * 
 * @param int $kategoriId Kategori ID
 * @return Collection Ürün koleksiyonu
 */
public function kategoriyeGoreGetir(int $kategoriId): Collection
{
    // Aktif ürünleri filtrele
    return $this->model
        ->where('kategori_id', $kategoriId)
        ->where('aktif', true)
        ->get();
}
```

---

### 14. Error Handling ✅
**Karar:** Try-catch + Log
**Sebep:**
- Debug kolaylığı
- Kullanıcı dostu hata mesajları

```php
try {
    $result = $this->service->process();
} catch (\Exception $e) {
    Log::error('İşlem hatası', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);
    
    return back()->with('error', 'İşlem sırasında hata oluştu.');
}
```

---

## 🔐 Güvenlik Kararları

### 15. API Rate Limiting ✅
**Karar:** Claude API için rate limiting
**Sebep:**
- Maliyet kontrolü
- API limitlerini aşmamak

```php
RateLimiter::for('claude', function (Request $request) {
    return Limit::perMinute(10);
});
```

---

## 📈 İleri Tarihli Kararlar

### 16. Cache Strategy ⏳
**Karar:** Redis kullanılacak
**Ne Zaman:** Performans sorunları görülürse
**Neler Cache'lenecek:**
- Ürün listeleri
- Kategori ağacı
- Claude yanıtları (duplicate'ler için)

---

### 17. Queue System ⏳
**Karar:** Laravel Queue kullanılacak
**Ne Zaman:** Ağır işlemler arttığında
**Kullanım Alanları:**
- Toplu e-posta gönderimi
- Excel export (büyük veri)
- Claude API çağrıları (batch)

---

## 🎯 Özel Notlar

### BELEN için Hatırlatmalar
1. ✅ Her zaman "Kolay gelsin" de
2. ✅ Panel değil PANO de
3. ✅ Detaylı açıklama yap
4. ✅ Excel analojileri kullan
5. ✅ Context'i koru

### Cursor Kullanımı
1. ✅ @ mention ile .cursorrules ekle
2. ✅ Her prompt'ta context kontrol et
3. ✅ Düzenli olarak sync yap

---

**Son Güncelleme:** 2025-10-15
**Güncelleyen:** Claude (AI Asistan)
**Durum:** Aktif Geliştirme ✅
