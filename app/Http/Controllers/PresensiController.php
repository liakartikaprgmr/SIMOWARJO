<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\PresensiModel;

class PresensiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $userEmail = Auth::user()->email;

        $formattedEmail = strtolower(str_replace(' ', '.', $userEmail));

        $riwayat = PresensiModel::selectRaw('
            DATE(created_at) as tanggal,
            MIN(CASE WHEN type="masuk" THEN created_at END) as jam_masuk,
            MAX(CASE WHEN type="pulang" THEN created_at END) as jam_pulang,
            MAX(CASE WHEN type="masuk" THEN foto_absensi END) as foto_masuk,
            MAX(CASE WHEN type="pulang" THEN foto_absensi END) as foto_pulang
        ')
            ->where('id_karyawan', Auth::id())
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        $geolokasi = \App\Models\GeolokasiModel::first();
        return view('karyawan.presensi', compact('riwayat', 'formattedEmail', 'geolokasi'));
    }

    public function adminPresensi()
    {
        $userId = Auth::id();
        $userEmail = Auth::user()->email;

        $formattedEmail = strtolower(str_replace(' ', '.', $userEmail));

        $riwayat = PresensiModel::selectRaw('
            DATE(created_at) as tanggal,
            MIN(CASE WHEN type="masuk" THEN created_at END) as jam_masuk,
            MAX(CASE WHEN type="pulang" THEN created_at END) as jam_pulang,
            MAX(CASE WHEN type="masuk" THEN foto_absensi END) as foto_masuk,
            MAX(CASE WHEN type="pulang" THEN foto_absensi END) as foto_pulang
        ')
            ->where('id_karyawan', Auth::id())
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        $geolokasi = \App\Models\GeolokasiModel::first();
        return view('admin.presensi.presensi_wajah', compact('riwayat', 'formattedEmail', 'geolokasi'));
    }

    public function upload(Request $request)
    {
        Log::error('MASUK CONTROLLER UPLOAD');
        Log::info('=== ABSENSI START ===', $request->all());

        try {
            // 1. VALIDASI
            $request->validate([
                'image' => 'required|string', // 10MB base64
                'type' => 'required|in:masuk,pulang',
                'lat' => 'required|numeric|between:-90,90',
                'lng' => 'required|numeric|between:-180,180',
            ]);

            $userId = Auth::id();
            if (!$userId) {
                return response()->json(['error' => 'Login dulu!'], 401);
            }

            Log::info("User ID: $userId | Type: {$request->type}");

            // 2. CEK SUDAH ABSEN
            $today = now()->toDateString();
            $sudahMasuk = DB::table('presensi')
                ->where('id_karyawan', $userId)
                ->where('type', 'masuk')
                ->whereDate('created_at', $today)
                ->exists();

            $sudahPulang = DB::table('presensi')
                ->where('id_karyawan', $userId)
                ->where('type', 'pulang')
                ->whereDate('created_at', $today)
                ->exists();

            if ($request->type == 'masuk' && $sudahMasuk) {
                return response()->json(['error' => 'Sudah absen masuk!'], 400);
            }
            if ($request->type == 'pulang' && !$sudahMasuk) {
                return response()->json(['error' => 'Absen masuk dulu!'], 400);
            }
            if ($request->type == 'pulang' && $sudahPulang) {
                return response()->json(['error' => 'Sudah absen pulang!'], 400);
            }

            // 3. GPS CHECK
            $geolokasi = \App\Models\GeolokasiModel::first();
            $kantorLat = $geolokasi ? $geolokasi->latitude : -6.4915853;
            $kantorLng = $geolokasi ? $geolokasi->longitude : 107.8846398;
            $radiusMax = $geolokasi ? $geolokasi->radius : 150;
            $distance = $this->hitungJarak($request->lat, $request->lng, $kantorLat, $kantorLng);

            Log::info("GPS Distance: " . round($distance) . "m");

            if ($distance > $radiusMax) {
                return response()->json(['error' => "Luarradius! Jarak: " . round($distance) . "m"], 400);
            }

            // 4. AI CHECK FASTAPI
            $email = strtolower(Auth::user()->email);
            Log::info('EMAIL DIKIRIM KE AI: ' . $email);

            $fastapiResponse = Http::timeout(30)->post('http://127.0.0.1:8001/attendance', [
                'email' => $email,
                'image' => $request->image
            ]);

            if (!$fastapiResponse->successful()) {
                Log::error('FASTAPI ERROR', $fastapiResponse->json());
                return response()->json(['error' => 'AI server mati!'], 500);
            }

            $aiResult = $fastapiResponse->json();
            Log::info('AI RESULT:', $aiResult);

            if (!isset($aiResult['match']) || !$aiResult['match']) {
                return response()->json([
                    'error' => $aiResult['message'] ?? 'Wajah salah!',
                    'confidence' => $aiResult['confidence'] ?? 0
                ], 400);
            }

            // 5. SIMPAN FOTO
            Log::info('Image received: YES | Length: ' . strlen($request->image));

            $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $request->image);
            $imageBinary = base64_decode($imageData, true);

            if ($imageBinary === false || strlen($imageBinary) > 5 * 1024 * 1024) {
                return response()->json(['error' => 'Image corrupt/terlalu besar'], 400);
            }

            $imageName = 'absensi_' . time() . '_' . $userId . '.png';
            $path = 'absensi/' . date('Y/m') . '/' . $imageName;

            Storage::disk('public')->makeDirectory(dirname($path));
            Storage::disk('public')->put($path, $imageBinary);

            Log::info('Foto saved: ' . $path);

            // 6. SIMPAN DATABASE
            DB::table('presensi')->insert([
                'id_karyawan' => $userId,
                'type' => $request->type,
                'foto_absensi' => $path,
                'lat' => $request->lat,
                'lng' => $request->lng,
                'ai_distance' => $aiResult['distance'] ?? 0,
                'ai_confidence' => $aiResult['confidence'] ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('ABSENSI BERHASIL!');

            return response()->json([
                'status' => 'success',
                'message' => 'Absen ' . ucfirst($request->type) . ' berhasil!',
                'path' => $path,
                'url' => asset('storage/' . $path),
                'nama' => $aiResult['nama'] ?? 'Karyawan',
                'confidence' => $aiResult['confidence'] ?? 0,
                'distance_gps' => round($distance)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('VALIDATION ERROR: ' . json_encode($e->errors()));
            return response()->json(['error' => 'Data tidak valid: ' . json_encode($e->errors())], 400);
        } catch (\Exception $e) {
            Log::error('ABSENSI 500 ERROR: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        return $earthRadius * $c;
    }

    public function daftarKehadiran(Request $request)
    {
        $startDate = $request->input('tanggal_mulai', date('Y-m-d'));
        $endDate = $request->input('tanggal_akhir', date('Y-m-d'));
        $search = $request->input('search');

        $totalKaryawan = \App\Models\KaryawanModel::count();

        $query = PresensiModel::selectRaw('
                id_karyawan,
                DATE(created_at) as tanggal,
                MIN(CASE WHEN type="masuk" THEN created_at END) as jam_masuk,
                MAX(CASE WHEN type="pulang" THEN created_at END) as jam_pulang,
                MAX(CASE WHEN type="masuk" THEN foto_absensi END) as foto_masuk,
                MAX(CASE WHEN type="pulang" THEN foto_absensi END) as foto_pulang
            ')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('id_karyawan', 'tanggal')
            ->with('karyawan');

        if ($search) {
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $kehadiran = $query->orderBy('tanggal', 'desc')->paginate(20)->withQueryString();

        // Hitung Statistik
        $hadir = PresensiModel::where('type', 'masuk')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();

        $sakit = \App\Models\PengajuanIzinModel::where('jenis', 'sakit')
            ->where('status', 'disetujui')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('tanggal_mulai', '<=', $startDate)
                            ->where('tanggal_selesai', '>=', $endDate);
                    });
            })->count();

        $izin = \App\Models\PengajuanIzinModel::where('jenis', 'izin')
            ->where('status', 'disetujui')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('tanggal_mulai', '<=', $startDate)
                            ->where('tanggal_selesai', '>=', $endDate);
                    });
            })->count();

        $telat = 0;
        $presensiMasuk = PresensiModel::where('type', 'masuk')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        foreach ($presensiMasuk as $p) {
            $jadwal = \App\Models\PenjadwalanModel::where('id_karyawan', $p->id_karyawan)
                ->where('tanggal', date('Y-m-d', strtotime($p->created_at)))
                ->first();
            if ($jadwal && $jadwal->jam_masuk) {
                $waktuMasuk = date('H:i:s', strtotime($p->created_at));
                if ($waktuMasuk > $jadwal->jam_masuk) {
                    $telat++;
                }
            }
        }

        $days = max(1, round((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24)) + 1);
        $tidakHadir = max(0, ($totalKaryawan * $days) - ($hadir + $sakit + $izin));

        return view('admin.presensi.kehadiran', compact(
            'kehadiran',
            'startDate',
            'endDate',
            'search',
            'hadir',
            'sakit',
            'izin',
            'telat',
            'tidakHadir'
        ));
    }
}
