<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    protected $apiKey;
    protected $model;
    protected $maxTokens;
    protected $baseUrl = 'https://api.anthropic.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.claude.api_key');
        $this->model = config('services.claude.model', 'claude-sonnet-4.5-20250929');
        $this->maxTokens = config('services.claude.max_tokens', 4096);
    }

    /**
     * Claude'a mesaj gönderir
     * 
     * @param array $messages Mesaj dizisi
     * @param string|null $systemPrompt Sistem promptu
     * @return string Claude'un yanıtı
     */
    public function mesajGonder(array $messages, ?string $systemPrompt = null): string
    {
        try {
            $payload = [
                'model' => $this->model,
                'max_tokens' => $this->maxTokens,
                'messages' => $this->formatMessagesIfNeeded($messages),
            ];

            if ($systemPrompt) {
                $payload['system'] = $systemPrompt;
            }

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->post($this->baseUrl . '/messages', $payload);

            if ($response->failed()) {
                Log::error('Claude API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Claude API isteği başarısız oldu: ' . $response->body());
            }

            $data = $response->json();
            
            return $data['content'][0]['text'] ?? '';

        } catch (\Exception $e) {
            Log::error('Claude Service Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Mesajları Claude format'ına dönüştürür
     */
    protected function formatMessagesIfNeeded(array $messages): array
    {
        // Eğer tek bir mesaj string olarak geldiyse
        if (isset($messages['role']) && isset($messages['content'])) {
            return [$messages];
        }

        // Eğer ilk eleman string ise, user mesajı olarak formatla
        if (is_string($messages[0] ?? null)) {
            return [[
                'role' => 'user',
                'content' => $messages[0],
            ]];
        }

        return $messages;
    }

    /**
     * Metin oluşturur (basitleştirilmiş)
     * 
     * @param string $prompt İstek metni
     * @param string|null $systemPrompt Sistem promptu
     * @return string Oluşturulan metin
     */
    public function metinOlustur(string $prompt, ?string $systemPrompt = null): string
    {
        return $this->mesajGonder([
            ['role' => 'user', 'content' => $prompt]
        ], $systemPrompt);
    }

    /**
     * Ürün açıklaması oluşturur
     * 
     * @param string $urunAdi Ürün adı
     * @param array $ozellikler Ürün özellikleri
     * @return string Oluşturulan açıklama
     */
    public function urunAciklamasiOlustur(string $urunAdi, array $ozellikler = []): string
    {
        $ozelliklerText = empty($ozellikler) 
            ? '' 
            : "\n\nÖzellikler:\n" . implode("\n", array_map(fn($k, $v) => "- $k: $v", array_keys($ozellikler), $ozellikler));

        $prompt = "Aşağıdaki ürün için çekici ve SEO uyumlu bir açıklama oluştur:\n\n" .
                  "Ürün Adı: {$urunAdi}" . 
                  $ozelliklerText . 
                  "\n\nAçıklama Türkçe, profesyonel ve müşteri odaklı olmalı.";

        return $this->metinOlustur($prompt);
    }

    /**
     * Sipariş özeti oluşturur
     * 
     * @param array $siparisData Sipariş verileri
     * @return string Özet metin
     */
    public function siparisOzetiOlustur(array $siparisData): string
    {
        $prompt = "Aşağıdaki sipariş bilgilerinden kısa bir özet oluştur:\n\n" .
                  json_encode($siparisData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) .
                  "\n\nÖzet 2-3 cümle olmalı ve önemli detayları içermeli.";

        return $this->metinOlustur($prompt);
    }

    /**
     * Müşteri mesajına otomatik yanıt oluşturur
     * 
     * @param string $musteriMesaji Müşteri mesajı
     * @param array $context Bağlam bilgileri
     * @return string Önerilen yanıt
     */
    public function musteriYanitiOlustur(string $musteriMesaji, array $context = []): string
    {
        $contextText = empty($context) 
            ? '' 
            : "\n\nBağlam:\n" . json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $systemPrompt = "Sen NetMarketiniz'in müşteri hizmetleri asistanısın. " .
                       "Türkçe, nazik ve yardımsever bir dille yanıt vermelisin. " .
                       "Yanıtlar kısa ve öz olmalı.";

        $prompt = "Müşteri Mesajı: {$musteriMesaji}" . $contextText . 
                  "\n\nBu mesaja uygun bir yanıt hazırla.";

        return $this->metinOlustur($prompt, $systemPrompt);
    }

    /**
     * Context ile birlikte mesaj gönderir
     * 
     * @param string $prompt Ana prompt
     * @param ClaudeContextService $contextService Context servisi
     * @return string Yanıt
     */
    public function contextIleMesajGonder(string $prompt, ClaudeContextService $contextService): string
    {
        $context = $contextService->getContext();
        
        $systemPrompt = "Sen NetMarketiniz B2B/B2C projesinin Laravel asistanısın.\n\n" .
                       "Proje Sahibi: {$context['project']['owner']}\n" .
                       "Stack: {$context['tech_stack']['framework']} + PHP {$context['tech_stack']['php']}\n" .
                       "Kurallar:\n" .
                       "- Türkçe method isimleri kullan\n" .
                       "- Repository pattern uygula\n" .
                       "- Service layer kullan\n" .
                       "- Detaylı açıklama yap\n" .
                       "- 'Panel' yerine 'Pano' de\n" .
                       "- Sonunda 'Kolay gelsin' de";

        return $this->metinOlustur($prompt, $systemPrompt);
    }

    /**
     * Model bilgisini döner
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * API durumunu kontrol eder
     */
    public function durumKontrol(): bool
    {
        try {
            $this->metinOlustur('Test');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
