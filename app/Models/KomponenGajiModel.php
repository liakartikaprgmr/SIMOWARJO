<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomponenGajiModel extends Model
{
    protected $table = 'komponen_gaji';
    protected $primaryKey = 'id_komponen';
    
    protected $fillable = [
        'id_karyawan',
        'gaji_pokok',
        'tunjangan_jabatan',
        'insentif_skill'
    ];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'id_karyawan', 'id_karyawan');
    }

    public function penggajian()
    {
        return $this->hasMany(PenggajianModel::class, 'id_karyawan', 'id_karyawan');
    }
}
