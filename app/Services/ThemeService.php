<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class ThemeService
{
    protected string $currentTheme;
    protected array $availableThemes = [
        'v1' => 'V1 Güzel Tasarım',
        'modern' => 'Modern Tema',
        'classic' => 'Klasik Tema',
        'default' => 'Varsayılan Tema',
    ];

    public function __construct()
    {
        $this->currentTheme = config('theme.active', 'default');
        $this->registerThemePaths();
    }

    /**
     * Aktif temayı al
     */
    public function getCurrentTheme(): string
    {
        return $this->currentTheme;
    }

    /**
     * Temayı değiştir
     */
    public function setTheme(string $theme): bool
    {
        if (!array_key_exists($theme, $this->availableThemes)) {
            return false;
        }

        $this->currentTheme = $theme;
        $this->registerThemePaths();
        
        // Session'a kaydet
        session(['active_theme' => $theme]);
        
        return true;
    }

    /**
     * Mevcut temaları al
     */
    public function getAvailableThemes(): array
    {
        return $this->availableThemes;
    }

    /**
     * Tema yollarını kaydet
     */
    protected function registerThemePaths(): void
    {
        $themePath = resource_path("themes/{$this->currentTheme}/views");
        
        if (File::exists($themePath)) {
            // View path'leri temaya göre ayarla
            $viewPaths = View::getFinder()->getPaths();
            
            // Tema path'ini en üste ekle
            array_unshift($viewPaths, $themePath);
            
            // View finder'ı yeniden ayarla
            View::getFinder()->setPaths($viewPaths);
        }
    }

    /**
     * Tema dosyasının varlığını kontrol et
     */
    public function themeViewExists(string $view): bool
    {
        $themePath = resource_path("themes/{$this->currentTheme}/views/{$view}.blade.php");
        return File::exists($themePath);
    }

    /**
     * Tema asset path'i al
     */
    public function getThemeAssetPath(string $asset = ''): string
    {
        return "/themes/{$this->currentTheme}/assets/{$asset}";
    }

    /**
     * Tema layout path'i al
     */
    public function getThemeLayoutPath(): string
    {
        return "themes::{$this->currentTheme}.layouts.app";
    }

    /**
     * Tema bilgilerini al
     */
    public function getThemeInfo(): array
    {
        $themePath = resource_path("themes/{$this->currentTheme}");
        $infoFile = "{$themePath}/theme.json";
        
        if (File::exists($infoFile)) {
            $info = json_decode(File::get($infoFile), true);
            return $info ?? [];
        }
        
        return [
            'name' => $this->availableThemes[$this->currentTheme] ?? 'Bilinmeyen Tema',
            'version' => '1.0.0',
            'description' => 'Tema açıklaması',
            'author' => 'NetMarketiniz',
        ];
    }

    /**
     * Tema preview'ı al
     */
    public function getThemePreview(): string
    {
        return $this->getThemeAssetPath('preview.jpg');
    }

    /**
     * Tema CSS dosyalarını al
     */
    public function getThemeStylesheets(): array
    {
        $cssPath = public_path("themes/{$this->currentTheme}/css");
        $stylesheets = [];
        
        if (File::exists($cssPath)) {
            $files = File::glob("{$cssPath}/*.css");
            foreach ($files as $file) {
                $stylesheets[] = $this->getThemeAssetPath('css/' . basename($file));
            }
        }
        
        return $stylesheets;
    }

    /**
     * Tema JS dosyalarını al
     */
    public function getThemeScripts(): array
    {
        $jsPath = public_path("themes/{$this->currentTheme}/js");
        $scripts = [];
        
        if (File::exists($jsPath)) {
            $files = File::glob("{$jsPath}/*.js");
            foreach ($files as $file) {
                $scripts[] = $this->getThemeAssetPath('js/' . basename($file));
            }
        }
        
        return $scripts;
    }

    /**
     * Yeni tema ekle (Süper Admin için)
     */
    public function addTheme(string $key, array $config): bool
    {
        if (isset($this->availableThemes[$key])) {
            return false;
        }

        $this->availableThemes[$key] = $config['name'] ?? 'Yeni Tema';
        
        // Tema klasörünü oluştur
        $themePath = resource_path("themes/{$key}/views");
        if (!File::exists($themePath)) {
            File::makeDirectory($themePath, 0755, true);
        }

        // Tema config dosyası oluştur
        $configFile = resource_path("themes/{$key}/theme.json");
        if (!File::exists($configFile)) {
            File::put($configFile, json_encode(array_merge([
                'name' => $config['name'] ?? 'Yeni Tema',
                'version' => '1.0.0',
                'description' => 'Yeni tema açıklaması',
                'author' => 'NetMarketiniz',
                'preview' => 'preview.jpg',
            ], $config), JSON_PRETTY_PRINT));
        }

        return true;
    }

    /**
     * Tema özelleştirme
     */
    public function customizeTheme(string $theme, array $customizations): bool
    {
        $themePath = resource_path("themes/{$theme}");
        if (!File::exists($themePath)) {
            return false;
        }

        // Özelleştirme dosyası oluştur
        $customFile = "{$themePath}/custom.css";
        $css = '';
        
        foreach ($customizations as $selector => $styles) {
            $css .= "{$selector} {\n";
            foreach ($styles as $property => $value) {
                $css .= "  {$property}: {$value};\n";
            }
            $css .= "}\n\n";
        }

        File::put($customFile, $css);
        return true;
    }

    /**
     * Tema istatistikleri
     */
    public function getThemeStats(): array
    {
        $total = count($this->availableThemes);
        $currentTheme = $this->getCurrentTheme();
        
        return [
            'total' => $total,
            'current' => $currentTheme,
            'available' => array_keys($this->availableThemes),
            'current_info' => $this->getThemeInfo()
        ];
    }
}
