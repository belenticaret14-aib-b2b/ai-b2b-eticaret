@extends('layouts.app')

@section('title', 'Bot Ayarları')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">🤖 Bot Ayarları</h1>
                    <p class="mt-2 text-gray-600">WhatsApp, Telegram ve Discord bot yapılandırmaları</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('super-admin.gelistirici') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        ← Geliştirici
                    </a>
                </div>
            </div>
        </div>

        <!-- Bot Settings Form -->
        <form method="POST" action="{{ route('super-admin.bot-update') }}" class="space-y-8">
            @csrf
            
            <!-- WhatsApp Bot -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">WhatsApp Bot</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="whatsapp[enabled]" value="1" 
                               {{ $botSettings['whatsapp']['enabled'] ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                        <input type="url" name="whatsapp[webhook_url]" 
                               value="{{ $botSettings['whatsapp']['webhook_url'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Token</label>
                        <input type="text" name="whatsapp[token]" 
                               value="{{ $botSettings['whatsapp']['token'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Telefon Numarası</label>
                        <input type="text" name="whatsapp[phone_number]" 
                               value="{{ $botSettings['whatsapp']['phone_number'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="testBot('whatsapp')" 
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                            Test Et
                        </button>
                    </div>
                </div>
            </div>

            <!-- Telegram Bot -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Telegram Bot</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="telegram[enabled]" value="1" 
                               {{ $botSettings['telegram']['enabled'] ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bot Token</label>
                        <input type="text" name="telegram[bot_token]" 
                               value="{{ $botSettings['telegram']['bot_token'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                        <input type="url" name="telegram[webhook_url]" 
                               value="{{ $botSettings['telegram']['webhook_url'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chat ID</label>
                        <input type="text" name="telegram[chat_id]" 
                               value="{{ $botSettings['telegram']['chat_id'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="testBot('telegram')" 
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            Test Et
                        </button>
                    </div>
                </div>
            </div>

            <!-- Discord Bot -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Discord Bot</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="discord[enabled]" value="1" 
                               {{ $botSettings['discord']['enabled'] ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bot Token</label>
                        <input type="text" name="discord[bot_token]" 
                               value="{{ $botSettings['discord']['bot_token'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Webhook URL</label>
                        <input type="url" name="discord[webhook_url]" 
                               value="{{ $botSettings['discord']['webhook_url'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Channel ID</label>
                        <input type="text" name="discord[channel_id]" 
                               value="{{ $botSettings['discord']['channel_id'] }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="testBot('discord')" 
                                class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                            Test Et
                        </button>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Ayarları Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function testBot(botType) {
    const message = prompt('Test mesajı girin:', 'Merhaba! Bu bir test mesajıdır.');
    if (!message) return;

    fetch(`/super-admin/bot-test`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            bot_type: botType,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.error);
        }
    })
    .catch(error => {
        alert('❌ Test sırasında hata oluştu: ' + error.message);
    });
}
</script>
@endsection







