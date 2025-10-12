<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite için tabloyu yeniden oluştur
        Schema::dropIfExists('kullanicilar');
        
        Schema::create('kullanicilar', function (Blueprint $table) {
            $table->id();
            $table->string('ad');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telefon')->nullable();
            $table->text('adres')->nullable();
            $table->enum('rol', ['super_admin', 'store_admin', 'dealer_admin', 'admin', 'bayi', 'musteri'])->default('musteri');
            $table->boolean('durum')->default(true);
            $table->rememberToken();
            $table->timestamps();
            
            $table->index(['email', 'rol']);
            $table->index('durum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kullanicilar');
    }
};