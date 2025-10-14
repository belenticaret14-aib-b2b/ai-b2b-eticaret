<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    private ?Client $client = null;
    private ?string $apiKey = null;
    private string $apiUrl = 'https://api.anthropic.com/v1/messages';
    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.claude.api_key');
        $this->model = config('services.claude.model', 'claude-3-5-sonnet-20241022');
        
        if ($this->apiKey) {
            $this->client = new Client([
                'timeout' => 120,
                'headers' => [
                    'x-api-key' => $this->apiKey,
                    'anthropic-version' => '2023-06-01',
                    'content-type' => 'application/json',
                ],
            ]);
        }
    }

    /**
     * Claude'a mesaj gönder ve yanıt al
     *
     * @param string $prompt Gönderilecek mesaj
     * @param int $maxTokens Maksimum token sayısı
     * @param float $temperature Yaratıcılık seviyesi (0.0 - 1.0)
     * @return array
     */
    public function chat(string $prompt, int $maxTokens = 4096, float $temperature = 0.7): array
    {
        if (!$this->apiKey || !$this->client) {
            return [
                'success' => false,
                'error' => 'Claude API key tanımlı değil. Lütfen .env dosyasına CLAUDE_API_KEY ekleyin.',
                'response' => null
            ];
        }

        // Mock mode - API kredi sorunu için geçici çözüm
        if (config('app.env') === 'local' && env('CLAUDE_MOCK_MODE', false)) {
            return [
                'success' => true,
                'response' => '🤖 Mock Claude: "Merhaba! Bu bir test yanıtıdır. Claude API kredisi yetersiz olduğu için mock modda çalışıyorum. Gerçek Claude API\'sini kullanmak için hesabınıza kredi eklemeniz gerekiyor."',
                'usage' => [
                    'input_tokens' => strlen($prompt),
                    'output_tokens' => 50,
                    'total_tokens' => strlen($prompt) + 50
                ]
            ];
        }

        try {
            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'model' => $this->model,
                    'max_tokens' => $maxTokens,
                    'temperature' => $temperature,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'response' => $body['content'][0]['text'] ?? '',
                'usage' => $body['usage'] ?? [],
                'model' => $body['model'] ?? $this->model,
            ];

        } catch (GuzzleException $e) {
            Log::error('Claude API Error: ' . $e->getMessage());
            
            // Kredi sorunu için özel mesaj
            if (str_contains($e->getMessage(), 'credit balance') || str_contains($e->getMessage(), '400')) {
                return [
                    'success' => false,
                    'error' => 'Claude API hesabınızda yeterli kredi bulunmuyor. Lütfen hesabınıza kredi ekleyin veya CLAUDE_MOCK_MODE=true ayarını kullanın.',
                    'response' => null,
                    'solution' => 'Mock mode için .env dosyasına CLAUDE_MOCK_MODE=true ekleyin'
                ];
            }
            
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'response' => null
            ];
        }
    }

    /**
     * Ürün açıklaması oluştur
     *
     * @param string $urunAdi
     * @param array $ozellikler
     * @return string
     */
    public function urunAciklamasiOlustur(string $urunAdi, array $ozellikler = []): string
    {
        $ozelliklerText = !empty($ozellikler) ? "\n\nÖzellikler:\n" . implode("\n", $ozellikler) : '';
        
        $prompt = "Bir B2B e-ticaret platformu için aşağıdaki ürün hakkında çekici ve profesyonel bir açıklama yaz:\n\n";
        $prompt .= "Ürün Adı: {$urunAdi}{$ozelliklerText}\n\n";
        $prompt .= "Açıklama SEO uyumlu, satış odaklı ve maksimum 300 kelime olsun.";

        $result = $this->chat($prompt, 1024, 0.8);
        
        return $result['success'] ? $result['response'] : 'Açıklama oluşturulamadı.';
    }

    /**
     * SEO meta description oluştur
     *
     * @param string $baslik
     * @param string $icerik
     * @return string
     */
    public function seoMetaOlustur(string $baslik, string $icerik): string
    {
        $prompt = "Aşağıdaki içerik için SEO uyumlu, çekici bir meta description oluştur (maksimum 160 karakter):\n\n";
        $prompt .= "Başlık: {$baslik}\n";
        $prompt .= "İçerik: " . substr($icerik, 0, 500) . "...";

        $result = $this->chat($prompt, 256, 0.7);
        
        return $result['success'] ? trim($result['response']) : '';
    }

    /**
     * Müşteri sorusuna otomatik yanıt oluştur
     *
     * @param string $soru
     * @param array $urunBilgileri
     * @return string
     */
    public function musteriSorusuYanitla(string $soru, array $urunBilgileri = []): string
    {
        $urunText = !empty($urunBilgileri) 
            ? "\n\nÜrün Bilgileri:\n" . json_encode($urunBilgileri, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            : '';

        $prompt = "Bir B2B e-ticaret müşteri temsilcisi olarak aşağıdaki soruyu profesyonel, yardımcı ve dostane bir şekilde yanıtla:\n\n";
        $prompt .= "Soru: {$soru}{$urunText}\n\n";
        $prompt .= "Yanıt Türkçe olmalı ve müşteri memnuniyetini ön planda tutmalı.";

        $result = $this->chat($prompt, 1024, 0.7);
        
        return $result['success'] ? $result['response'] : 'Üzgünüz, şu anda yanıt oluşturulamıyor.';
    }

    /**
     * Sipariş özeti ve tavsiyeler oluştur
     *
     * @param array $siparisVerileri
     * @return array
     */
    public function siparisAnalizi(array $siparisVerileri): array
    {
        $prompt = "Aşağıdaki B2B sipariş verilerini analiz et ve:\n";
        $prompt .= "1. Özet bilgi ver\n";
        $prompt .= "2. Cross-sell tavsiyeleri sun\n";
        $prompt .= "3. Potansiyel sorunları belirt\n\n";
        $prompt .= "Sipariş Verileri:\n" . json_encode($siparisVerileri, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $result = $this->chat($prompt, 2048, 0.7);
        
        if ($result['success']) {
            return [
                'success' => true,
                'analiz' => $result['response'],
                'token_kullanimi' => $result['usage']
            ];
        }

        return [
            'success' => false,
            'error' => $result['error'] ?? 'Analiz oluşturulamadı'
        ];
    }

    /**
     * Toplu içerik çevirisi
     *
     * @param string $icerik
     * @param string $hedefDil
     * @return string
     */
    public function ceviri(string $icerik, string $hedefDil = 'en'): string
    {
        $prompt = "Aşağıdaki Türkçe metni {$hedefDil} diline profesyonel olarak çevir. ";
        $prompt .= "E-ticaret terminolojisine dikkat et:\n\n{$icerik}";

        $result = $this->chat($prompt, 4096, 0.3);
        
        return $result['success'] ? $result['response'] : $icerik;
    }

    /**
     * Stok uyarısı ve tavsiye metni oluştur
     *
     * @param array $dusukStokUrunler
     * @return string
     */
    public function stokUyarisiOlustur(array $dusukStokUrunler): string
    {
        if (empty($dusukStokUrunler)) {
            return 'Stok durumu normal seviyede.';
        }

        $prompt = "Aşağıdaki ürünlerin stok seviyeleri düşük. Bir yönetici için uyarı ve aksiyon önerileri içeren kısa bir rapor hazırla:\n\n";
        $prompt .= json_encode($dusukStokUrunler, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $result = $this->chat($prompt, 1024, 0.7);
        
        return $result['success'] ? $result['response'] : 'Stok uyarısı oluşturulamadı.';
    }

    /**
     * Hata/Log analizi
     *
     * @param string $hataMetni
     * @return array
     */
    public function hataAnalizi(string $hataMetni): array
    {
        $prompt = "Aşağıdaki Laravel hata/log mesajını analiz et ve:\n";
        $prompt .= "1. Sorunun ne olduğunu açıkla\n";
        $prompt .= "2. Olası sebepleri listele\n";
        $prompt .= "3. Çözüm önerileri sun\n";
        $prompt .= "4. Kod örnekleri ver\n\n";
        $prompt .= "Hata:\n{$hataMetni}";

        $result = $this->chat($prompt, 2048, 0.5);
        
        if ($result['success']) {
            return [
                'success' => true,
                'analiz' => $result['response'],
                'cozum_onerileri' => $this->parseCozumOnerileri($result['response'])
            ];
        }

        return [
            'success' => false,
            'error' => $result['error'] ?? 'Hata analizi yapılamadı'
        ];
    }

    /**
     * Çözüm önerilerini parse et
     *
     * @param string $response
     * @return array
     */
    private function parseCozumOnerileri(string $response): array
    {
        // Basit parsing - geliştirillebilir
        $lines = explode("\n", $response);
        $oneriler = [];
        
        foreach ($lines as $line) {
            if (stripos($line, 'çözüm') !== false || stripos($line, 'öneri') !== false) {
                $oneriler[] = trim($line);
            }
        }
        
        return $oneriler;
    }

    /**
     * Model değiştir
     *
     * @param string $model
     * @return void
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * Mevcut modeli al
     *
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }
}

