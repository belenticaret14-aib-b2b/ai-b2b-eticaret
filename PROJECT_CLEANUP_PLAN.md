# NetMarketiniz Proje Temizlik Planı

## 🎯 **AMAÇ**
Proje birkaç kez elden geçtiği için linkler ve dosya yolları karışık. Ana işleyiş belli oldu, gereksiz yenilikler kaldırılıp eksikler tamamlanacak.

## 📊 **MEVCUT DURUM**
- **194 route** var (çok fazla)
- **Çifte route'lar** mevcut
- **Eski/çalışmayan** linkler var
- **Dosya yolları** karışık

## 🔧 **TEMİZLİK STRATEJİSİ**

### **1. ROUTE TEMİZLİĞİ**
#### **Korunacak Route'lar:**
```
✅ Ana Sayfa: / (vitrin.index)
✅ Süper Admin: /super-admin/dashboard (modern)
✅ Bayi Panel: /bayi/panel (modern)
✅ Müşteri Panel: /musteri/panel (modern)
✅ Admin Panel: /admin/panel (klasik)
✅ Auth: /login, /register, /logout
✅ API: /api/v1/* (tümü)
✅ Webhook: /api/webhook/*
✅ Sayfalar: /hakkimizda, /iletisim, /gizlilik-politikasi
```

#### **Kaldırılacak Route'lar:**
```
❌ /vitrin (çifte route)
❌ /sepet (çifte route)
❌ /vitrin/sepet, /vitrin/arama, /vitrin/odeme
❌ /dealer-admin/* (eski sistem)
❌ /store-admin/* (eski sistem)
❌ /b2b, /b2b-login (karışık)
❌ /super-admin/* (eski view'lar)
```

### **2. DOSYA TEMİZLİĞİ**
#### **Korunacak Dosyalar:**
```
✅ resources/views/super-admin/modern-dashboard.blade.php
✅ resources/views/bayi/modern-dashboard.blade.php
✅ resources/views/musteri/modern-dashboard.blade.php
✅ resources/views/admin/* (klasik admin)
✅ resources/views/auth/*
✅ resources/views/layouts/*
✅ resources/views/components/*
```

#### **Kaldırılacak Dosyalar:**
```
❌ resources/views/super-admin/* (eski view'lar)
❌ resources/views/bayi/panel.blade.php (eski)
❌ resources/views/dealer-admin/*
❌ resources/views/store-admin/*
❌ resources/views/vitrin/* (eski)
```

### **3. CONTROLLER TEMİZLİĞİ**
#### **Korunacak Controller'lar:**
```
✅ App\Http\Controllers\SuperAdmin\DashboardController
✅ App\Http\Controllers\Admin\*
✅ App\Http\Controllers\Auth\*
✅ App\Http\Controllers\Api\V1\*
✅ App\Http\Controllers\VitrinController (ana sayfa için)
✅ App\Http\Controllers\SayfaController
```

#### **Kaldırılacak Controller'lar:**
```
❌ App\Http\Controllers\DealerAdmin\*
❌ App\Http\Controllers\StoreAdmin\*
❌ App\Http\Controllers\SuperAdmin\* (eski)
```

## 🎯 **ANA İŞLEYİŞ**

### **Kullanıcı Akışı:**
1. **Ana Sayfa** → VitrinController@index
2. **Süper Admin** → modern-dashboard
3. **Bayi** → modern-dashboard  
4. **Müşteri** → modern-dashboard
5. **Admin** → klasik admin panel

### **API Akışı:**
1. **Desktop API** → /api/v1/desktop/*
2. **B2B API** → /api/v1/b2b/*
3. **Admin API** → /api/v1/admin/*
4. **Public API** → /api/v1/*

## 📝 **UYGULAMA SIRASI**

1. **Route temizliği** (routes/web.php)
2. **Eski view dosyalarını kaldır**
3. **Eski controller'ları kaldır**
4. **Route test**
5. **Eksikleri tamamla**

## ⚠️ **DİKKAT**
- Ana proje kodlarına dokunmayacağız
- Gereksiz yenilikler eklemeyeceğiz
- Sadece temizlik ve eksik tamamlama yapacağız




