<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeolokasiModel;

class GeolokasiController extends Controller
{
    public function index()
    {
        // Ambil data geolokasi pertama, jika tidak ada, buat instance baru dengan nilai default lama
        $geolokasi = GeolokasiModel::first() ?? new GeolokasiModel([
            'nama_lokasi' => 'Kantor Utama',
            'latitude' => -6.4915853,
            'longitude' => 107.8846398,
            'radius' => 150
        ]);

        return view('admin.geolokasi.index', compact('geolokasi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:10'
        ]);

        $geolokasi = GeolokasiModel::first();

        if ($geolokasi) {
            $geolokasi->update($request->only(['nama_lokasi', 'latitude', 'longitude', 'radius']));
        } else {
            GeolokasiModel::create($request->only(['nama_lokasi', 'latitude', 'longitude', 'radius']));
        }

        return redirect()->back()->with('success', 'Pengaturan Geolokasi berhasil diperbarui.');
    }
}
