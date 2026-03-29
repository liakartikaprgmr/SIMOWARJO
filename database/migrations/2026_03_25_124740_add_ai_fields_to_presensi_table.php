<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            $table->decimal('ai_distance', 5, 3)->nullable()->after('distance');
            $table->integer('ai_score')->nullable()->after('ai_distance');  // 0-100
        });
    }

    public function down(): void
    {
        Schema::table('presensi', function (Blueprint $table) {
            //
        });
    }
};
