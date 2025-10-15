<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\ThemeService;
use Illuminate\Support\Facades\View;

class ThemeMiddleware
{
    protected ThemeService $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Session'dan aktif temayı al
        $activeTheme = session('active_theme', config('theme.active', 'default'));
        
        // Temayı ayarla
        $this->themeService->setTheme($activeTheme);
        
        // View'lara tema bilgilerini paylaş
        View::share([
            'currentTheme' => $this->themeService->getCurrentTheme(),
            'themeInfo' => $this->themeService->getThemeInfo(),
            'themeAssetPath' => $this->themeService->getThemeAssetPath(),
        ]);
        
        // Tema CSS'lerini paylaş
        View::share('themeStylesheets', $this->themeService->getThemeStylesheets());
        
        // Tema JS'lerini paylaş
        View::share('themeScripts', $this->themeService->getThemeScripts());
        
        return $next($request);
    }
}



