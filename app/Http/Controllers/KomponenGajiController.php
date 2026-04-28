<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KaryawanModel;
use App\Models\KomponenGajiModel;

class KomponenGajiController extends Controller
{
    public function index()
    {
        // Ambil semua karyawan beserta komponen gajinya jika ada
        $karyawans = KaryawanModel::all();
        
        $dataKomponen = [];
        foreach($karyawans as $karyawan) {
            $komponen = KomponenGajiModel::where('id_karyawan', $karyawan->id_karyawan)->first();
            
            $dataKomponen[] = [
                'karyawan' => $karyawan,
                'gaji_pokok' => $komponen ? $komponen->gaji_pokok : 3000000,
                'tunjangan_jabatan' => $komponen ? $komponen->tunjangan_jabatan : 0,
                'insentif_skill' => $komponen ? $komponen->insentif_skill : 0
            ];
        }

        return view('admin.penggajian.komponen_gaji.index', compact('dataKomponen'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_jabatan' => 'required|numeric|min:0',
            'insentif_skill' => 'required|numeric|min:0',
        ]);

        KomponenGajiModel::updateOrCreate(
            ['id_karyawan' => $request->id_karyawan],
            [
                'gaji_pokok' => $request->gaji_pokok,
                'tunjangan_jabatan' => $request->tunjangan_jabatan,
                'insentif_skill' => $request->insentif_skill
            ]
        );

        return redirect()->route('admin.penggajian.komponen_gaji.index')->with('success', 'Komponen gaji karyawan berhasil diperbarui.');
    }
}
