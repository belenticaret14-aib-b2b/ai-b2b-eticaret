<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    /**
     * Bot ayarları sayfası
     */
    public function index()
    {
        $botSettings = [
            'whatsapp' => [
                'enabled' => true,
                'webhook_url' => config('bot.whatsapp.webhook_url'),
                'token' => config('bot.whatsapp.token'),
                'phone_number' => config('bot.whatsapp.phone_number'),
            ],
            'telegram' => [
                'enabled' => true,
                'bot_token' => config('bot.telegram.bot_token'),
                'webhook_url' => config('bot.telegram.webhook_url'),
                'chat_id' => config('bot.telegram.chat_id'),
            ],
            'discord' => [
                'enabled' => false,
                'bot_token' => config('bot.discord.bot_token'),
                'webhook_url' => config('bot.discord.webhook_url'),
                'channel_id' => config('bot.discord.channel_id'),
            ]
        ];

        return view('super-admin.bot-ayarlari', compact('botSettings'));
    }

    /**
     * Bot ayarlarını güncelle
     */
    public function update(Request $request)
    {
        $request->validate([
            'whatsapp.enabled' => 'boolean',
            'whatsapp.webhook_url' => 'nullable|url',
            'whatsapp.token' => 'nullable|string',
            'whatsapp.phone_number' => 'nullable|string',
            'telegram.enabled' => 'boolean',
            'telegram.bot_token' => 'nullable|string',
            'telegram.webhook_url' => 'nullable|url',
            'telegram.chat_id' => 'nullable|string',
            'discord.enabled' => 'boolean',
            'discord.bot_token' => 'nullable|string',
            'discord.webhook_url' => 'nullable|url',
            'discord.channel_id' => 'nullable|string',
        ]);

        // Bot ayarlarını güncelle (gerçek uygulamada config dosyasına yazılır)
        $botSettings = $request->only([
            'whatsapp', 'telegram', 'discord'
        ]);

        // Log the update
        Log::info('Bot settings updated', $botSettings);

        return redirect()->route('super-admin.bot-ayarlari')
                        ->with('success', 'Bot ayarları başarıyla güncellendi.');
    }

    /**
     * Bot test et
     */
    public function test(Request $request)
    {
        $botType = $request->input('bot_type');
        $message = $request->input('message', 'Test mesajı');

        try {
            switch ($botType) {
                case 'whatsapp':
                    return $this->testWhatsApp($message);
                case 'telegram':
                    return $this->testTelegram($message);
                case 'discord':
                    return $this->testDiscord($message);
                default:
                    return response()->json(['error' => 'Geçersiz bot türü'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Bot test failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Bot testi başarısız: ' . $e->getMessage()], 500);
        }
    }

    /**
     * WhatsApp bot test
     */
    private function testWhatsApp($message)
    {
        // WhatsApp API entegrasyonu (gerçek uygulamada WhatsApp Business API kullanılır)
        $response = [
            'status' => 'success',
            'message' => 'WhatsApp bot test mesajı gönderildi',
            'bot_type' => 'whatsapp'
        ];

        return response()->json($response);
    }

    /**
     * Telegram bot test
     */
    private function testTelegram($message)
    {
        $botToken = config('bot.telegram.bot_token');
        $chatId = config('bot.telegram.chat_id');

        if (!$botToken || !$chatId) {
            return response()->json(['error' => 'Telegram bot ayarları eksik'], 400);
        }

        $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Telegram bot test mesajı gönderildi',
                'bot_type' => 'telegram'
            ]);
        } else {
            return response()->json(['error' => 'Telegram bot testi başarısız'], 500);
        }
    }

    /**
     * Discord bot test
     */
    private function testDiscord($message)
    {
        $webhookUrl = config('bot.discord.webhook_url');

        if (!$webhookUrl) {
            return response()->json(['error' => 'Discord webhook URL eksik'], 400);
        }

        $response = Http::post($webhookUrl, [
            'content' => $message,
            'username' => 'AI B2B Bot'
        ]);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Discord bot test mesajı gönderildi',
                'bot_type' => 'discord'
            ]);
        } else {
            return response()->json(['error' => 'Discord bot testi başarısız'], 500);
        }
    }

    /**
     * Bot webhook handler
     */
    public function webhook(Request $request, $botType)
    {
        Log::info("Bot webhook received", [
            'bot_type' => $botType,
            'data' => $request->all()
        ]);

        switch ($botType) {
            case 'whatsapp':
                return $this->handleWhatsAppWebhook($request);
            case 'telegram':
                return $this->handleTelegramWebhook($request);
            case 'discord':
                return $this->handleDiscordWebhook($request);
            default:
                return response()->json(['error' => 'Geçersiz bot türü'], 400);
        }
    }

    /**
     * WhatsApp webhook handler
     */
    private function handleWhatsAppWebhook(Request $request)
    {
        // WhatsApp webhook işleme mantığı
        $data = $request->all();
        
        // Mesaj işleme
        if (isset($data['messages'])) {
            foreach ($data['messages'] as $message) {
                $this->processWhatsAppMessage($message);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Telegram webhook handler
     */
    private function handleTelegramWebhook(Request $request)
    {
        $update = $request->all();
        
        if (isset($update['message'])) {
            $this->processTelegramMessage($update['message']);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Discord webhook handler
     */
    private function handleDiscordWebhook(Request $request)
    {
        $data = $request->all();
        
        if (isset($data['content'])) {
            $this->processDiscordMessage($data);
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * WhatsApp mesaj işleme
     */
    private function processWhatsAppMessage($message)
    {
        $text = $message['text']['body'] ?? '';
        $from = $message['from'] ?? '';
        
        // Komut işleme
        if (str_starts_with($text, '/')) {
            $this->handleBotCommand($text, $from, 'whatsapp');
        }
    }

    /**
     * Telegram mesaj işleme
     */
    private function processTelegramMessage($message)
    {
        $text = $message['text'] ?? '';
        $chatId = $message['chat']['id'] ?? '';
        
        // Komut işleme
        if (str_starts_with($text, '/')) {
            $this->handleBotCommand($text, $chatId, 'telegram');
        }
    }

    /**
     * Discord mesaj işleme
     */
    private function processDiscordMessage($data)
    {
        $content = $data['content'] ?? '';
        
        // Komut işleme
        if (str_starts_with($content, '!')) {
            $this->handleBotCommand($content, 'discord', 'discord');
        }
    }

    /**
     * Bot komut işleme
     */
    private function handleBotCommand($command, $userId, $platform)
    {
        $commands = [
            '/urunler' => 'Ürün listesi göster',
            '/siparis' => 'Sipariş oluştur',
            '/durum' => 'Sipariş durumu sorgula',
            '/help' => 'Yardım menüsü',
            '/start' => 'Bot başlat'
        ];

        $response = $commands[$command] ?? 'Bilinmeyen komut. /help yazarak yardım alabilirsiniz.';

        // Bot yanıtı gönder (gerçek uygulamada ilgili platform API'si kullanılır)
        Log::info('Bot command processed', [
            'command' => $command,
            'user_id' => $userId,
            'platform' => $platform,
            'response' => $response
        ]);
    }
}