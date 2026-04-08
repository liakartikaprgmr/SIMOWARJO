<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KaryawanModel;

class KaryawanController extends Controller
{
    public function kelola_karyawan()
    {
        $karyawan = KaryawanModel::all();
        return view('admin.Kelola_Karyawan.kelola_karyawan', compact('karyawan'));
    }

    public function tambah_karyawan()
    {
        return view('admin.Kelola_Karyawan.tambah_karyawan');
    }

    public function store_karyawan(Request $request)
    {
        $karyawan = new KaryawanModel();
        $karyawan->nama = $request->nama;
        $karyawan->email = $request->email;
        $karyawan->password = bcrypt($request->password);
        $karyawan->jabatan = $request->jabatan;
        $karyawan->status = $request->status;
        $karyawan->role = $request->role ?? 'karyawan';
        $karyawan->tanggal_masuk = date('Y-m-d'); // Default ke hari ini saat pembuatan baru
        
        $knownFacesPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $request->email . '.jpg';
            $knownFacesPath = base_path('ai_absensi/known_faces/' . $filename);

            $dir = dirname($knownFacesPath);
            if (!file_exists($dir)) {
                return back()->with('error', 'Folder known_faces tidak ada!');
            }
            $file->move($dir, $filename);
            $karyawan->foto = "known_faces/{$filename}";
        }

        $karyawan->save();

        try {
            \Illuminate\Support\Facades\Http::timeout(5)->post('http://127.0.0.1:8001/reload');
        } catch (\Exception $e) {
        }

        \Illuminate\Support\Facades\Log::info('KARYAWAN SUCCESS', [
            'karyawan_id' => $karyawan->id_karyawan ?? $karyawan->id ?? null,
            'email' => $request->email,
            'face_path' => $knownFacesPath
        ]);

        return redirect()->route('admin.kelola_karyawan')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function edit_karyawan($id)
    {
        $karyawan = KaryawanModel::findOrFail($id);
        return view('admin.Kelola_Karyawan.edit_karyawan', compact('karyawan'));
    }

    public function update_karyawan(Request $request, $id)
    {
        $karyawan = KaryawanModel::findOrFail($id);
        $karyawan->nama = $request->nama;
        $karyawan->email = $request->email;
        if ($request->filled('password')) {
            $karyawan->password = bcrypt($request->password);
        }
        $karyawan->jabatan = $request->jabatan;
        $karyawan->status = $request->status;
        if ($request->has('role')) {
            $karyawan->role = $request->role;
        }

        $knownFacesPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $request->email . '.jpg';
            $knownFacesPath = base_path('ai_absensi/known_faces/' . $filename);

            $dir = dirname($knownFacesPath);
            if (!file_exists($dir)) {
                return back()->with('error', 'Folder known_faces tidak ada!');
            }
            $file->move($dir, $filename);
            $karyawan->foto = "known_faces/{$filename}";
        }

        $karyawan->save();

        try {
            \Illuminate\Support\Facades\Http::timeout(5)->post('http://127.0.0.1:8001/reload');
        } catch (\Exception $e) {
        }

        \Illuminate\Support\Facades\Log::info('KARYAWAN SUCCESS', [
            'karyawan_id' => $karyawan->id_karyawan ?? $karyawan->id ?? null,
            'email' => $request->email,
            'face_path' => $knownFacesPath
        ]);

        return redirect()->route('admin.kelola_karyawan')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function delete_karyawan($id)
    {
        $karyawan = KaryawanModel::findOrFail($id);
        
        if ($karyawan->foto && $karyawan->foto !== 'default.jpg') {
            $path = base_path('ai_absensi/' . $karyawan->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $karyawan->delete();

        try {
            \Illuminate\Support\Facades\Http::timeout(5)->post('http://127.0.0.1:8001/reload');
        } catch (\Exception $e) {
            // Abaikan jika service mati
        }

        \Illuminate\Support\Facades\Log::info('KARYAWAN DELETED', [
            'karyawan_id' => $id
        ]);

        return redirect()->route('admin.kelola_karyawan')->with('success', 'Data karyawan berhasil dihapus!');
    }
}
