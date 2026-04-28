<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$karyawans = \App\Models\KaryawanModel::all();
foreach ($karyawans as $k) {
    if (!str_starts_with($k->password, '$2')) {
        $k->password = bcrypt($k->password);
        $k->save();
        echo "Updated password for Karyawan: " . $k->email . "\n";
    }
}

echo "Done.\n";
