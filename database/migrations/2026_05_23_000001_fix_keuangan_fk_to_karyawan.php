<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $this->dropFkIfExists('kas_transaksi', 'kas_transaksi_dibuat_oleh_foreign');
        $this->dropFkIfExists('sales_harian', 'sales_harian_dibuat_oleh_foreign');
        $this->dropFkIfExists('pengeluaran_operasional', 'pengeluaran_operasional_dibuat_oleh_foreign');

        DB::statement('ALTER TABLE `kas_transaksi` ADD CONSTRAINT `kas_transaksi_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL');
        DB::statement('ALTER TABLE `sales_harian` ADD CONSTRAINT `sales_harian_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL');
        DB::statement('ALTER TABLE `pengeluaran_operasional` ADD CONSTRAINT `pengeluaran_operasional_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE SET NULL');
    }

    public function down(): void
    {
        $this->dropFkIfExists('kas_transaksi', 'kas_transaksi_dibuat_oleh_foreign');
        $this->dropFkIfExists('sales_harian', 'sales_harian_dibuat_oleh_foreign');
        $this->dropFkIfExists('pengeluaran_operasional', 'pengeluaran_operasional_dibuat_oleh_foreign');

        DB::statement('ALTER TABLE `kas_transaksi` ADD CONSTRAINT `kas_transaksi_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL');
        DB::statement('ALTER TABLE `sales_harian` ADD CONSTRAINT `sales_harian_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL');
        DB::statement('ALTER TABLE `pengeluaran_operasional` ADD CONSTRAINT `pengeluaran_operasional_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL');
    }

    private function dropFkIfExists(string $table, string $constraint): void
    {
        $exists = DB::select("
            SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = ?
              AND CONSTRAINT_NAME = ?
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ", [$table, $constraint]);

        if (!empty($exists)) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$constraint}`");
        }
    }
};
