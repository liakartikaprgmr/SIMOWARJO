<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\PresensiModel;


class KaryawanModel extends Authenticatable
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = [
        'nama',
        'email',
        'password',
        'no_hp',
        'jabatan',
        'tanggal_masuk',
        'foto',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'id_karyawan';
    }

    public function presensi()
    {
        return $this->hasMany(PresensiModel::class, 'id_karyawan', 'id_karyawan');
    }

    public function getUserById($id_karyawan)
    {
    return $this->where('id_karyawan', $id_karyawan)->first(); // Mengambil satu data berdasarkan id_karyawan
    }

    public function updateUser ($id_karyawan, $data)
    {
        // Update data pengguna
        return $this->update($id_karyawan, $data);
    }

    public function delete_data($id_karyawan)
    {
        return self::where('id_karyawan', $id_karyawan)->delete();
    }

}
