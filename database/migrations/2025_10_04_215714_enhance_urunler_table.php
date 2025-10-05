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
        Schema::table('urunler', function (Blueprint $table) {
            $table->decimal('bayi_fiyat', 10, 2)->nullable()->after('fiyat');
            $table->integer('minimum_stok')->default(5)->after('stok');
            $table->foreignId('kategori_id')->nullable()->after('id')->constrained('kategoriler')->onDelete('set null');
            $table->foreignId('marka_id')->nullable()->after('kategori_id')->constrained('markalar')->onDelete('set null');
            $table->boolean('durum')->default(true)->after('barkod');
            $table->decimal('agirlik', 8, 2)->nullable()->after('durum');
            $table->json('boyutlar')->nullable()->after('agirlik'); // {en: 10, boy: 20, yukseklik: 5}
            $table->string('seo_baslik')->nullable()->after('boyutlar');
            $table->text('seo_aciklama')->nullable()->after('seo_baslik');
            $table->json('meta_etiketler')->nullable()->after('seo_aciklama');
            $table->softDeletes();
            
            // Indexes
            $table->index(['kategori_id', 'durum']);
            $table->index(['marka_id', 'durum']);
            $table->index(['durum', 'stok']);
            $table->index('barkod');
            $table->index('sku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('urunler', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'bayi_fiyat', 'minimum_stok', 'kategori_id', 'marka_id', 
                'durum', 'agirlik', 'boyutlar', 'seo_baslik', 
                'seo_aciklama', 'meta_etiketler'
            ]);
        });
    }
};
