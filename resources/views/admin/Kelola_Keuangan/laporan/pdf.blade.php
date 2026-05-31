<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan {{ $namaBulan }} {{ $tahun }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        .header {
            background: #7f1d1d;
            color: white;
            padding: 20px 24px 16px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .header p {
            font-size: 11px;
            opacity: 0.8;
            margin-top: 3px;
        }

        .meta {
            padding: 12px 24px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            gap: 40px;
        }

        .meta-item label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9ca3af;
            display: block;
        }

        .meta-item span {
            font-size: 12px;
            font-weight: 700;
            color: #111827;
        }

        .content {
            padding: 16px 24px;
        }

        .summary {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .summary-box {
            flex: 1;
            border-radius: 8px;
            padding: 10px 14px;
        }

        .summary-box.green {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .summary-box.red {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .summary-box.blue {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .summary-box label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 4px;
        }

        .summary-box.green label {
            color: #16a34a;
        }

        .summary-box.red label {
            color: #dc2626;
        }

        .summary-box.blue label {
            color: #2563eb;
        }

        .summary-box .amount {
            font-size: 14px;
            font-weight: 800;
        }

        .summary-box.green .amount {
            color: #15803d;
        }

        .summary-box.red .amount {
            color: #b91c1c;
        }

        .summary-box.blue .amount {
            color: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        thead tr {
            background: #7f1d1d;
            color: white;
        }

        thead th {
            padding: 8px 10px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        thead th.right {
            text-align: right;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        tbody td {
            padding: 6px 10px;
            font-size: 10px;
            border-bottom: 1px solid #f3f4f6;
        }

        tbody td.right {
            text-align: right;
        }

        tbody td.green {
            color: #15803d;
            font-weight: 600;
        }

        tbody td.red {
            color: #b91c1c;
            font-weight: 600;
        }

        tfoot tr {
            background: #1f2937;
            color: white;
        }

        tfoot td {
            padding: 8px 10px;
            font-size: 11px;
            font-weight: 700;
        }

        tfoot td.right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
        }

        .badge-sales {
            background: #dcfce7;
            color: #166534;
        }

        .badge-barang {
            background: #ffedd5;
            color: #9a3412;
        }

        .badge-gaji {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .badge-ops {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-lain {
            background: #f3f4f6;
            color: #374151;
        }

        .footer {
            margin-top: 20px;
            padding: 10px 24px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>SIMOWARJO — Laporan Kas</h1>
        <p>Periode: {{ $namaBulan }} {{ $tahun }} &nbsp;|&nbsp; Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB
        </p>
    </div>

    <div class="meta">
        <div class="meta-item">
            <label>Pemasukan</label>
            <span>Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
        </div>
        <div class="meta-item">
            <label>Pengeluaran</label>
            <span>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
        </div>
        <div class="meta-item">
            <label>Laba / Rugi</label>
            <span style="{{ $labaBersih >= 0 ? 'color:#15803d' : 'color:#b91c1c' }}">
                Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
                {{ $labaBersih < 0 ? '(RUGI)' : '' }}
            </span>
        </div>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th style="width:20px">No</th>
                    <th style="width:70px">Tanggal</th>
                    <th style="width:80px">Kategori</th>
                    <th>Keterangan</th>
                    <th class="right" style="width:90px">Pemasukan</th>
                    <th class="right" style="width:90px">Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $i => $trx)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $badgeClass = $trx->jenis == 'pemasukan' ? 'badge-sales' : 'badge-barang';
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $trx->label_kategori }}</span>
                        </td>
                        <td>{{ $trx->keterangan }}</td>
                        <td class="right green">
                            {{ $trx->jenis === 'pemasukan' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '' }}
                        </td>
                        <td class="right red">
                            {{ $trx->jenis === 'pengeluaran' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">TOTAL KESELURUHAN</td>
                    <td class="right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <span>SIMOWARJO — Sistem Informasi Manajemen Warjo &copy; {{ date('Y') }}</span>
        <span>Laporan {{ $namaBulan }} {{ $tahun }}</span>
    </div>

</body>

</html>