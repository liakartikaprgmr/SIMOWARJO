<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggajianModel extends Model
{
    protected $table = 'penggajian';
    protected $primaryKey = 'id_penggajian';

    protected $fillable = [
        'id_karyawan',
        'periode',
        'gaji_pokok',
        'jumlah_hadir',
        'jumlah_izin',
        'jumlah_sakit',
        'jumlah_alpa',
        'total_potongan',
        'total_gaji',
        'status_pembayaran',
        'metode_pembayaran',
        'midtrans_reference_no',
        'midtrans_status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'id_karyawan', 'id_karyawan');
    }

    public function komponenGaji()
    {
        return $this->hasOne(KomponenGajiModel::class, 'id_karyawan', 'id_karyawan');
    }
}
