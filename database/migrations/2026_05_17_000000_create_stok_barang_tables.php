<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kategori_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama', 150);
            $table->foreignId('id_kategori')->constrained('kategori_barang')->onDelete('restrict');
            $table->string('satuan', 30);
            $table->integer('stok_saat_ini')->default(0);
            $table->integer('stok_minimum')->default(0);
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('barang')->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->string('supplier', 150)->nullable();
            $table->string('no_faktur', 50)->nullable();
            $table->date('tanggal');
            $table->unsignedBigInteger('id_karyawan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->constrained('barang')->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('penerima', 150);
            $table->string('keperluan', 255);
            $table->date('tanggal');
            $table->unsignedBigInteger('id_karyawan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_keluar');
        Schema::dropIfExists('barang_masuk');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('kategori_barang');
    }
};
