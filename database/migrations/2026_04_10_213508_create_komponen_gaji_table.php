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
        Schema::create('komponen_gaji', function (Blueprint $table) {
            $table->id('id_komponen');
            $table->unsignedBigInteger('id_karyawan');
            $table->integer('gaji_pokok')->default(3000000);
            $table->integer('tunjangan_jabatan')->default(0);
            $table->integer('insentif_skill')->default(0);
            $table->timestamps();

            // Opsional: Jika karyawan table pake PK id_karyawan, tambahkan FK
            // $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_gaji');
    }
};
