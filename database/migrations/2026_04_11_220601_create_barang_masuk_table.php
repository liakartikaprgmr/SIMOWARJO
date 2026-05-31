<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('barang')->onDelete('restrict');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->string('supplier', 150);
            $table->string('no_faktur', 100)->nullable();
            $table->date('tanggal');
            $table->foreignId('id_karyawan')->constrained('karyawan', 'id_karyawan')->onDelete('restrict');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
