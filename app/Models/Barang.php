<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'kode_barang', 'nama', 'id_kategori', 'satuan',
        'stok_saat_ini', 'stok_minimum', 'harga_satuan', 'deskripsi',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_barang');
    }

    public function isStokRendah(): bool
    {
        return $this->stok_saat_ini <= $this->stok_minimum;
    }
}
