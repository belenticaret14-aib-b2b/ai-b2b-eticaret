<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    private string $apiKey;
    private string $model;
    private int $maxTokens;
    private string $baseUrl = 'https://api.anthropic.com/v1/messages';

    public function __construct()
    {
        $this->apiKey = config('services.claude.api_key');
        $this->model = config('services.claude.model', 'claude-sonnet-4.5-20250929');
        $this->maxTokens = config('services.claude.max_tokens', 4096);
    }

    /**
     * Claude'a soru sor
     */
    public function ask(string $prompt, array $options = []): array
    {
        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'x-api-key' => $this->apiKey,
                    'anthropic-version' => '2023-06-01',
                    'content-type' => 'application/json',
                ])
                ->post($this->baseUrl, [
                    'model' => $options['model'] ?? $this->model,
                    'max_tokens' => $options['max_tokens'] ?? $this->maxTokens,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'response' => $data['content'][0]['text'],
                    'usage' => $data['usage'] ?? null,
                    'model' => $data['model'] ?? null
                ];
            }

            Log::error('Claude API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'API hatası: ' . $response->status(),
                'details' => $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('Claude Service Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Kod analizi yap
     */
    public function analyzeCode(string $code, string $language = 'php'): array
    {
        $prompt = "Bu {$language} kodunu analiz et:\n\n```{$language}\n{$code}\n```\n\nAnaliz et:\n1. Hatalar\n2. İyileştirmeler\n3. Best practices";
        
        return $this->ask($prompt);
    }

    /**
     * Kod sadeleştir
     */
    public function simplifyCode(string $code): array
    {
        $prompt = "Bu kodu sadeleştir ve açıkla:\n\n```php\n{$code}\n```";
        
        return $this->ask($prompt);
    }

    /**
     * Test kodu üret
     */
    public function generateTest(string $code, string $className): array
    {
        $prompt = "Bu {$className} sınıfı için PHPUnit test yaz:\n\n```php\n{$code}\n```";
        
        return $this->ask($prompt);
    }

    /**
     * Dokümantasyon üret
     */
    public function generateDocumentation(string $code): array
    {
        $prompt = "Bu kod için detaylı dokümantasyon yaz (Türkçe):\n\n```php\n{$code}\n```";
        
        return $this->ask($prompt);
    }
}