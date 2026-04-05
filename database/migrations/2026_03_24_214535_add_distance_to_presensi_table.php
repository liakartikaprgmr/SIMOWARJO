<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('presensi', function (Blueprint $table) {
        $table->decimal('distance', 8, 2)->nullable()->after('lng');  // Tambah kolom distance
    });
}

public function down()
{
    Schema::table('presensi', function (Blueprint $table) {
        $table->dropColumn('distance');
    });
}
};
