from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import base64, numpy as np, cv2, sqlite3, pickle, os, glob
from sklearn.preprocessing import StandardScaler
import os
import asyncio

app = FastAPI(title="known_faces ONLY")

class AttendanceRequest(BaseModel):
    email: str
    image: str

# 🔥 GLOBAL
loaded_count = 0

# Models
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')
eye_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_eye.xml')

def base64_to_image(b64str):
    try:
        if ',' in b64str: b64str = b64str.split(',')[1]
        return cv2.imdecode(np.frombuffer(base64.b64decode(b64str), np.uint8), cv2.IMREAD_COLOR)
    except: return None

def extract_features(img):
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_cascade.detectMultiScale(gray, 1.1, 4)
    if len(faces) == 0: return None
    
    x, y, w, h = faces[0]
    roi = gray[y:y+h, x:x+w]
    
    features = [
        min(w*h/(img.shape[0]*img.shape[1]), 0.5),
        min(abs((x+w/2)/img.shape[1]-0.5), 0.3),
        min(abs((y+h/2)/img.shape[0]-0.5), 0.3),
        min(abs(w/h-1.0), 0.5),
        min(np.std(roi)/50.0, 1.0),
        1.0 if len(eye_cascade.detectMultiScale(roi)) > 0 else 0.0
    ]
    return np.array(features)

# Database
conn = sqlite3.connect('faces.db', check_same_thread=False)
cursor = conn.cursor()
cursor.execute('''CREATE TABLE IF NOT EXISTS faces (
    email TEXT PRIMARY KEY, nama TEXT, signatures BLOB
)''')

# 🔥 SIMPLE VERSION - NO MYSQL
def load_all_known_faces():
    cursor.execute('DELETE FROM faces')
    loaded = 0
    
    if not os.path.exists('known_faces'):
        os.makedirs('known_faces')
        return 0
    
    print("Scanning known_faces/...")
    
    for photo_path in glob.glob("C:\\Users\\Lia Kartika\\Herd\\simowarjo\\ai_absensi\\known_faces\\*.jpg"):
        filename_full = os.path.basename(photo_path)
        filename = os.path.splitext(filename_full)[0].lower()

        email = filename 
        nama = filename.replace('_', ' ').title()

        
        img = cv2.imread(photo_path)
        if img is not None:
            sig = extract_features(img)
            if sig is not None:
                cursor.execute("INSERT INTO faces VALUES (?, ?, ?)",
                              (email, nama, pickle.dumps([sig])))
                loaded += 1
                print(f" {email} = {nama}")
            else:
                print(f" {email} - no face detected")
        else:
            print(f" {filename_full} - corrupt image")
    
    conn.commit()
    return loaded

# Load startup
loaded_count = load_all_known_faces()
print(f"✅ {loaded_count} karyawan ready!")

@app.get("/")
def root():
    return {"message": f"{loaded_count} karyawan from known_faces/"}

@app.get("/employees")
def employees():
    cursor.execute("SELECT email, nama FROM faces")
    return [{"email": r[0], "nama": r[1]} for r in cursor.fetchall()]

@app.post("/attendance")
def attendance(req: AttendanceRequest):
    cursor.execute("SELECT signatures, nama FROM faces WHERE LOWER(email)=?", (req.email.lower(),))
    result = cursor.fetchone()
    
    if not result:
        cursor.execute("SELECT email FROM faces LIMIT 5")
        suggestions = [r[0] for r in cursor.fetchall()]
        raise HTTPException(404, f"{req.email} not found! Try: {suggestions}")
    
    signatures, nama = result
    stored_sigs = pickle.loads(signatures)
    
    img = base64_to_image(req.image)
    if img is None: raise HTTPException(400, "Invalid image")
    
    curr_sig = extract_features(img)
    if curr_sig is None: raise HTTPException(400, "No face")
    
    scaler = StandardScaler()
    scaler.fit([s[:5] for s in stored_sigs])
    distances = [np.mean(np.abs(scaler.transform([s[:5]])[0] - scaler.transform([curr_sig[:5]])[0])) 
                 for s in stored_sigs]
    best_dist = min(distances)
    
    # ✅ FIX: Convert numpy bool ke Python bool
    return {
        "match": bool(best_dist < 0.35),  # ← GANTI INI
        "nama": nama,
        "confidence": float(1 - best_dist),
        "distance": float(best_dist),
        "debug": {"distances": [float(d) for d in distances]}
    }

@app.post("/reload")
def reload():
    global loaded_count
    loaded_count = load_all_known_faces()
    return {"reloaded": loaded_count}

print("READY - mkdir known_faces && touch known_faces/test.jpg")