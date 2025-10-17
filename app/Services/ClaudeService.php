<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    private $apiKey;
    private $model;
    private $maxTokens;
    private $baseUrl = 'https://api.anthropic.com/v1/messages';
    
    // Cursor context tracking
    private $cursorContext = null;

    public function __construct()
    {
        $this->apiKey = config('services.claude.api_key');
        $this->model = config('services.claude.model', 'claude-sonnet-4.5-20250929');
        $this->maxTokens = config('services.claude.max_tokens', 4096);
        
        // Load context
        $this->loadContext();
    }

    private function loadContext()
    {
        $contextPath = base_path('.claude/context.json');
        if (file_exists($contextPath)) {
            $this->cursorContext = json_decode(file_get_contents($contextPath), true);
        }
    }

    public function ask($prompt, $options = [])
    {
        // Context ekle
        $fullPrompt = $this->addContext($prompt);
        
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
                            'content' => $fullPrompt
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'response' => $data['content'][0]['text'],
                    'usage' => $data['usage'] ?? null
                ];
            }

            return [
                'success' => false,
                'error' => 'API hatası: ' . $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Claude Service Exception', ['message' => $e->getMessage()]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function addContext($prompt)
    {
        if (!$this->cursorContext) {
            return $prompt;
        }
        
        $contextSummary = "Proje Bağlamı:\n";
        $contextSummary .= "- Proje: " . $this->cursorContext['project']['name'] . "\n";
        $contextSummary .= "- Son güncelleme: " . $this->cursorContext['project']['last_updated'] . "\n";
        
        return $contextSummary . "\n---\n\n" . $prompt;
    }

    public function analyzeCode($code, $language = 'php')
    {
        $prompt = "Bu {$language} kodunu analiz et:\n\n```{$language}\n{$code}\n```\n\nAnaliz:\n1. Hatalar\n2. İyileştirmeler\n3. Best practices";
        
        return $this->ask($prompt);
    }
}