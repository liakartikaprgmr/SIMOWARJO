<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeolokasiModel extends Model
{
    protected $table = 'geolokasi';
    protected $primaryKey = 'id_geolokasi';

    protected $fillable = [
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius'
    ];
}
