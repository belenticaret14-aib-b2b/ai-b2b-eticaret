<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('urunler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('sku')->unique()->nullable();
            $table->text('aciklama')->nullable();
            $table->decimal('fiyat', 10, 2);
            $table->integer('stok')->default(0);
            $table->string('barkod')->nullable();
            $table->string('resim')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urunler');
    }
};
