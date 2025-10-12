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
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->unsignedBigInteger('magaza_id')->nullable()->after('rol');
            $table->foreign('magaza_id')->references('id')->on('magazalar')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->dropForeign(['magaza_id']);
            $table->dropColumn('magaza_id');
        });
    }
};