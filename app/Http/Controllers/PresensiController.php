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

        return view('karyawan.presensi', compact('riwayat', 'formattedEmail'));
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
        $kantorLat = -6.4915853;
        $kantorLng = 107.8846398;
        $radiusMax = 150;
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

        Log::info('Image received: YES | Length: ' . strlen($request->image));
        
        $imageData = preg_replace('#^data:image/\w+;base64,#i', '', $request->image);
        $imageBinary = base64_decode($imageData, true);
        
        if ($imageBinary === false || strlen($imageBinary) > 5*1024*1024) {
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
}