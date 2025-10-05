<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('magazalar', function (Blueprint $table) {
            $table->string('platform_kodu')->nullable()->after('platform');
            $table->string('api_base_url')->nullable()->after('api_gizli_anahtar');
            $table->boolean('durum')->default(true)->after('entegrasyon_turu');
            $table->enum('senkron_durum', ['bekliyor', 'devam_ediyor', 'tamamlandi', 'hata'])->default('bekliyor')->after('durum');
            $table->timestamp('son_senkron')->nullable()->after('senkron_durum');
            $table->json('ayarlar')->nullable()->after('son_senkron');
            $table->string('webhook_url')->nullable()->after('ayarlar');
            $table->string('webhook_secret')->nullable()->after('webhook_url');
            $table->softDeletes();
            
            $table->index(['platform', 'durum']);
            $table->index('senkron_durum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magazalar', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'platform_kodu', 'api_base_url', 'durum', 'senkron_durum',
                'son_senkron', 'ayarlar', 'webhook_url', 'webhook_secret'
            ]);
        });
    }
};
