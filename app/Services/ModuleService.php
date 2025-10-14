<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class ModuleService
{
    protected array $modules = [
        'odeme-yonetimi' => [
            'name' => 'Ödeme Yönetimi',
            'description' => 'Kredi kartı, havale, kapıda ödeme seçenekleri',
            'icon' => 'fas fa-credit-card',
            'color' => 'green',
            'active' => true,
            'permissions' => ['super_admin', 'admin'],
            'routes' => [
                'admin.odeme.index' => 'Ödeme Yöntemleri',
                'admin.odeme.create' => 'Yeni Ödeme Yöntemi',
                'admin.odeme.ayarlar' => 'Ödeme Ayarları',
            ],
            'settings' => [
                'odeme_komisyon_orani' => 'Komisyon Oranı (%)',
                'odeme_minimum_tutar' => 'Minimum Tutar',
                'odeme_maksimum_tutar' => 'Maksimum Tutar',
            ]
        ],
        'bayi-yonetimi' => [
            'name' => 'Bayi Yönetimi',
            'description' => 'Bayi ekleme, yetkilendirme, performans takibi',
            'icon' => 'fas fa-handshake',
            'color' => 'blue',
            'active' => true,
            'permissions' => ['super_admin', 'admin'],
            'routes' => [
                'admin.bayiler.index' => 'Bayi Listesi',
                'admin.bayiler.create' => 'Yeni Bayi',
                'admin.bayiler.performans' => 'Performans Raporları',
            ],
            'settings' => [
                'bayi_komisyon_orani' => 'Bayi Komisyon Oranı (%)',
                'bayi_minimum_siparis' => 'Minimum Sipariş Tutarı',
                'bayi_aktif_et' => 'Bayi Sistemini Aktif Et',
            ]
        ],
        'xml-excel-import-export' => [
            'name' => 'XML/Excel İşlemleri',
            'description' => 'Ürün, kategori, stok import/export işlemleri',
            'icon' => 'fas fa-file-excel',
            'color' => 'purple',
            'active' => true,
            'permissions' => ['super_admin', 'admin'],
            'routes' => [
                'admin.xml.import' => 'XML/Excel Import',
                'admin.xml.export' => 'XML/Excel Export',
                'admin.xml.template' => 'Template İndir',
            ],
            'settings' => [
                'xml_otomatik_senkron' => 'Otomatik Senkronizasyon',
                'xml_backup_olustur' => 'İmport Öncesi Backup',
                'xml_hata_durumunda_dur' => 'Hata Durumunda Durdur',
            ]
        ],
        'claude-ai' => [
            'name' => 'Claude AI Entegrasyonu',
            'description' => 'Yapay zeka destekli ürün açıklamaları ve öneriler',
            'icon' => 'fas fa-robot',
            'color' => 'red',
            'active' => true,
            'permissions' => ['super_admin'],
            'routes' => [
                'super-admin.claude' => 'Claude AI Panel',
                'super-admin.claude.test' => 'AI Test',
                'super-admin.claude.ayarlar' => 'AI Ayarları',
            ],
            'settings' => [
                'claude_api_key' => 'Claude API Key',
                'claude_model' => 'AI Model',
                'claude_mock_mode' => 'Mock Mode (Test)',
            ]
        ],
        'bot-yonetimi' => [
            'name' => 'Bot Yönetimi',
            'description' => 'Müşteri destek botları ve otomasyon',
            'icon' => 'fas fa-comments',
            'color' => 'yellow',
            'active' => true,
            'permissions' => ['super_admin'],
            'routes' => [
                'super-admin.bot-ayarlari' => 'Bot Ayarları',
                'super-admin.bot-test' => 'Bot Test',
                'super-admin.bot-istatistikler' => 'Bot İstatistikleri',
            ],
            'settings' => [
                'bot_aktif_et' => 'Bot Sistemini Aktif Et',
                'bot_yanit_suresi' => 'Yanıt Süresi (saniye)',
                'bot_otomatik_yanit' => 'Otomatik Yanıt',
            ]
        ],
        'platform-entegrasyonlari' => [
            'name' => 'Platform Entegrasyonları',
            'description' => 'Trendyol, Hepsiburada, N11 entegrasyonları',
            'icon' => 'fas fa-exchange-alt',
            'color' => 'indigo',
            'active' => true,
            'permissions' => ['super_admin', 'admin'],
            'routes' => [
                'admin.platform.trendyol' => 'Trendyol Entegrasyonu',
                'admin.platform.hepsiburada' => 'Hepsiburada Entegrasyonu',
                'admin.platform.n11' => 'N11 Entegrasyonu',
            ],
            'settings' => [
                'platform_otomatik_senkron' => 'Otomatik Senkronizasyon',
                'platform_stok_uyarisi' => 'Stok Uyarısı',
                'platform_fiyat_guncelleme' => 'Otomatik Fiyat Güncelleme',
            ]
        ],
        'raporlama-analitik' => [
            'name' => 'Raporlama & Analitik',
            'description' => 'Detaylı satış, stok ve performans raporları',
            'icon' => 'fas fa-chart-line',
            'color' => 'teal',
            'active' => true,
            'permissions' => ['super_admin', 'admin'],
            'routes' => [
                'admin.raporlar.satis' => 'Satış Raporları',
                'admin.raporlar.stok' => 'Stok Raporları',
                'admin.raporlar.bayi' => 'Bayi Raporları',
            ],
            'settings' => [
                'rapor_otomatik_mail' => 'Otomatik Mail Raporu',
                'rapor_detay_seviye' => 'Rapor Detay Seviyesi',
                'rapor_gecmis_tut' => 'Rapor Geçmişi Tut',
            ]
        ]
    ];

    public function __construct()
    {
        $this->loadModuleSettings();
    }

    /**
     * Tüm modülleri al
     */
    public function getAllModules(): array
    {
        return $this->modules;
    }

    /**
     * Aktif modülleri al
     */
    public function getActiveModules(): array
    {
        return array_filter($this->modules, function($module) {
            return $module['active'] ?? false;
        });
    }

    /**
     * Modülü aktif/pasif yap
     */
    public function toggleModule(string $moduleKey, bool $active): bool
    {
        if (!isset($this->modules[$moduleKey])) {
            return false;
        }

        $this->modules[$moduleKey]['active'] = $active;
        $this->saveModuleSettings();
        
        return true;
    }

    /**
     * Kullanıcı rolüne göre modülleri al
     */
    public function getModulesForRole(string $role): array
    {
        return array_filter($this->modules, function($module) use ($role) {
            return $module['active'] && in_array($role, $module['permissions']);
        });
    }

    /**
     * Modül ayarlarını al
     */
    public function getModuleSettings(string $moduleKey): array
    {
        return $this->modules[$moduleKey]['settings'] ?? [];
    }

    /**
     * Modül ayarını güncelle
     */
    public function updateModuleSetting(string $moduleKey, string $settingKey, $value): bool
    {
        if (!isset($this->modules[$moduleKey]['settings'][$settingKey])) {
            return false;
        }

        // Database'e kaydet (gelecekte implement edilecek)
        // Şimdilik session'a kaydet
        session(["module_setting_{$moduleKey}_{$settingKey}" => $value]);
        
        return true;
    }

    /**
     * Modül ayarlarını yükle
     */
    protected function loadModuleSettings(): void
    {
        // Database'den yükle (gelecekte implement edilecek)
        // Şimdilik cache'den yükle
        $savedSettings = Cache::get('module_settings', []);
        
        foreach ($savedSettings as $moduleKey => $settings) {
            if (isset($this->modules[$moduleKey])) {
                foreach ($settings as $settingKey => $value) {
                    $this->modules[$moduleKey]['settings'][$settingKey] = $value;
                }
            }
        }
    }

    /**
     * Modül ayarlarını kaydet
     */
    protected function saveModuleSettings(): void
    {
        $settings = [];
        foreach ($this->modules as $key => $module) {
            $settings[$key] = $module['settings'] ?? [];
        }
        
        Cache::put('module_settings', $settings, 3600);
    }

    /**
     * Modül route'larını al
     */
    public function getModuleRoutes(string $moduleKey): array
    {
        return $this->modules[$moduleKey]['routes'] ?? [];
    }

    /**
     * Yeni modül ekle (Süper Admin için)
     */
    public function addModule(string $key, array $config): bool
    {
        if (isset($this->modules[$key])) {
            return false;
        }

        $this->modules[$key] = array_merge([
            'active' => false,
            'permissions' => ['super_admin'],
            'routes' => [],
            'settings' => []
        ], $config);

        $this->saveModuleSettings();
        return true;
    }

    /**
     * Modül sil (Süper Admin için)
     */
    public function removeModule(string $key): bool
    {
        if (!isset($this->modules[$key]) || $key === 'core') {
            return false;
        }

        unset($this->modules[$key]);
        $this->saveModuleSettings();
        return true;
    }

    /**
     * Modül istatistikleri
     */
    public function getModuleStats(): array
    {
        $total = count($this->modules);
        $active = count($this->getActiveModules());
        
        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $total - $active,
            'usage_percentage' => $total > 0 ? round(($active / $total) * 100, 2) : 0
        ];
    }
}

