from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import base64, numpy as np, cv2, sqlite3, pickle, os, glob

import os
import asyncio

app = FastAPI(title="known_faces ONLY")

class AttendanceRequest(BaseModel):
    email: str
    image: str

loaded_count = 0

# pyrefly: ignore [missing-import]
import face_recognition

def base64_to_image(b64str):
    try:
        if ',' in b64str: b64str = b64str.split(',')[1]
        return cv2.imdecode(np.frombuffer(base64.b64decode(b64str), np.uint8), cv2.IMREAD_COLOR)
    except: return None

def extract_features(img):
    # Convert BGR (OpenCV) to RGB (face_recognition)
    rgb_img = cv2.cvtColor(img, cv2.COLOR_BGR2RGB)
    rgb_img = np.ascontiguousarray(rgb_img, dtype=np.uint8)
    
    # Cari lokasi wajah
    face_locations = face_recognition.face_locations(rgb_img)
    if not face_locations:
        return None
        
    # Ekstrak facial embeddings (128-dimensi)
    face_encodings = face_recognition.face_encodings(rgb_img, face_locations)
    if not face_encodings:
        return None
        
    return face_encodings[0]

# Database
conn = sqlite3.connect('faces.db', check_same_thread=False)
cursor = conn.cursor()
cursor.execute('''CREATE TABLE IF NOT EXISTS faces (
    email TEXT PRIMARY KEY, nama TEXT, signatures BLOB
)''')

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
print(f" {loaded_count} karyawan ready!")

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
    if curr_sig is None: raise HTTPException(400, "No face detected in the image")
    
    # Calculate Euclidean distance using face_recognition
    distances = face_recognition.face_distance(stored_sigs, curr_sig)
    
    if len(distances) == 0:
        raise HTTPException(500, "Corrupted stored signatures")
        
    best_dist = min(distances)
    
    # Threshold for face_recognition is generally 0.6. Lower is stricter.
    # We use 0.5 for better accuracy.
    is_match = bool(best_dist <= 0.5)
    
    # Calculate confidence as percentage (e.g., 85.5)
    confidence_percent = round(float(max(0, 1 - best_dist)) * 100, 1)
    
    return {
        "match": is_match,
        "nama": nama,
        "confidence": confidence_percent,
        "distance": float(best_dist),
        "debug": {"distances": [float(d) for d in distances]}
    }

@app.post("/reload")
def reload():
    global loaded_count
    loaded_count = load_all_known_faces()
    return {"reloaded": loaded_count}

print("READY - mkdir known_faces && touch known_faces/test.jpg")
