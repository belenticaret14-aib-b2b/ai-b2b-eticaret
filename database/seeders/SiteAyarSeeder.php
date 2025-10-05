<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteAyarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ayarlar = [
            // Genel Ayarlar
            ['anahtar' => 'site_adi', 'deger' => 'AI B2B E-Ticaret', 'tip' => 'text', 'grup' => 'genel'],
            ['anahtar' => 'site_aciklama', 'deger' => 'Modern B2B/B2C E-Ticaret Platformu', 'tip' => 'text', 'grup' => 'genel'],
            ['anahtar' => 'site_logo', 'deger' => 'images/logo.png', 'tip' => 'image', 'grup' => 'genel'],
            ['anahtar' => 'site_favicon', 'deger' => 'images/favicon.ico', 'tip' => 'image', 'grup' => 'genel'],
            
            // İletişim Bilgileri
            ['anahtar' => 'iletisim_telefon', 'deger' => '+90 212 555 0123', 'tip' => 'text', 'grup' => 'iletisim'],
            ['anahtar' => 'iletisim_email', 'deger' => 'info@aib2b.com', 'tip' => 'text', 'grup' => 'iletisim'],
            ['anahtar' => 'iletisim_adres', 'deger' => 'Atatürk Mahallesi, E-Ticaret Sokak No:1, Şişli/İstanbul', 'tip' => 'text', 'grup' => 'iletisim'],
            ['anahtar' => 'iletisim_whatsapp', 'deger' => '+90 555 123 4567', 'tip' => 'text', 'grup' => 'iletisim'],
            
            // Sosyal Medya
            ['anahtar' => 'sosyal_facebook', 'deger' => 'https://facebook.com/aib2b', 'tip' => 'text', 'grup' => 'sosyal'],
            ['anahtar' => 'sosyal_instagram', 'deger' => 'https://instagram.com/aib2b', 'tip' => 'text', 'grup' => 'sosyal'],
            ['anahtar' => 'sosyal_twitter', 'deger' => 'https://twitter.com/aib2b', 'tip' => 'text', 'grup' => 'sosyal'],
            ['anahtar' => 'sosyal_linkedin', 'deger' => 'https://linkedin.com/company/aib2b', 'tip' => 'text', 'grup' => 'sosyal'],
            
            // SEO Ayarları
            ['anahtar' => 'meta_keywords', 'deger' => 'b2b, e-ticaret, toplu satış, bayi', 'tip' => 'text', 'grup' => 'seo'],
            ['anahtar' => 'google_analytics', 'deger' => 'G-XXXXXXXXXX', 'tip' => 'text', 'grup' => 'seo'],
            ['anahtar' => 'google_tag_manager', 'deger' => 'GTM-XXXXXXX', 'tip' => 'text', 'grup' => 'seo'],
            
            // E-Ticaret Ayarları
            ['anahtar' => 'varsayilan_para_birimi', 'deger' => 'TL', 'tip' => 'text', 'grup' => 'eticaret'],
            ['anahtar' => 'kargo_ucreti', 'deger' => '29.90', 'tip' => 'text', 'grup' => 'eticaret'],
            ['anahtar' => 'ucretsiz_kargo_limiti', 'deger' => '150', 'tip' => 'text', 'grup' => 'eticaret'],
            ['anahtar' => 'minimum_siparis_tutari', 'deger' => '50', 'tip' => 'text', 'grup' => 'eticaret'],
        ];

        foreach ($ayarlar as $ayar) {
            \App\Models\SiteAyar::firstOrCreate(
                ['anahtar' => $ayar['anahtar']],
                $ayar
            );
        }
    }
}
