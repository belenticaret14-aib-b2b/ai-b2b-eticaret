<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('magazalar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('entegrasyon_turu'); // trendyol, hepsiburada, n11
            $table->string('api_anahtari')->nullable();
            $table->string('api_gizli_anahtar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magazalar');
    }
};
