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
        Schema::create('urun_resimleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urun_id')->constrained('urunler')->onDelete('cascade');
            $table->string('resim_yolu');
            $table->string('alt_text')->nullable();
            $table->boolean('ana_resim')->default(false);
            $table->integer('sira')->default(0);
            $table->timestamps();
            
            $table->index(['urun_id', 'ana_resim']);
            $table->index(['urun_id', 'sira']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_resimleri');
    }
};
