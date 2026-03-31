<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\KaryawanModel;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/karyawan/dashboard');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }


    //function register
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // VALIDASI
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:karyawan,email|max:100',
            'password' => 'required|min:6',
            'no_hp' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:50',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib.',
            'password.min' => 'Password minimal 6 karakter.',
            'foto.required' => 'Foto wajah WAJIB untuk absensi AI!',
            'foto.image' => 'File harus gambar JPG/PNG.',
            'foto.max' => 'Foto maksimal 2MB.',
        ]);

        // CEK FOTO VALID
        $foto = $request->file('foto');
        if (!$foto || !$foto->isValid()) {
            return back()->with('error', '❌ Foto tidak valid!');
        }

        $image_info = getimagesize($foto->path());
        if (!$image_info) {
            return back()->with('error', '❌ Harus file gambar JPG/PNG!');
        }

        try {
            // 1. SIMPAN KE DATABASE KARYAWAN
            $karyawan = KaryawanModel::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'no_hp' => $request->no_hp ?? null,
                'jabatan' => $request->jabatan ?? 'Staff',
                'tanggal_masuk' => now(),
                'foto' => 'default.jpg',  // sementara
                'role' => 'karyawan',
            ]);

            // 2.AUTO SAVE FOTO ke known_faces/ (1 BARIS!)
            $filename = $request->email . '.jpg';
            $knownFacesPath = base_path('ai_absensi/known_faces/' . $filename);

            $dir = dirname($knownFacesPath);
            if (!file_exists($dir)) {
                return back()->with('error', 'Folder known_faces tidak ada!');
            }
            $foto->move($dir, $filename);  
            $karyawan->foto = "known_faces/{$filename}";
            $karyawan->save();

            // 4. Trigger FastAPI reload
            Http::timeout(5)->post('http://127.0.0.1:8001/reload');

            Log::info('REGISTER SUCCESS', [
                'karyawan_id' => $karyawan->id,
                'email' => $request->email,
                'face_path' => $knownFacesPath
            ]);

            return redirect('/login')
                ->with('success', "🎉 Registrasi sukses {$request->nama}! Wajah tersimpan & siap absensi AI");

        } catch (\Exception $e) {
            Log::error('Register error: ' . $e->getMessage());
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
}
