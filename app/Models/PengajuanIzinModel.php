<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanIzinModel extends Model
{
    protected $table = 'pengajuan_izin';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'id_karyawan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis',
        'keterangan',
        'bukti_foto',
        'status',
    ];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'id_karyawan', 'id_karyawan');
    }
}
