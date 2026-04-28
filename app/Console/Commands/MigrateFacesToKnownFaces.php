<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\User;  // atau model User lo

class MigrateFacesToKnownFaces extends Command
{
    protected $signature = 'faces:migrate';
    protected $description = 'Migrate user photos to known_faces folder';

    public function handle()
    {
        $knownFacesDir = base_path('ai_absen/known_faces');
        
        // Buat folder
        if (!file_exists($knownFacesDir)) {
            mkdir($knownFacesDir, 0755, true);
        }

        // Ambil semua user dengan foto
        $users = User::whereNotNull('foto')->get();  // kolom foto lo
        
        foreach ($users as $user) {
            $oldPhotoPath = $user->foto;  // path lama di DB
            
            if (Storage::disk('public')->exists($oldPhotoPath)) {
                // Generate nama baru
                $filename = strtolower(str_replace(' ', '_', $user->name)) . '.jpg';
                $newPath = "known_faces/{$filename}";
                
                // Copy
                $content = Storage::disk('public')->get($oldPhotoPath);
                Storage::disk('public')->put($newPath, $content);
                
                // Copy ke FastAPI
                copy(storage_path("app/public/{$newPath}"), "{$knownFacesDir}/{$filename}");
                
                $this->info(" {$user->name} → {$filename}");
            }
        }
        
        // Trigger FastAPI reload
        \Illuminate\Support\Facades\Http::post('http://127.0.0.1:8001/reload');
        
        $this->info('Migration selesai! Run FastAPI reload.');
    }
}