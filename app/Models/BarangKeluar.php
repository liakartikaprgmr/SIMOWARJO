<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluar';
    protected $fillable = [
        'id_barang', 'jumlah', 'penerima', 'keperluan',
        'tanggal', 'id_karyawan', 'catatan',
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
