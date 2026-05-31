<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with(['barang.kategori', 'karyawan']);

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('penerima')) {
            $query->where('penerima', 'like', '%'.$request->penerima.'%');
        }

        $riwayat = $query->orderByDesc('tanggal')->orderByDesc('id')->paginate(15)->withQueryString();
        $barang  = Barang::where('stok_saat_ini', '>', 0)->orderBy('nama')->get();

        return view('admin.Kelola_Barang.keluar', compact('riwayat', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah'    => 'required|integer|min:1',
            'penerima'  => 'required|max:150',
            'keperluan' => 'required|max:255',
            'tanggal'   => 'required|date',
            'catatan'   => 'nullable',
        ]);

        $barang = Barang::findOrFail($request->id_barang);

        if ($barang->stok_saat_ini < $request->jumlah) {
            return back()->withErrors(['jumlah' => "Stok tidak cukup. Stok tersedia: {$barang->stok_saat_ini} {$barang->satuan}."])->withInput();
        }

        DB::transaction(function () use ($request) {
            BarangKeluar::create([
                'id_barang'   => $request->id_barang,
                'jumlah'      => $request->jumlah,
                'penerima'    => $request->penerima,
                'keperluan'   => $request->keperluan,
                'tanggal'     => $request->tanggal,
                'id_karyawan' => Auth::id(),
                'catatan'     => $request->catatan,
            ]);

            Barang::where('id', $request->id_barang)
                ->decrement('stok_saat_ini', $request->jumlah);
        });

        return back()->with('success', 'Barang keluar berhasil dicatat. Stok telah diperbarui.');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {
            Barang::where('id', $barangKeluar->id_barang)
                ->increment('stok_saat_ini', $barangKeluar->jumlah);
            $barangKeluar->delete();
        });

        return back()->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
