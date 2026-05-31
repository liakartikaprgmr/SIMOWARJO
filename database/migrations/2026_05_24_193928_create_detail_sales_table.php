<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_sales')
                ->constrained('penjualan_harian')
                ->onDelete('cascade');

            $table->string('nama_produk');
            $table->integer('qty')->default(1);
            $table->decimal('harga', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_sales');
    }
};