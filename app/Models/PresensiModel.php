<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiModel extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';

    protected $fillable = [
        'id_karyawan',
        'type',
        'foto_absensi',
        'lat',
        'lng', 
    ];

     protected $casts = [
        'lat' => 'decimal:6',
        'lng' => 'decimal:6',
    ];

    // Relasi ke KaryawanModel
    public function karyawan()
    {
        return $this->belongsTo(KaryawanModel::class, 'id_karyawan', 'id_karyawan');
    }
}
