<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);
            $table->string('kategori', 50);
            $table->decimal('jumlah', 15, 2);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->string('referensi_type')->nullable();
            $table->unsignedBigInteger('referensi_id')->nullable();

            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('penjualan_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('shift', ['pagi', 'siang', 'malam']);
            $table->decimal('total_penjualan', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('detail_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sales');
            $table->unsignedBigInteger('id_barang')->nullable();
            $table->string('nama_produk', 150);
            $table->integer('qty');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('id_sales')->references('id')->on('penjualan_harian')->cascadeOnDelete();
            $table->foreign('id_barang')->references('id')->on('barang')->nullOnDelete();
        });

        Schema::create('pengeluaran_operasional', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_item', 150);
            $table->decimal('jumlah', 15, 2);
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_operasional');
        Schema::dropIfExists('detail_sales');
        Schema::dropIfExists('penjualan_harian');
        Schema::dropIfExists('keuangan');
    }
};
