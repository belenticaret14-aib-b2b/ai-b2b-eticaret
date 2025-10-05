<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bayiler', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('email')->unique();
            $table->string('telefon')->nullable();
            $table->string('adres')->nullable();
            $table->unsignedBigInteger('kullanici_id');
            $table->timestamps();

            $table->foreign('kullanici_id')->references('id')->on('kullanicilar')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bayiler');
    }
};
