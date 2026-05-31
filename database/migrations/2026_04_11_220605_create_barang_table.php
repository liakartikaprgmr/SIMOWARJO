<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama', 150);
            $table->foreignId('id_kategori')->constrained('kategori_barang')->onDelete('restrict');
            $table->string('satuan', 30); // pcs, kg, liter, box, dll
            $table->integer('stok_saat_ini')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
