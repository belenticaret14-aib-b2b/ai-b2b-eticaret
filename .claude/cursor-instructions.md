# Cursor - Şu An Ne Yapacaksın?

## 🎯 BUGÜNKÜ GÖREV (17 Ocak)

**Admin Dashboard yap**
```php
// AdminDashboardController oluştur
namespace App\Http\Controllers\Admin;

class AdminDashboardController extends Controller
{
    public function __construct(private AdminService $adminService) {}
    
    public function index()
    {
        $stats = $this->adminService->dashboardStats();
        return view('admin.dashboard', compact('stats'));
    }
}
```

**Kontrol:**
- [ ] Controller ✅
- [ ] Service ✅
- [ ] Route ✅
- [ ] View ✅
- [ ] Test ✅

**Bitti mi? Commit at:**
```bash
git commit -m "Admin dashboard @claude-review"
```

---

## 📋 SIRA (Sonra)
1. Admin bayi görüntüleme
2. Admin sipariş yönetimi
3. Admin raporlar

**Hatırla:**
✅ Türkçe method!
✅ Repository kullan!
✅ Lokal'e yaz!
