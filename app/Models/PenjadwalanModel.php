<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjadwalanModel extends Model
{
    use HasFactory;

    protected $table = 'penjadwalan';
    protected $primaryKey = 'id_jadwalan';

    protected $fillable = [
        'id_karyawan',
        'shift',
        'jam_masuk',
        'jam_pulang',
        'tanggal',
    ];

    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'id_karyawan', 'id_karyawan');
    }
}
