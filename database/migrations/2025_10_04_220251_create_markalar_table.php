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
        Schema::create('markalar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('slug')->unique();
            $table->text('aciklama')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('durum')->default(true);
            $table->string('seo_baslik')->nullable();
            $table->text('seo_aciklama')->nullable();
            $table->json('meta_etiketler')->nullable();
            $table->timestamps();
            
            $table->index(['slug', 'durum']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markalar');
    }
};
