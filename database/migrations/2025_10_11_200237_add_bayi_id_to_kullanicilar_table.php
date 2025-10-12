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
            $table->unsignedBigInteger('bayi_id')->nullable()->after('magaza_id');
            $table->foreign('bayi_id')->references('id')->on('bayiler')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kullanicilar', function (Blueprint $table) {
            $table->dropForeign(['bayi_id']);
            $table->dropColumn('bayi_id');
        });
    }
};