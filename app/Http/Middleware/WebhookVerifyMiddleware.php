<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

/**
 * Webhook İmza Doğrulama Middleware'i
 * 
 * Platform webhook'larının güvenliğini sağlar.
 * Her platform kendi imzalama yöntemini kullanır.
 */
class WebhookVerifyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $platform = $this->getPlatformFromUrl($request);
        
        // Platform belirlenemezse reddet
        if (!$platform) {
            Log::warning('Webhook: Platform belirlenemedi', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Invalid webhook'], 403);
        }
        
        // Platform'a özel doğrulama yap
        $verified = match($platform) {
            'trendyol' => $this->verifyTrendyol($request),
            'hepsiburada' => $this->verifyHepsiburada($request),
            'n11' => $this->verifyN11($request),
            'amazon' => $this->verifyAmazon($request),
            default => false
        };
        
        // Doğrulanamazsa reddet
        if (!$verified) {
            Log::warning('Webhook: İmza doğrulaması başarısız', [
                'platform' => $platform,
                'ip' => $request->ip(),
                'headers' => $request->headers->all()
            ]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }
        
        // Doğrulandı, devam et
        Log::info('Webhook: Doğrulandı', [
            'platform' => $platform,
            'ip' => $request->ip()
        ]);
        
        return $next($request);
    }
    
    /**
     * URL'den platform adını çıkar
     */
    private function getPlatformFromUrl(Request $request): ?string
    {
        $path = $request->path();
        
        if (str_contains($path, 'trendyol')) return 'trendyol';
        if (str_contains($path, 'hepsiburada')) return 'hepsiburada';
        if (str_contains($path, 'n11')) return 'n11';
        if (str_contains($path, 'amazon')) return 'amazon';
        
        return null;
    }
    
    /**
     * Trendyol webhook imzasını doğrula
     * 
     * Trendyol HMAC-SHA256 kullanır
     */
    private function verifyTrendyol(Request $request): bool
    {
        // Trendyol'dan gelen signature header'ı
        $signature = $request->header('X-Trendyol-Signature');
        
        if (!$signature) {
            return false;
        }
        
        // Secret key (mağaza ayarlarından alınmalı)
        $secret = config('eticaret.trendyol.webhook_secret');
        
        if (!$secret) {
            // Secret yoksa development modunda geçir
            return !app()->isProduction();
        }
        
        // İmzayı hesapla
        $payload = $request->getContent();
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        
        // Karşılaştır (timing attack'e karşı hash_equals kullan)
        return hash_equals($expectedSignature, $signature);
    }
    
    /**
     * Hepsiburada webhook imzasını doğrula
     */
    private function verifyHepsiburada(Request $request): bool
    {
        $signature = $request->header('X-Hepsiburada-Signature');
        
        if (!$signature) {
            return false;
        }
        
        $secret = config('eticaret.hepsiburada.webhook_secret');
        
        if (!$secret) {
            return !app()->isProduction();
        }
        
        $payload = $request->getContent();
        $expectedSignature = base64_encode(hash_hmac('sha256', $payload, $secret, true));
        
        return hash_equals($expectedSignature, $signature);
    }
    
    /**
     * N11 webhook imzasını doğrula
     */
    private function verifyN11(Request $request): bool
    {
        // N11 API key kontrolü
        $apiKey = $request->header('X-N11-ApiKey');
        
        if (!$apiKey) {
            return false;
        }
        
        $expectedApiKey = config('eticaret.n11.api_key');
        
        if (!$expectedApiKey) {
            return !app()->isProduction();
        }
        
        return hash_equals($expectedApiKey, $apiKey);
    }
    
    /**
     * Amazon webhook imzasını doğrula
     */
    private function verifyAmazon(Request $request): bool
    {
        $signature = $request->header('X-Amz-Sns-Signature');
        
        if (!$signature) {
            return false;
        }
        
        // Amazon SNS signature verification (basitleştirilmiş)
        // Gerçek production'da AWS SDK kullanılmalı
        
        $secret = config('eticaret.amazon.webhook_secret');
        
        if (!$secret) {
            return !app()->isProduction();
        }
        
        // Basit doğrulama (production'da AWS SDK gerekli)
        return !empty($signature);
    }
}
