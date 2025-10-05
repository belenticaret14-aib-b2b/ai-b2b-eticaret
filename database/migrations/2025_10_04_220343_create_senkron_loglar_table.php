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
        Schema::create('senkron_loglar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magaza_id')->constrained('magazalar')->onDelete('cascade');
            $table->enum('tip', ['urun_senkron', 'stok_senkron', 'fiyat_senkron', 'siparis_senkron']);
            $table->enum('durum', ['basarili', 'hata', 'kismi_basarili']);
            $table->json('detay')->nullable();
            $table->timestamp('baslangic_zamani')->nullable();
            $table->timestamp('bitis_zamani')->nullable();
            $table->text('hata_mesaji')->nullable();
            $table->timestamps();
            
            $table->index(['magaza_id', 'tip']);
            $table->index(['durum', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('senkron_loglar');
    }
};
