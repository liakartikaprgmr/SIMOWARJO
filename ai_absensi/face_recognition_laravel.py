import sys
import face_recognition
import json

# Ambil path gambar dari argumen Laravel
image_path = sys.argv[1]

# Load gambar
image = face_recognition.load_image_file(image_path)

# Deteksi wajah
face_locations = face_recognition.face_locations(image)

# Output hasil sebagai JSON
result = {
    "jumlah_wajah": len(face_locations),
    "koordinat": face_locations
}

print(json.dumps(result))