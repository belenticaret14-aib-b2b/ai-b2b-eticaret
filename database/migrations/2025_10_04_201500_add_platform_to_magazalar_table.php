<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magazalar', function (Blueprint $table) {
            if (!Schema::hasColumn('magazalar', 'platform')) {
                $table->string('platform')->nullable()->after('ad');
            }
        });
    }

    public function down(): void
    {
        Schema::table('magazalar', function (Blueprint $table) {
            if (Schema::hasColumn('magazalar', 'platform')) {
                $table->dropColumn('platform');
            }
        });
    }
};
