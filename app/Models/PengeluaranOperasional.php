<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\KeuanganModel;

class PengeluaranOperasional extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_operasional';

    protected $fillable = [
        'tanggal',
        'nama_item',
        'jumlah',
        'keterangan',
        'dibuat_oleh',
    ];

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    protected static function boot()
    {
        parent::boot();

        // Buat KeuanganModel saat PengeluaranOperasional dibuat
        static::created(function ($pengeluaran) {
            KeuanganModel::create([
                'tanggal' => $pengeluaran->tanggal,
                'jenis' => 'pengeluaran',
                'kategori' => 'operasional',
                'jumlah' => $pengeluaran->jumlah,
                'keterangan' => $pengeluaran->nama_item . ($pengeluaran->keterangan ? ' - ' . $pengeluaran->keterangan : ''),
                'dibuat_oleh' => $pengeluaran->dibuat_oleh ?? Auth::id(),
                'referensi_type' => PengeluaranOperasional::class,
                'referensi_id' => $pengeluaran->id,
            ]);
        });

        // Update KeuanganModel saat PengeluaranOperasional diupdate
        static::updated(function ($pengeluaran) {
            $kas = KeuanganModel::where('referensi_type', PengeluaranOperasional::class)
                               ->where('referensi_id', $pengeluaran->id)
                               ->first();
            if ($kas) {
                $kas->update([
                    'tanggal' => $pengeluaran->tanggal,
                    'jumlah' => $pengeluaran->jumlah,
                    'keterangan' => $pengeluaran->nama_item . ($pengeluaran->keterangan ? ' - ' . $pengeluaran->keterangan : ''),
                ]);
            }
        });

        // Hapus KeuanganModel saat PengeluaranOperasional dihapus
        static::deleted(function ($pengeluaran) {
            KeuanganModel::where('referensi_type', PengeluaranOperasional::class)
                        ->where('referensi_id', $pengeluaran->id)
                        ->delete();
        });
    }
}
