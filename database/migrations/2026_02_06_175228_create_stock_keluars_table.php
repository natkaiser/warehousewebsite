<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_keluars', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');

            $table->foreignId('stock_id')
                  ->constrained('stocks')
                  ->cascadeOnDelete();

            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->cascadeOnDelete();

            $table->integer('jumlah');
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_keluars');
    }
};
