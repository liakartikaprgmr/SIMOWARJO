<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';
    protected $fillable = [
        'id_barang', 'jumlah', 'harga_satuan', 'total_harga',
        'supplier', 'no_faktur', 'tanggal', 'id_karyawan', 'catatan',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'id_karyawan', 'id_karyawan');
    }
}
