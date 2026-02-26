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
        if (!Schema::hasColumn('stock_keluars', 'kualitas')) {
            Schema::table('stock_keluars', function (Blueprint $table) {
                $table->string('kualitas')->nullable()->after('jumlah');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('stock_keluars', 'kualitas')) {
            Schema::table('stock_keluars', function (Blueprint $table) {
                $table->dropColumn('kualitas');
            });
        }
    }
};
