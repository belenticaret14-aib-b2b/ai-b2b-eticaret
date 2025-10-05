// Admin Panel JS İşlevleri

// AI Ürün Önerisi
async function aiUrunOnerisi() {
    const button = event.target;
    const originalText = button.textContent;
    
    button.disabled = true;
    button.textContent = 'Yükleniyor...';
    
    try {
        const response = await fetch('/admin/ai/urun-onerisi', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // AI önerilerini modal veya alert ile göster
            let oneriMesaj = "🤖 AI Ürün Önerileri:\n\n";
            data.data.forEach((oneri, index) => {
                oneriMesaj += `${index + 1}. ${oneri.kategori} - ${oneri.urun_adi}\n`;
                oneriMesaj += `   Önerilen Fiyat: ${oneri.tahmini_fiyat}₺\n`;
                oneriMesaj += `   Talep Düzeyi: ${oneri.talep_seviyesi}\n\n`;
            });
            
            alert(oneriMesaj);
        } else {
            alert('❌ AI önerisi alınamadı: ' + data.message);
        }
    } catch (error) {
        console.error('AI Öneri Hatası:', error);
        alert('❌ Bir hata oluştu: ' + error.message);
    } finally {
        button.disabled = false;
        button.textContent = originalText;
    }
}

// Barkod Fetch İşlevi
async function barkodFetch() {
    const barkod = prompt('🔍 Barkod numarasını girin:');
    
    if (!barkod) return;
    
    const button = event.target;
    const originalText = button.textContent;
    
    button.disabled = true;
    button.textContent = 'Arıyor...';
    
    try {
        const response = await fetch('/admin/barkod/fetch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ barkod: barkod })
        });
        
        const data = await response.json();
        
        if (data.success) {
            const urun = data.data;
            let urunBilgi = `📦 Ürün Bulundu!\n\n`;
            urunBilgi += `📝 Ad: ${urun.ad}\n`;
            urunBilgi += `🏷️ Marka: ${urun.marka}\n`;
            urunBilgi += `📂 Kategori: ${urun.kategori}\n`;
            urunBilgi += `💰 Fiyat: ${urun.fiyat}₺\n`;
            urunBilgi += `📊 Stok: ${urun.stok}\n\n`;
            urunBilgi += `Bu ürünü sisteme eklemek ister misiniz?`;
            
            if (confirm(urunBilgi)) {
                // Ürün ekleme sayfasına yönlendir (query parametreleri ile)
                const params = new URLSearchParams({
                    barkod: barkod,
                    ad: urun.ad,
                    marka: urun.marka,
                    kategori: urun.kategori,
                    fiyat: urun.fiyat,
                    stok: urun.stok
                });
                
                window.location.href = `/admin/urun/create?${params.toString()}`;
            }
        } else {
            alert('❌ Barkod bulunamadı: ' + data.message);
        }
    } catch (error) {
        console.error('Barkod Hatası:', error);
        alert('❌ Bir hata oluştu: ' + error.message);
    } finally {
        button.disabled = false;
        button.textContent = originalText;
    }
}

// Bildirim sistemi
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transition-all duration-300 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animasyon
    setTimeout(() => {
        notification.style.transform = 'translateX(-20px)';
    }, 100);
    
    // Otomatik kaldır
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Sayfa yüklendiğinde
document.addEventListener('DOMContentLoaded', function() {
    // CSRF token meta tagı ekle
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = window.Laravel?.csrfToken || '';
        document.head.appendChild(meta);
    }
});