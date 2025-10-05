<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SayfaIcerikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sayfalar = [
            [
                'baslik' => 'Hakkımızda',
                'slug' => 'hakkimizda',
                'icerik' => '<div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl font-bold mb-6">Hakkımızda</h1>
                    <div class="prose prose-lg">
                        <p>AI B2B E-Ticaret platformu, modern teknoloji ile geleneksel ticaretin buluştuğu yenilikçi bir çözümdür. 2024 yılında kurulan şirketimiz, B2B ve B2C segmentlerinde faaliyet gösteren işletmelere kapsamlı e-ticaret çözümleri sunmaktadır.</p>
                        
                        <h2>Misyonumuz</h2>
                        <p>Türkiye\'nin önde gelen e-ticaret platformlarından biri olmak ve müşterilerimize en kaliteli hizmeti sunmak.</p>
                        
                        <h2>Vizyonumuz</h2>
                        <p>Teknoloji odaklı çözümlerle ticaretin geleceğini şekillendirmek ve dijital dönüşümde öncü olmak.</p>
                        
                        <h2>Değerlerimiz</h2>
                        <ul>
                            <li>Müşteri memnuniyeti</li>
                            <li>Kaliteli hizmet</li>
                            <li>Teknolojik yenilik</li>
                            <li>Güvenilirlik</li>
                            <li>Sürdürülebilirlik</li>
                        </ul>
                        
                        <h2>Platform Özellikleri</h2>
                        <ul>
                            <li>Çoklu marketplace entegrasyonu (Trendyol, Hepsiburada, N11, Amazon)</li>
                            <li>B2B bayilere özel fiyatlandırma</li>
                            <li>AI destekli ürün önerileri</li>
                            <li>Gerçek zamanlı stok senkronizasyonu</li>
                            <li>Kapsamlı API desteği</li>
                        </ul>
                    </div>
                </div>',
                'meta_baslik' => 'Hakkımızda - AI B2B E-Ticaret',
                'meta_aciklama' => 'AI B2B E-Ticaret platformu hakkında bilgi edinin. Modern teknoloji ile ticaretin buluştuğu yenilikçi çözümlerimizi keşfedin.',
                'durum' => true,
                'sira' => 1,
                'tip' => 'sayfa'
            ],
            [
                'baslik' => 'İletişim',
                'slug' => 'iletisim',
                'icerik' => '<div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl font-bold mb-6">İletişim</h1>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-xl font-semibold mb-4">İletişim Bilgileri</h2>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <span>info@aib2b.com</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                    </svg>
                                    <span>+90 212 555 0123</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Atatürk Mahallesi, E-Ticaret Sokak No:1<br>Şişli/İstanbul</span>
                                </div>
                            </div>
                            
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold mb-3">Çalışma Saatleri</h3>
                                <div class="space-y-2 text-sm">
                                    <p><strong>Pazartesi - Cuma:</strong> 09:00 - 18:00</p>
                                    <p><strong>Cumartesi:</strong> 09:00 - 17:00</p>
                                    <p><strong>Pazar:</strong> Kapalı</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Bize Ulaşın</h2>
                            <form method="POST" action="/iletisim" class="space-y-4">
                                <input type="hidden" name="_token" value="">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Ad Soyad</label>
                                    <input type="text" name="ad_soyad" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">E-posta</label>
                                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Telefon</label>
                                    <input type="tel" name="telefon" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Mesaj</label>
                                    <textarea name="mesaj" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                                    Mesaj Gönder
                                </button>
                            </form>
                        </div>
                    </div>
                </div>',
                'meta_baslik' => 'İletişim - AI B2B E-Ticaret',
                'meta_aciklama' => 'AI B2B E-Ticaret ile iletişime geçin. Telefon, e-posta ve adres bilgilerimize ulaşabilir, bizimle iletişim kurabilirsiniz.',
                'durum' => true,
                'sira' => 2,
                'tip' => 'sayfa'
            ],
            [
                'baslik' => 'Gizlilik Politikası',
                'slug' => 'gizlilik-politikasi',
                'icerik' => '<div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl font-bold mb-6">Gizlilik Politikası</h1>
                    <div class="prose prose-lg">
                        <p><strong>Son güncellenme:</strong> '.date('d.m.Y').'</p>
                        
                        <h2>1. Veri Sorumlusu</h2>
                        <p>AI B2B E-Ticaret olarak kişisel verilerinizin korunması konusunda azami hassasiyet göstermekteyiz.</p>
                        
                        <h2>2. Toplanan Veriler</h2>
                        <ul>
                            <li>Kimlik bilgileri (ad, soyad)</li>
                            <li>İletişim bilgileri (e-posta, telefon)</li>
                            <li>Sipariş ve ödeme bilgileri</li>
                            <li>Çerezler ve kullanım verileri</li>
                        </ul>
                        
                        <h2>3. Verilerin Kullanım Amacı</h2>
                        <ul>
                            <li>Hizmet sunumu ve müşteri desteği</li>
                            <li>Sipariş takibi ve kargo işlemleri</li>
                            <li>Pazarlama ve kampanya bilgilendirmeleri</li>
                            <li>Yasal yükümlülüklerin yerine getirilmesi</li>
                        </ul>
                        
                        <h2>4. Veri Güvenliği</h2>
                        <p>Kişisel verileriniz SSL şifreleme ile korunmakta ve güvenli sunucularda saklanmaktadır.</p>
                        
                        <h2>5. Üçüncü Taraflarla Paylaşım</h2>
                        <p>Verileriniz sadece hizmet sunumu için gerekli olan durumlarda güvenilir iş ortaklarımızla paylaşılır.</p>
                        
                        <h2>6. Haklarınız</h2>
                        <p>KVKK kapsamında verilerinize erişim, düzeltme, silme ve aktarım haklarınız bulunmaktadır.</p>
                    </div>
                </div>',
                'meta_baslik' => 'Gizlilik Politikası - AI B2B E-Ticaret',
                'meta_aciklama' => 'AI B2B E-Ticaret gizlilik politikası. Kişisel verilerinizin nasıl korunduğu ve kullanıldığı hakkında detaylı bilgi.',
                'durum' => true,
                'sira' => 3,
                'tip' => 'sayfa'
            ],
            [
                'baslik' => 'Kullanım Şartları',
                'slug' => 'kullanim-sartlari',
                'icerik' => '<div class="max-w-4xl mx-auto">
                    <h1 class="text-3xl font-bold mb-6">Kullanım Şartları</h1>
                    <div class="prose prose-lg">
                        <p><strong>Son güncellenme:</strong> '.date('d.m.Y').'</p>
                        
                        <h2>1. Genel Hükümler</h2>
                        <p>Bu kullanım şartları AI B2B E-Ticaret platformunu kullanan tüm kullanıcılar için geçerlidir.</p>
                        
                        <h2>2. Hesap Oluşturma</h2>
                        <ul>
                            <li>Doğru ve güncel bilgiler sağlamalısınız</li>
                            <li>Hesap güvenliğinden siz sorumlusunuz</li>
                            <li>18 yaşından büyük olmalısınız</li>
                        </ul>
                        
                        <h2>3. Sipariş ve Ödeme</h2>
                        <ul>
                            <li>Tüm fiyatlar KDV dahildir</li>
                            <li>Ödeme onayı sonrası sipariş kesinleşir</li>
                            <li>Stok durumuna göre sipariş iptal edilebilir</li>
                        </ul>
                        
                        <h2>4. Teslimat</h2>
                        <ul>
                            <li>Kargo süresi 1-3 iş günüdür</li>
                            <li>150 TL üzeri siparişlerde kargo ücretsizdir</li>
                            <li>Hasarlı ürün teslimi kabul etmeyin</li>
                        </ul>
                        
                        <h2>5. İade ve Değişim</h2>
                        <ul>
                            <li>14 gün içinde iade hakkınız bulunur</li>
                            <li>Ürün orijinal ambalajında olmalıdır</li>
                            <li>Kişisel hijyen ürünleri iade edilemez</li>
                        </ul>
                        
                        <h2>6. Yasak Kullanımlar</h2>
                        <ul>
                            <li>Platformu zararlı amaçlarla kullanmak</li>
                            <li>Sahte bilgi ve belge kullanmak</li>
                            <li>Telif hakkı ihlali yapmak</li>
                        </ul>
                        
                        <h2>7. Sorumluluk Sınırları</h2>
                        <p>Platform üzerinden satılan ürünlerin kalitesi ve uygunluğundan satıcılar sorumludur.</p>
                    </div>
                </div>',
                'meta_baslik' => 'Kullanım Şartları - AI B2B E-Ticaret',
                'meta_aciklama' => 'AI B2B E-Ticaret kullanım şartları. Platform kullanım kuralları, sipariş koşulları ve yasal bilgiler.',
                'durum' => true,
                'sira' => 4,
                'tip' => 'sayfa'
            ]
        ];

        foreach ($sayfalar as $sayfa) {
            \App\Models\SayfaIcerik::firstOrCreate(
                ['slug' => $sayfa['slug']],
                $sayfa
            );
        }
    }
}
