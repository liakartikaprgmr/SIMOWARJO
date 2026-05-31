<?php

namespace App\Exports;

use App\Models\KeuanganModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class KeuanganExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return KeuanganModel::periode($this->bulan, $this->tahun)
            ->with('pembuat')
            ->orderBy('tanggal')
            ->orderBy('jenis')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis Transaksi',
            'Kategori',
            'Keterangan',
            'Jumlah (Rp)',
            'Diinput Oleh'
        ];
    }

    public function map($transaksi): array
    {
        return [
            Carbon::parse($transaksi->tanggal)->format('d-m-Y'),
            ucfirst($transaksi->jenis),
            ucfirst($transaksi->kategori),
            $transaksi->keterangan ?? '-',
            $transaksi->jumlah,
            $transaksi->pembuat?->nama ?? 'Sistem'
        ];
    }
}
