<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('urunler', function (Blueprint $table) {
            if (!Schema::hasColumn('urunler', 'gorsel')) {
                $table->string('gorsel')->nullable()->after('barkod');
            }
        });
    }

    public function down(): void
    {
        Schema::table('urunler', function (Blueprint $table) {
            if (Schema::hasColumn('urunler', 'gorsel')) {
                $table->dropColumn('gorsel');
            }
        });
    }
};
