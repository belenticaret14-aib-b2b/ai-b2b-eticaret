<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ThemeService;
use Illuminate\Http\JsonResponse;

class ThemeController extends Controller
{
    protected ThemeService $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    /**
     * Tema listesini göster
     */
    public function index()
    {
        $themes = $this->themeService->getAvailableThemes();
        $currentTheme = $this->themeService->getCurrentTheme();
        
        $themeData = [];
        foreach ($themes as $key => $name) {
            $themeData[$key] = [
                'name' => $name,
                'active' => $key === $currentTheme,
                'info' => $this->getThemeInfo($key),
                'preview' => $this->getThemePreview($key),
            ];
        }

        return view('admin.theme-selector', compact('themeData', 'currentTheme'));
    }

    /**
     * Temayı değiştir
     */
    public function switch(Request $request): JsonResponse
    {
        $request->validate([
            'theme' => 'required|string|in:' . implode(',', array_keys($this->themeService->getAvailableThemes()))
        ]);

        $theme = $request->input('theme');
        
        if ($this->themeService->setTheme($theme)) {
            return response()->json([
                'success' => true,
                'message' => "Tema '{$theme}' olarak değiştirildi.",
                'theme' => $theme,
                'redirect' => $request->header('Referer', route('anasayfa'))
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Geçersiz tema seçimi.'
        ], 400);
    }

    /**
     * Tema önizlemesi
     */
    public function preview(string $theme)
    {
        if (!array_key_exists($theme, $this->themeService->getAvailableThemes())) {
            abort(404);
        }

        // Geçici olarak temayı değiştir
        $originalTheme = $this->themeService->getCurrentTheme();
        $this->themeService->setTheme($theme);
        
        // Ana sayfayı önizleme modunda göster
        return view('anasayfa')->with('preview_mode', true);
    }

    /**
     * Tema bilgilerini al
     */
    protected function getThemeInfo(string $theme): array
    {
        $themePath = resource_path("themes/{$theme}");
        $infoFile = "{$themePath}/theme.json";
        
        if (file_exists($infoFile)) {
            return json_decode(file_get_contents($infoFile), true) ?? [];
        }
        
        return [
            'name' => $this->themeService->getAvailableThemes()[$theme] ?? 'Bilinmeyen Tema',
            'version' => '1.0.0',
            'description' => 'Tema açıklaması',
            'author' => 'NetMarketiniz',
        ];
    }

    /**
     * Tema önizleme resmini al
     */
    protected function getThemePreview(string $theme): string
    {
        $previewPath = public_path("themes/{$theme}/preview.jpg");
        
        if (file_exists($previewPath)) {
            return "/themes/{$theme}/preview.jpg";
        }
        
        // Varsayılan önizleme
        return "https://via.placeholder.com/400x300?text={$theme}";
    }

    /**
     * Tema ayarları
     */
    public function settings()
    {
        $currentTheme = $this->themeService->getCurrentTheme();
        $themeInfo = $this->themeService->getThemeInfo();
        
        return view('admin.theme-settings', compact('currentTheme', 'themeInfo'));
    }

    /**
     * Tema ayarlarını kaydet
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            'theme' => 'required|string|in:' . implode(',', array_keys($this->themeService->getAvailableThemes())),
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
        ]);

        // Temayı değiştir
        $this->themeService->setTheme($request->input('theme'));
        
        // Özel CSS/JS'i kaydet (gelecekte implement edilebilir)
        
        return redirect()->back()->with('success', 'Tema ayarları kaydedildi.');
    }
}



