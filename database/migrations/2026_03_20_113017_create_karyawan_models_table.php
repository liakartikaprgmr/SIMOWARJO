<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->string('nama');
            $table->string('jabatan');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['supervisor','karyawan','leader_shift']);
            $table->string('no_hp')->nullable();
            $table->date('tanggal_masuk');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
