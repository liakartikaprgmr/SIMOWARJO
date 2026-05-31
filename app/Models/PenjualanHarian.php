<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\KeuanganModel;
use App\Models\KaryawanModel;

class PenjualanHarian extends Model
{
    use HasFactory;

    protected $table = 'penjualan_harian';

    protected $fillable = [
        'tanggal',
        'shift',
        'total_penjualan',
        'keterangan',
        'dibuat_oleh',
    ];

    public function pembuat()
    {
        return $this->belongsTo(KaryawanModel::class, 'dibuat_oleh', 'id_karyawan');
    }

    public function details()
    {
        return $this->hasMany(DetailSales::class, 'id_sales');
    }

    protected static function boot()
    {
        parent::boot();

        // Buat KeuanganModel saat SalesHarian dibuat
        static::created(function ($sales) {
            KeuanganModel::create([
                'tanggal' => $sales->tanggal,
                'jenis' => 'pemasukan',
                'kategori' => 'sales',
                'jumlah' => $sales->total_penjualan,
                'keterangan' => 'Penjualan Shift ' . ucfirst($sales->shift) . ($sales->keterangan ? ' - ' . $sales->keterangan : ''),
                'dibuat_oleh' => $sales->dibuat_oleh ?? Auth::id(),
                'referensi_type' => PenjualanHarian::class,
                'referensi_id' => $sales->id,
            ]);
        });

        // Update KeuanganModel saat SalesHarian diupdate
        static::updated(function ($sales) {
            $kas = KeuanganModel::where('referensi_type', PenjualanHarian::class)
                ->where('referensi_id', $sales->id)
                ->first();
            if ($kas) {
                $kas->update([
                    'tanggal' => $sales->tanggal,
                    'jumlah' => $sales->total_penjualan,
                    'keterangan' => 'Penjualan Shift ' . ucfirst($sales->shift) . ($sales->keterangan ? ' - ' . $sales->keterangan : ''),
                ]);
            }
        });

        // Hapus KeuanganModel saat SalesHarian dihapus
        static::deleted(function ($sales) {
            KeuanganModel::where('referensi_type', PenjualanHarian::class)
                ->where('referensi_id', $sales->id)
                ->delete();
        });
    }
}
