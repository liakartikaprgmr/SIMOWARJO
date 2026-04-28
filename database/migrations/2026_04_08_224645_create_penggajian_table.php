<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->bigIncrements('id_penggajian');
            $table->unsignedBigInteger('id_karyawan');
            $table->string('periode');
            $table->integer('gaji_pokok')->default(3000000);
            $table->integer('jumlah_hadir')->default(0);
            $table->integer('jumlah_izin')->default(0);
            $table->integer('jumlah_sakit')->default(0);
            $table->integer('jumlah_alpa')->default(0);
            $table->integer('total_potongan')->default(0);
            $table->integer('total_gaji')->default(0);
            $table->string('status_pembayaran')->default('tertunda');
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};
