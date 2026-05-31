<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBarang;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\KaryawanModel;
use Carbon\Carbon;

class StokBarangSeeder extends Seeder
{
    public function run(): void
    {
        $karyawan = KaryawanModel::first();
        if (!$karyawan) {
            $this->command->error('Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        // KATEGORI BARANG
        $kategoriData = [
            ['nama' => 'Bahan Baku Utama', 'deskripsi' => 'Bahan utama untuk proses produksi makanan dan minuman'],
            ['nama' => 'Minuman & Pelengkap', 'deskripsi' => 'Produk minuman, topping, saus, dan pelengkap lainnya'],
            ['nama' => 'Peralatan Dapur', 'deskripsi' => 'Alat masak dan perlengkapan dapur restoran'],
            ['nama' => 'Peralatan Makan & Sajian', 'deskripsi' => 'Piring, gelas, sendok, kemasan, dan alat penyajian'],
            ['nama' => 'Kebersihan & Sanitasi', 'deskripsi' => 'Produk kebersihan, sanitizer, sabun, dan alat kebersihan'],
            ['nama' => 'ATK & Perlengkapan Kantor', 'deskripsi' => 'Kebutuhan administrasi dan perlengkapan kantor'],
            ['nama' => 'Peralatan Operasional', 'deskripsi' => 'Peralatan pendukung aktivitas operasional restoran'],
            ['nama' => 'Kemasan & Packaging', 'deskripsi' => 'Plastik, box makanan, cup, sedotan, dan kemasan lainnya'],
            ['nama' => 'Gas & Bahan Bakar', 'deskripsi' => 'Gas LPG, arang, dan bahan bakar operasional'],
            ['nama' => 'Inventaris Restoran', 'deskripsi' => 'Barang inventaris jangka panjang restoran'],
            ['nama' => 'Barang Non-Konsumsi', 'deskripsi' => 'Barang pendukung yang tidak digunakan langsung untuk produksi'],
            ['nama' => 'Produk Jadi', 'deskripsi' => 'Makanan atau minuman siap jual'],
            ['nama' => 'Lain-lain', 'deskripsi' => 'Barang di luar kategori yang tersedia'],
        ];

        $kategori = [];
        foreach ($kategoriData as $d) {
            $kategori[] = KategoriBarang::updateOrCreate(['nama' => $d['nama']], $d);
        }

        // MASTER BARANG (30 item realistis)
        $barangData = [
            // Bahan Baku Utama (idx 0)
            ['kode' => 'BB-001', 'nama' => 'Tepung Terigu Premium', 'kategori' => 0, 'satuan' => 'kg', 'stok' => 0, 'min' => 50, 'harga' => 12000],
            ['kode' => 'BB-002', 'nama' => 'Gula Pasir Lokal', 'kategori' => 0, 'satuan' => 'kg', 'stok' => 0, 'min' => 30, 'harga' => 15500],
            ['kode' => 'BB-003', 'nama' => 'Minyak Goreng Curah', 'kategori' => 0, 'satuan' => 'liter', 'stok' => 0, 'min' => 20, 'harga' => 17000],
            ['kode' => 'BB-004', 'nama' => 'Garam Halus', 'kategori' => 0, 'satuan' => 'kg', 'stok' => 0, 'min' => 10, 'harga' => 3000],
            ['kode' => 'BB-005', 'nama' => 'Tepung Maizena', 'kategori' => 0, 'satuan' => 'kg', 'stok' => 0, 'min' => 15, 'harga' => 18000],
            // Kemasan & Packaging (idx 7)
            ['kode' => 'BP-001', 'nama' => 'Plastik Kemasan 250gr', 'kategori' => 7, 'satuan' => 'pcs', 'stok' => 0, 'min' => 500, 'harga' => 500],
            ['kode' => 'BP-002', 'nama' => 'Karton Box Medium', 'kategori' => 7, 'satuan' => 'pcs', 'stok' => 0, 'min' => 100, 'harga' => 7500],
            ['kode' => 'BP-003', 'nama' => 'Lakban Coklat 48mm', 'kategori' => 7, 'satuan' => 'roll', 'stok' => 0, 'min' => 20, 'harga' => 12000],
            ['kode' => 'BP-004', 'nama' => 'Tali Rafia 500m', 'kategori' => 7, 'satuan' => 'roll', 'stok' => 0, 'min' => 5, 'harga' => 35000],
            ['kode' => 'BP-005', 'nama' => 'Label Stiker Produk', 'kategori' => 7, 'satuan' => 'lembar', 'stok' => 0, 'min' => 200, 'harga' => 200],
            // ATK & Perlengkapan Kantor (idx 5)
            ['kode' => 'PK-001', 'nama' => 'Kertas HVS A4 70gr', 'kategori' => 5, 'satuan' => 'rim', 'stok' => 0, 'min' => 10, 'harga' => 55000],
            ['kode' => 'PK-002', 'nama' => 'Pulpen Ballpoint Biru', 'kategori' => 5, 'satuan' => 'pcs', 'stok' => 0, 'min' => 20, 'harga' => 3500],
            ['kode' => 'PK-003', 'nama' => 'Tinta Printer Hitam', 'kategori' => 5, 'satuan' => 'botol', 'stok' => 0, 'min' => 5, 'harga' => 85000],
            ['kode' => 'PK-004', 'nama' => 'Stapler + Isi', 'kategori' => 5, 'satuan' => 'set', 'stok' => 0, 'min' => 3, 'harga' => 45000],
            ['kode' => 'PK-005', 'nama' => 'Buku Nota A5', 'kategori' => 5, 'satuan' => 'pcs', 'stok' => 0, 'min' => 10, 'harga' => 8000],
            // Peralatan Operasional (idx 6)
            ['kode' => 'PL-001', 'nama' => 'Sarung Tangan Karet L', 'kategori' => 6, 'satuan' => 'pasang', 'stok' => 0, 'min' => 10, 'harga' => 15000],
            ['kode' => 'PL-003', 'nama' => 'Sepatu Safety Size 42', 'kategori' => 6, 'satuan' => 'pasang', 'stok' => 0, 'min' => 3, 'harga' => 285000],
            ['kode' => 'PL-004', 'nama' => 'Masker N95', 'kategori' => 6, 'satuan' => 'box', 'stok' => 0, 'min' => 5, 'harga' => 120000],
            // Kebersihan & Sanitasi (idx 4)
            ['kode' => 'KB-001', 'nama' => 'Sabun Cuci Cair 1L', 'kategori' => 4, 'satuan' => 'botol', 'stok' => 0, 'min' => 10, 'harga' => 25000],
            ['kode' => 'KB-002', 'nama' => 'Karbol Wangi 800ml', 'kategori' => 4, 'satuan' => 'botol', 'stok' => 0, 'min' => 10, 'harga' => 18000],
            ['kode' => 'KB-003', 'nama' => 'Sapu Lidi', 'kategori' => 4, 'satuan' => 'pcs', 'stok' => 0, 'min' => 5, 'harga' => 22000],
            ['kode' => 'KB-004', 'nama' => 'Pel Lantai', 'kategori' => 4, 'satuan' => 'pcs', 'stok' => 0, 'min' => 3, 'harga' => 45000],
            ['kode' => 'KB-005', 'nama' => 'Tisu Roll 12pcs', 'kategori' => 4, 'satuan' => 'pack', 'stok' => 0, 'min' => 5, 'harga' => 35000],
            // Barang Non-Konsumsi (idx 10)
            ['kode' => 'SP-002', 'nama' => 'Filter Udara Universal', 'kategori' => 10, 'satuan' => 'pcs', 'stok' => 0, 'min' => 3, 'harga' => 75000],
            ['kode' => 'SP-003', 'nama' => 'Baut M8x30mm', 'kategori' => 10, 'satuan' => 'pcs', 'stok' => 0, 'min' => 50, 'harga' => 1500],
            ['kode' => 'SP-005', 'nama' => 'Bearing 6205', 'kategori' => 10, 'satuan' => 'pcs', 'stok' => 0, 'min' => 3, 'harga' => 95000],
        ];

        $barangs = [];
        foreach ($barangData as $d) {
            $barangs[] = Barang::updateOrCreate(
                ['kode_barang' => $d['kode']],
                [
                    'nama' => $d['nama'],
                    'id_kategori' => $kategori[$d['kategori']]->id,
                    'satuan' => $d['satuan'],
                    'stok_saat_ini' => 0,
                    'stok_minimum' => $d['min'],
                    'harga_satuan' => $d['harga'],
                ]
            );
        }

        // TRANSAKSI BARANG MASUK (3 bulan terakhir)
        $suppliers = [
            'PT. Sumber Makmur',
            'UD. Jaya Abadi',
            'CV. Mitra Sejahtera',
            'PT. Global Supply',
            'Toko Bangunan Maju',
            'PT. Indo Bahan',
            'Distributor Utama',
            'CV. Karya Mandiri',
        ];

        $masukData = [
            // bulan lalu & bulan ini
            ['barang' => 0, 'jml' => 200, 'supplier' => 0, 'faktur' => 'INV-2026-0301'],
            ['barang' => 1, 'jml' => 150, 'supplier' => 1, 'faktur' => 'INV-2026-0302'],
            ['barang' => 2, 'jml' => 50, 'supplier' => 2, 'faktur' => 'INV-2026-0303'],
            ['barang' => 5, 'jml' => 2000, 'supplier' => 3, 'faktur' => 'INV-2026-0310'],
            ['barang' => 6, 'jml' => 300, 'supplier' => 3, 'faktur' => 'INV-2026-0311'],
            ['barang' => 10, 'jml' => 30, 'supplier' => 4, 'faktur' => 'INV-2026-0315'],
            ['barang' => 15, 'jml' => 20, 'supplier' => 5, 'faktur' => 'INV-2026-0316'],
            ['barang' => 20, 'jml' => 30, 'supplier' => 6, 'faktur' => 'INV-2026-0320'],
            ['barang' => 25, 'jml' => 20, 'supplier' => 7, 'faktur' => 'INV-2026-0322'],
            ['barang' => 3, 'jml' => 100, 'supplier' => 1, 'faktur' => 'INV-2026-0325'],
            ['barang' => 4, 'jml' => 60, 'supplier' => 2, 'faktur' => 'INV-2026-0326'],
            // bulan ini
            ['barang' => 0, 'jml' => 250, 'supplier' => 0, 'faktur' => 'INV-2026-0401'],
            ['barang' => 1, 'jml' => 120, 'supplier' => 1, 'faktur' => 'INV-2026-0402'],
            ['barang' => 7, 'jml' => 50, 'supplier' => 3, 'faktur' => 'INV-2026-0405'],
            ['barang' => 8, 'jml' => 15, 'supplier' => 2, 'faktur' => 'INV-2026-0406'],
            ['barang' => 11, 'jml' => 100, 'supplier' => 4, 'faktur' => 'INV-2026-0407'],
            ['barang' => 12, 'jml' => 20, 'supplier' => 4, 'faktur' => 'INV-2026-0408'],
            ['barang' => 16, 'jml' => 15, 'supplier' => 5, 'faktur' => 'INV-2026-0410'],
            ['barang' => 21, 'jml' => 20, 'supplier' => 6, 'faktur' => 'INV-2026-0410'],
            ['barang' => 26, 'jml' => 20, 'supplier' => 7, 'faktur' => 'INV-2026-0411'],
            ['barang' => 27, 'jml' => 200, 'supplier' => 7, 'faktur' => 'INV-2026-0411'],
            ['barang' => 28, 'jml' => 10, 'supplier' => 0, 'faktur' => 'INV-2026-0411'],
            ['barang' => 9, 'jml' => 500, 'supplier' => 3, 'faktur' => 'INV-2026-0411'],
            ['barang' => 13, 'jml' => 10, 'supplier' => 4, 'faktur' => 'INV-2026-0411'],
            ['barang' => 14, 'jml' => 25, 'supplier' => 2, 'faktur' => 'INV-2026-0411'],
        ];

        $tanggalMasuk = [
            Carbon::now()->subDays(40),
            Carbon::now()->subDays(38),
            Carbon::now()->subDays(35),
            Carbon::now()->subDays(32),
            Carbon::now()->subDays(30),
            Carbon::now()->subDays(28),
            Carbon::now()->subDays(27),
            Carbon::now()->subDays(25),
            Carbon::now()->subDays(22),
            Carbon::now()->subDays(20),
            Carbon::now()->subDays(18),
            Carbon::now()->subDays(10),
            Carbon::now()->subDays(9),
            Carbon::now()->subDays(7),
            Carbon::now()->subDays(6),
            Carbon::now()->subDays(5),
            Carbon::now()->subDays(5),
            Carbon::now()->subDays(3),
            Carbon::now()->subDays(3),
            Carbon::now()->subDays(1),
            Carbon::now()->subDays(1),
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
            Carbon::now(),
        ];

        foreach ($masukData as $i => $d) {
            $b = $barangs[$d['barang']];
            $harga = $b->harga_satuan;
            BarangMasuk::create([
                'id_barang' => $b->id,
                'jumlah' => $d['jml'],
                'harga_satuan' => $harga,
                'total_harga' => $d['jml'] * $harga,
                'supplier' => $suppliers[$d['supplier']],
                'no_faktur' => $d['faktur'],
                'tanggal' => $tanggalMasuk[$i]->format('Y-m-d'),
                'id_karyawan' => $karyawan->id_karyawan,
            ]);
            $b->increment('stok_saat_ini', $d['jml']);
        }

        // TRANSAKSI BARANG KELUAR
        $penerima = [
            'Divisi Produksi',
            'Gudang Utama',
            'Divisi Marketing',
            'Bagian Maintenance',
            'Divisi HRD',
            'Divisi Finance',
            'Tim Lapangan',
        ];
        $keperluan = [
            'Kebutuhan produksi harian',
            'Penggantian stok habis',
            'Permintaan divisi',
            'Perawatan mesin rutin',
            'Operasional kantor',
            'Keperluan event',
            'Perbaikan fasilitas',
        ];

        $keluarData = [
            ['barang' => 0, 'jml' => 80, 'penerima' => 0, 'keperluan' => 0],
            ['barang' => 1, 'jml' => 50, 'penerima' => 0, 'keperluan' => 0],
            ['barang' => 2, 'jml' => 20, 'penerima' => 0, 'keperluan' => 0],
            ['barang' => 5, 'jml' => 500, 'penerima' => 1, 'keperluan' => 1],
            ['barang' => 6, 'jml' => 80, 'penerima' => 2, 'keperluan' => 5],
            ['barang' => 10, 'jml' => 8, 'penerima' => 2, 'keperluan' => 4],
            ['barang' => 11, 'jml' => 30, 'penerima' => 4, 'keperluan' => 4],
            ['barang' => 15, 'jml' => 5, 'penerima' => 6, 'keperluan' => 3],
            ['barang' => 20, 'jml' => 8, 'penerima' => 3, 'keperluan' => 2],
            ['barang' => 25, 'jml' => 5, 'penerima' => 3, 'keperluan' => 3],
            ['barang' => 3, 'jml' => 30, 'penerima' => 0, 'keperluan' => 0],
            ['barang' => 4, 'jml' => 15, 'penerima' => 0, 'keperluan' => 0],
            // bulan ini
            ['barang' => 0, 'jml' => 100, 'penerima' => 0, 'keperluan' => 0],
            ['barang' => 1, 'jml' => 60, 'penerima' => 0, 'keperluan' => 0],
            ['barang' => 7, 'jml' => 20, 'penerima' => 1, 'keperluan' => 1],
            ['barang' => 12, 'jml' => 3, 'penerima' => 4, 'keperluan' => 4],
            ['barang' => 16, 'jml' => 5, 'penerima' => 6, 'keperluan' => 3],
            ['barang' => 21, 'jml' => 5, 'penerima' => 3, 'keperluan' => 2],
            ['barang' => 27, 'jml' => 50, 'penerima' => 3, 'keperluan' => 3],
            ['barang' => 9, 'jml' => 200, 'penerima' => 0, 'keperluan' => 0],
        ];

        $tanggalKeluar = [
            Carbon::now()->subDays(38),
            Carbon::now()->subDays(35),
            Carbon::now()->subDays(32),
            Carbon::now()->subDays(30),
            Carbon::now()->subDays(28),
            Carbon::now()->subDays(27),
            Carbon::now()->subDays(25),
            Carbon::now()->subDays(22),
            Carbon::now()->subDays(20),
            Carbon::now()->subDays(18),
            Carbon::now()->subDays(15),
            Carbon::now()->subDays(12),
            Carbon::now()->subDays(8),
            Carbon::now()->subDays(7),
            Carbon::now()->subDays(5),
            Carbon::now()->subDays(4),
            Carbon::now()->subDays(3),
            Carbon::now()->subDays(2),
            Carbon::now()->subDays(1),
            Carbon::now(),
        ];

        foreach ($keluarData as $i => $d) {
            $b = $barangs[$d['barang']];
            $stokTersedia = $b->fresh()->stok_saat_ini;
            $jumlah = min($d['jml'], max(0, $stokTersedia - 1));
            if ($jumlah <= 0)
                continue;

            BarangKeluar::create([
                'id_barang' => $b->id,
                'jumlah' => $jumlah,
                'penerima' => $penerima[$d['penerima']],
                'keperluan' => $keperluan[$d['keperluan']],
                'tanggal' => $tanggalKeluar[$i]->format('Y-m-d'),
                'id_karyawan' => $karyawan->id_karyawan,
            ]);
            $b->decrement('stok_saat_ini', $jumlah);
        }

        $this->command->info('✓ Seeder stok barang selesai: ' . count($barangs) . ' barang, ' . count($masukData) . ' masuk, ' . count($keluarData) . ' keluar.');
    }
}
