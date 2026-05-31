<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('barang')->onDelete('restrict');
            $table->integer('jumlah');
            $table->string('penerima', 150);
            $table->string('keperluan', 255);
            $table->date('tanggal');
            $table->foreignId('id_karyawan')->constrained('karyawan', 'id_karyawan')->onDelete('restrict');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
