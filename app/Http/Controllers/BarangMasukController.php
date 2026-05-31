<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangMasuk::with(['barang.kategori', 'karyawan']);

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('supplier')) {
            $query->where('supplier', 'like', '%'.$request->supplier.'%');
        }

        $riwayat = $query->orderByDesc('tanggal')->orderByDesc('id')->paginate(15)->withQueryString();
        $barang  = Barang::orderBy('nama')->get();

        return view('admin.Kelola_Barang.masuk', compact('riwayat', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang'    => 'required|exists:barang,id',
            'jumlah'       => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'supplier'     => 'required|max:150',
            'no_faktur'    => 'nullable|max:100',
            'tanggal'      => 'required|date',
            'catatan'      => 'nullable',
        ]);

        DB::transaction(function () use ($request) {
            $total = $request->jumlah * $request->harga_satuan;

            BarangMasuk::create([
                'id_barang'    => $request->id_barang,
                'jumlah'       => $request->jumlah,
                'harga_satuan' => $request->harga_satuan,
                'total_harga'  => $total,
                'supplier'     => $request->supplier,
                'no_faktur'    => $request->no_faktur,
                'tanggal'      => $request->tanggal,
                'id_karyawan'  => Auth::id(),
                'catatan'      => $request->catatan,
            ]);

            Barang::where('id', $request->id_barang)
                ->increment('stok_saat_ini', $request->jumlah);
        });

        return back()->with('success', 'Barang masuk berhasil dicatat. Stok telah diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {
            Barang::where('id', $barangMasuk->id_barang)
                ->decrement('stok_saat_ini', $barangMasuk->jumlah);
            $barangMasuk->delete();
        });

        return back()->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
