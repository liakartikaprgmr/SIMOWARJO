import cv2
import base64

print("🎥 Webcam test - SPACE ambil foto, Q keluar")

# FIX WINDOWS: Ganti backend
cap = cv2.VideoCapture(0, cv2.CAP_DSHOW)  # ← UBAH INI
# Atau coba: cv2.CAP_MSMF atau cv2.CAP_ANY

if not cap.isOpened():
    print("❌ Webcam gagal! Coba:")
    print("1. Tutup Zoom/Teams")
    print("2. Jalankan sebagai Admin")
    exit()

while True:
    ret, frame = cap.read()
    if not ret:
        print("❌ Gagal ambil frame")
        break
    
    cv2.imshow('Ambil Foto untuk Test', frame)
    
    key = cv2.waitKey(1) & 0xFF
    if key == 32:  # SPACE
        cv2.imwrite('foto1.jpg', frame)
        print("✅ foto1.jpg tersimpan!")
        
        # BASE64
        with open('foto1.jpg', 'rb') as f:
            base64_img = base64.b64encode(f.read()).decode()
            print("\n📋 COPY untuk REGISTER:")
            print('"image": "data:image/jpeg;base64,' + base64_img[:100] + '..."')
        
        # Foto kedua
        print("\n🎥 Foto orang lain (beda wajah)...")
        ret, frame2 = cap.read()
        cv2.imwrite('foto2.jpg', frame2)
        with open('foto2.jpg', 'rb') as f:
            base64_img2 = base64.b64encode(f.read()).decode()
            print("\n📋 COPY untuk ABSEN PALSAU:")
            print('"image": "data:image/jpeg;base64,' + base64_img2[:100] + '..."')
        break
    
    if key == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()