<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

/**
 * Desktop API Doğrulama Middleware'i
 * 
 * Desktop uygulamasından gelen istekleri doğrular.
 * API key veya token tabanlı kimlik doğrulama.
 */
class DesktopVerifyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Desktop API key kontrolü
        $apiKey = $request->header('X-Desktop-API-Key') 
                  ?? $request->input('api_key');
        
        // API key yoksa reddet
        if (!$apiKey) {
            Log::warning('Desktop API: API key eksik', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'API key gerekli'
            ], 401);
        }
        
        // API key'i doğrula
        $validApiKey = config('app.desktop_api_key') ?? env('DESKTOP_API_KEY');
        
        if (!$validApiKey) {
            // Üretimde API key mutlaka olmalı
            if (app()->isProduction()) {
                Log::error('Desktop API: API key tanımlı değil!');
                return response()->json([
                    'success' => false,
                    'error' => 'Sunucu yapılandırma hatası'
                ], 500);
            }
            
            // Development'ta uyarı ver ve geçir
            Log::warning('Desktop API: API key tanımlı değil (development mode)');
            return $next($request);
        }
        
        // API key karşılaştır (timing attack'e karşı hash_equals)
        if (!hash_equals($validApiKey, $apiKey)) {
            Log::warning('Desktop API: Geçersiz API key', [
                'ip' => $request->ip(),
                'provided_key' => substr($apiKey, 0, 8) . '...'
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Geçersiz API key'
            ], 403);
        }
        
        // Rate limiting kontrolü (opsiyonel)
        $rateLimitKey = 'desktop_api:' . $request->ip();
        $maxRequests = 120; // 2 dakikada 120 istek
        $decayMinutes = 2;
        
        if (cache()->has($rateLimitKey)) {
            $attempts = cache()->get($rateLimitKey);
            
            if ($attempts >= $maxRequests) {
                Log::warning('Desktop API: Rate limit aşıldı', [
                    'ip' => $request->ip()
                ]);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Çok fazla istek. Lütfen bekleyin.'
                ], 429);
            }
            
            cache()->put($rateLimitKey, $attempts + 1, now()->addMinutes($decayMinutes));
        } else {
            cache()->put($rateLimitKey, 1, now()->addMinutes($decayMinutes));
        }
        
        // Doğrulandı
        Log::info('Desktop API: Erişim izni verildi', [
            'ip' => $request->ip(),
            'endpoint' => $request->path()
        ]);
        
        return $next($request);
    }
}
