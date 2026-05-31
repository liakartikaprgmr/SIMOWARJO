<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // Dashboard stok
    public function index()
    {
        $totalBarang     = Barang::count();
        $stokRendah      = Barang::whereColumn('stok_saat_ini', '<=', 'stok_minimum')->count();
        $totalMasukBulan = BarangMasuk::whereMonth('tanggal', now()->month)->sum('jumlah');
        $totalKeluarBulan= BarangKeluar::whereMonth('tanggal', now()->month)->sum('jumlah');

        $barang = Barang::with('kategori')
            ->orderByRaw('stok_saat_ini <= stok_minimum DESC')
            ->orderBy('nama')
            ->paginate(15);

        $alertBarang = Barang::with('kategori')
            ->whereColumn('stok_saat_ini', '<=', 'stok_minimum')
            ->get();

        return view('admin.Kelola_Barang.index', compact(
            'totalBarang', 'stokRendah', 'totalMasukBulan', 'totalKeluarBulan',
            'barang', 'alertBarang'
        ));
    }

    // Form tambah barang
    public function create()
    {
        $kategori = KategoriBarang::orderBy('nama')->get();
        return view('admin.Kelola_Barang.barang_create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'   => 'required|unique:barang,kode_barang|max:50',
            'nama'          => 'required|max:150',
            'id_kategori'   => 'required|exists:kategori_barang,id',
            'satuan'        => 'required|max:30',
            'stok_minimum'  => 'required|integer|min:0',
            'harga_satuan'  => 'required|numeric|min:0',
        ]);

        Barang::create($request->only([
            'kode_barang','nama','id_kategori','satuan',
            'stok_minimum','harga_satuan','deskripsi'
        ]));

        return redirect()->route('admin.kelola_barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $kategori = KategoriBarang::orderBy('nama')->get();
        return view('admin.Kelola_Barang.barang_edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'kode_barang'   => 'required|max:50|unique:barang,kode_barang,'.$barang->id,
            'nama'          => 'required|max:150',
            'id_kategori'   => 'required|exists:kategori_barang,id',
            'satuan'        => 'required|max:30',
            'stok_minimum'  => 'required|integer|min:0',
            'harga_satuan'  => 'required|numeric|min:0',
        ]);

        $barang->update($request->only([
            'kode_barang','nama','id_kategori','satuan',
            'stok_minimum','harga_satuan','deskripsi'
        ]));

        return redirect()->route('admin.kelola_barang.index')->with('success', 'Data barang berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->barangMasuk()->count() > 0 || $barang->barangKeluar()->count() > 0) {
            return back()->with('error', 'Barang tidak bisa dihapus karena sudah memiliki transaksi.');
        }
        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }
}
