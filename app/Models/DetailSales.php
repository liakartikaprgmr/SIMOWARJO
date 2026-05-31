<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSales extends Model
{
    use HasFactory;

    protected $table = 'detail_sales';

    protected $fillable = [
        'id_sales',
        'id_barang',
        'nama_produk',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    public function sales()
    {
        return $this->belongsTo(SalesHarian::class, 'id_sales');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
