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
        Schema::create('sayfa_icerikleri', function (Blueprint $table) {
            $table->id();
            $table->string('baslik');
            $table->string('slug')->unique();
            $table->longText('icerik');
            $table->string('meta_baslik')->nullable();
            $table->text('meta_aciklama')->nullable();
            $table->json('meta_etiketler')->nullable();
            $table->string('resim')->nullable();
            $table->boolean('durum')->default(true);
            $table->integer('sira')->default(0);
            $table->enum('tip', ['sayfa', 'blog', 'duyuru'])->default('sayfa');
            $table->timestamps();
            
            $table->index(['slug', 'durum']);
            $table->index(['tip', 'durum']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sayfa_icerikleri');
    }
};
