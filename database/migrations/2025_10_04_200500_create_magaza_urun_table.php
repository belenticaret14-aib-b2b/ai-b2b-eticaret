<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('magaza_urun', function (Blueprint $table) {
            $table->unsignedBigInteger('magaza_id');
            $table->unsignedBigInteger('urun_id');
            $table->primary(['magaza_id', 'urun_id']);

            $table->foreign('magaza_id')->references('id')->on('magazalar')->onDelete('cascade');
            $table->foreign('urun_id')->references('id')->on('urunler')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magaza_urun');
    }
};
