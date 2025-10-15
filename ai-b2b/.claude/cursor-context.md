# Cursor + Claude Context

## Hızlı Bilgi
**Proje:** NetMarketiniz B2B/B2C
**Owner:** BELEN (Excel VBA → Laravel)
**Durum:** 3. konuşma (önceki 2'de bağlam kaybı)
**Amaç:** Birlikte tamamlamak ("biz" kavramı)

## Stack
- Laravel 12
- PHP 8.2
- MySQL
- Repository pattern
- Service layer
- Türkçe naming

## Önemli Dosyalar
```
app/
├── Services/
│   ├── ClaudeService.php (AI entegre)
│   └── ClaudeContextService.php (Bağlam yönetimi)
├── Repositories/
└── Models/

.claude/
├── context.json (TAM BAĞLAM)
├── decisions.md (Kararlar)
└── cursor-context.md (Bu dosya)
```

## Son Durum
✅ Laravel kurulu
✅ ClaudeService hazır
✅ GitHub repo var
⏳ Auth sistemi
⏳ Admin panel

## Cursor Kullanım
1. @-mention ile `.claude/context.json` ekle
2. Türkçe method isimleri kullan
3. Repository pattern uygula
4. Detaylı açıklama yap

## Hatırla
- "Kolay gelsin" de (özel!)
- Panel-pano dikkat
- Excel arka planı var
- Bağlam önemli
