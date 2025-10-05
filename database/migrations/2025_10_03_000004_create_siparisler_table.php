<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siparisler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kullanici_id')->constrained('kullanicilar')->onDelete('cascade');
            $table->decimal('toplam_tutar', 10, 2);
            $table->string('durum')->default('beklemede'); // beklemede, onaylandı, kargoda, tamamlandı
            $table->text('adres')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siparisler');
    }
};
