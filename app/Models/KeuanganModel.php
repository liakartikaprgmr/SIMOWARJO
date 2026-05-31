<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\KaryawanModel;

class KeuanganModel extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'tanggal',
        'jenis',
        'kategori',
        'jumlah',
        'keterangan',
        'dibuat_oleh',
        'referensi_type',
        'referensi_id',
    ];

    public function pembuat()
    {
        return $this->belongsTo(KaryawanModel::class, 'dibuat_oleh', 'id_karyawan');
    }

    public function scopePeriode(Builder $query, $bulan, $tahun)
    {
        return $query->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);
    }

    public function scopePemasukan(Builder $query)
    {
        return $query->where('jenis', 'pemasukan');
    }

    public function scopePengeluaran(Builder $query)
    {
        return $query->where('jenis', 'pengeluaran');
    }

    // Accessors for view presentation
    public function getLabelKategoriAttribute()
    {
        return match ($this->kategori) {
            'sales' => 'Penjualan',
            'barang_masuk' => 'Pembelian Barang',
            'gaji' => 'Penggajian',
            'operasional' => 'Operasional',
            default => ucfirst($this->kategori),
        };
    }

    public function getBadgeKategoriAttribute()
    {
        return match ($this->jenis) {
            'pemasukan' => 'bg-green-100 text-green-700',
            'pengeluaran' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
