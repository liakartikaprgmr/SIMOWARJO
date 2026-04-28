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
        Schema::table('penggajian', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['tunai', 'transfer'])->nullable();
            $table->string('midtrans_reference_no')->nullable();
            $table->string('midtrans_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'midtrans_reference_no', 'midtrans_status']);
        });
    }
};
