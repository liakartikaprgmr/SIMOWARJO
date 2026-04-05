<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-email" content="{{ $formattedEmail }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Wajah AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <style>
        .no-mirror { transform: scaleX(-1); }
        #debugGPS { font-family: monospace; }
        #map { 
            height: 320px; 
            border-radius: 12px; 
            border: 3px solid #e5e7eb; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .leaflet-popup-content-wrapper { 
            border-radius: 12px; 
            border: 2px solid #e5e7eb;
        }
        .leaflet-container { 
            border-radius: 12px; 
        }
        .map-title {
            font-weight: 700;
            color: #1f2937;
            font-size: 14px;
        }
    </style>
</head>
<body class="bg-gray-100">
<!-- Sidebar -->
@include('karyawan.sidebarempl')

<!-- Content -->
<div class="ml-64 p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="flex items-center gap-1 text-2xl font-bold">
                <svg class="text-blue-600" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3.2" fill="currentColor"/>
                    <path fill="currentColor" d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5"/>
                </svg>    
                Presensi <span class="text-blue-600">Wajah AI</span>
            </h1>
            <p class="flex items-center gap-1 text-gray-500 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12c5.16-1.26 9-6.45 9-12V5z"/>
                </svg>    
                Face Recognition + Liveness Detection + Live GPS Tracking
            </p>
        </div>
        <div class="flex gap-2">
            <span id="gpsBadge" class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm animate-pulse">GPS Loading...</span>
            <span class="bg-blue-100 text-blue-600 px-3 py-2 rounded-full text-sm">AI Active</span>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <!-- LEFT -->
        <div class="col-span-2">
            <!-- Button -->
            <div class="flex gap-4 mb-6">
                <a href="/absen/masuk" onclick="setAbsen(event, 'masuk')" id="btnMasuk"
                    class="flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl w-full transition-all duration-300 text-center justify-center shadow-xl hover:shadow-2xl hover:scale-[1.02] hover:from-blue-700 hover:to-blue-800 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M10.3 7.7a.984.984 0 0 0 0 1.4l1.9 1.9H3c-.55 0-1 .45-1 1s.45 1 1 1h9.2l-1.9 1.9a.984.984 0 0 0 0 1.4c.39.39 1.01.39 1.4 0l3.59-3.59a.996.996 0 0 0 0-1.41L11.7 7.7a.984.984 0 0 0-1.4 0M20 19h-7c-.55 0-1 .45-1 1s.45 1 1 1h7c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-7c-.55 0-1 .45-1 1s.45 1 1 1h7z"/>
                    </svg>
                    Absen Masuk
                </a>
                <a href="/absen/pulang" onclick="setAbsen(event, 'pulang')" id="btnPulang"
                    class="flex items-center gap-2 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-800 px-8 py-3 rounded-xl w-full transition-all duration-300 text-center justify-center shadow-xl hover:shadow-2xl hover:scale-[1.02] hover:from-gray-300 hover:to-gray-400 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M5 5h6c.55 0 1-.45 1-1s-.45-1-1-1H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h6c.55 0 1-.45 1-1s-.45-1-1-1H5z"/>
                        <path fill="currentColor" d="m20.65 11.65l-2.79-2.79a.501.501 0 0 0-.86.35V11h-7c-.55 0-1 .45-1 1s.45 1 1 1h7v1.79c0 .45.54.67.85.35l2.79-2.79c.2-.19.2-.51.01-.7"/>
                    </svg>
                    Absen Pulang
                </a>
            </div>

        <!-- MAP GPS STATUS (CLEAN VERSION - TANPA TEXT INFO) -->
        <button onclick="toggleMap()" class="flex items-center gap-1 mb-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-1 rounded-lg shadow hover:bg-blue-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7m0 9.5a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5"/></svg>
            Lokasi Saya
        </button>

        <div id="gpsPanel" class="hidden">
            <div class="mb-6 p-6 bg-gradient-to-br from-emerald-50 via-blue-50 to-indigo-50 rounded-2xl border-4 border-white/50 shadow-2xl backdrop-blur-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span id="gpsBadge2" class="bg-gradient-to-r from-emerald-600 to-green-600 text-white font-bold px-4 py-2 rounded-full text-sm shadow-lg">GPS Ready</span>
                        <span id="gpsAccuracy" class="text-sm font-semibold bg-white/80 px-3 py-1 rounded-full shadow-sm text-gray-800">Loading...</span>
                    </div>
                    <button onclick="toggleDebug()" class="p-2 hover:bg-white/50 rounded-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m12 5.5l6 4.5v1c.7 0 1.37.1 2 .29V9l-8-6l-8 6v12h7.68c-.3-.62-.5-1.29-.6-2H6v-9z"/><path fill="currentColor" d="M18 13c-2.76 0-5 2.24-5 5s2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5m3 5.5h-2.5V21h-1v-2.5H15v-1h2.5V15h1v2.5H21z"/></svg>
                    </button>
                </div>

                <div id="map"></div>
            </div>
        </div>

            <!-- CAMERA -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border-4 border-white/50 h-[380px]">
                <video id="video" class="w-full h-full object-cover no-mirror" autoplay playsinline muted></video>
            </div>
        </div>

        <!-- RIGHT PANEL - FIXED -->
        <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-2xl sticky top-6 border border-white/50 h-[380px] overflow-y-auto">
            <h2 class="font-bold text-xl mb-6 flex items-center gap-3 text-gray-800">
                <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                </svg>
                Riwayat Absen
            </h2>
            
            <div id="riwayatAbsen" class="space-y-4">
                @forelse($riwayat as $item)
                    <div class="p-5 bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl border shadow-sm hover:shadow-md transition-all">
                        <!-- TANGGAL -->
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-semibold text-gray-700">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                            </p>
                            @if($item->jam_masuk && $item->jam_pulang)
                                <span class="px-3 py-1 bg-green-100 text-center text-green-800 text-xs font-bold rounded-full">
                                    Hadir
                                </span>
                            @elseif($item->jam_masuk)
                                <span class="px-3 py-1 bg-yellow-100 text-centertext-yellow-800 text-xs font-bold rounded-full">
                                    Belum Pulang
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-center text-gray-800 text-xs font-bold rounded-full">
                                    Tidak Hadir
                                </span>
                            @endif
                        </div>

                        <!-- JAM ABSEN -->
                        <div class="grid grid-cols-2 gap-6 mb-3">
                            <!-- MASUK -->
                            <div class="text-center p-3 bg-white/50 rounded-lg">
                                <div class="flex items-center justify-between gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M10.3 7.7a.984.984 0 0 0 0 1.4l1.9 1.9H3c-.55 0-1 .45-1 1s.45 1 1 1h9.2l-1.9 1.9a.984.984 0 0 0 0 1.4c.39.39 1.01.39 1.4 0l3.59-3.59a.996.996 0 0 0 0-1.41L11.7 7.7a.984.984 0 0 0-1.4 0M20 19h-7c-.55 0-1 .45-1 1s.45 1 1 1h7c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-7c-.55 0-1 .45-1 1s.45 1 1 1h7z"/>
                                    </svg>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Masuk</p>
                                </div>
                                <p class="text-lg font-bold text-green-600">
                                    {{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '–' }}
                                </p>
                                @if($item->distance_masuk)
                                    <p class="text-xs text-green-600 mt-1">
                                        {{ number_format($item->distance_masuk) }}m
                                    </p>
                                @endif
                            </div>

                            <!-- PULANG -->
                            <div class=" text-center p-3 bg-white/50 rounded-lg">
                                <div class="flex items-center justify-between gap-1 mb-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5 5h6c.55 0 1-.45 1-1s-.45-1-1-1H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h6c.55 0 1-.45 1-1s-.45-1-1-1H5z"/>
                                    <path fill="currentColor" d="m20.65 11.65l-2.79-2.79a.501.501 0 0 0-.86.35V11h-7c-.55 0-1 .45-1 1s.45 1 1 1h7v1.79c0 .45.54.67.85.35l2.79-2.79c.2-.19.2-.51.01-.7"/>
                                </svg>
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Pulang</p>
                                </div>
                                <p class="text-lg font-bold text-blue-600">
                                    {{ $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '–' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-between items-center">
                            <!-- FOTO MASUK -->
                            @if($item->foto_masuk && Storage::disk('public')->exists($item->foto_masuk))
                                <div class="text-center">
                                    <img src="{{ Storage::url($item->foto_masuk) }}" 
                                        class="w-24 h-16 object-cover rounded-lg shadow hover:scale-105 transition cursor-pointer"
                                        onclick="window.open(this.src, '_blank')">
                                </div>
                            @endif
                            <!-- FOTO PULANG -->
                            @if($item->foto_pulang && Storage::disk('public')->exists($item->foto_pulang))
                                <div class="text-center">
                                    <img src="{{ Storage::url($item->foto_pulang) }}" 
                                        class="w-24 h-16 object-cover rounded-lg shadow hover:scale-105 transition cursor-pointer"
                                        onclick="window.open(this.src, '_blank')">
                                </div>
                            @endif
                        </div>    
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10v4m0 0v4m0-4H7m10 4H7"/>
                        </svg>
                        <h3 class="text-lg font-semibold mb-2">Belum ada riwayat absensi</h3>
                        <p class="text-sm">Mulai absen hari ini untuk melihat riwayat</p>
                    </div>
                @endforelse
            </div>
        </div>  
            

    </div>
</div>

<!-- DEBUG PANEL -->
<div id="debugGPS" class="fixed top-4 right-4 bg-gradient-to-b from-black/95 to-gray-900/90 backdrop-blur-xl text-white p-6 rounded-2xl shadow-2xl z-50 w-96 hidden border border-white/20">
    <h3 class="font-bold text-lg mb-4 flex items-center gap-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        GPS DEBUG
        <button onclick="document.getElementById('debugGPS').classList.add('hidden')" class="ml-auto text-gray-400 hover:text-white p-1 rounded-lg hover:bg-white/20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18.3 5.71a.996.996 0 0 0-1.41 0L12 10.59L7.11 5.7A.996.996 0 1 0 5.7 7.11L10.59 12L5.7 16.89a.996.996 0 1 0 1.41 1.41L12 13.41l4.89 4.89a.996.996 0 1 0 1.41-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4"/></svg>
        </button>
    </h3>
    <pre id="debugLog" class="text-xs max-h-64 overflow-auto bg-black/30 p-4 rounded-xl font-mono border border-white/20">Loading...</pre>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    //GLOBAL CONFIG
    const KANTOR = { lat: -6.4915853, lng: 107.8846398 };
    const RADIUS_KANTOR = 150;
    let currentGPS = null;
    let map = null;
    let userMarker = null;
    let kantorMarker = null;
    let kantorCircle = null;
    let isLoading = false;
    let debugLog = [];

    //DEBUG FUNCTION
    function logDebug(msg, type = 'info') {
        const timestamp = new Date().toLocaleTimeString();
        debugLog.push(`${timestamp} ${type.toUpperCase()}: ${msg}`);
        const logEl = document.getElementById('debugLog');
        if (logEl) logEl.textContent = debugLog.slice(-12).join('\n');
        console.log(`[${type.toUpperCase()}] ${msg}`);
    }

    function toggleDebug() {
        document.getElementById('debugGPS').classList.toggle('hidden');
    }

    // HAVERSINE DISTANCE
    function hitungJarak(lat1, lng1, lat2, lng2) {
        const R = 6371000;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2)**2 + Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) * Math.sin(dLng/2)**2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    // INIT MAP
    function initMap() {
        map = L.map('map').setView([KANTOR.lat, KANTOR.lng], 17);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // KANTOR MARKER
        kantorMarker = L.marker([KANTOR.lat, KANTOR.lng], {
            icon: L.divIcon({
                className: 'kantor-icon',
                html: '<div style="background: linear-gradient(45deg, #ef4444, #dc2626); width: 24px; height: 24px; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 12px rgba(59,130,246,0.4); animation: pulse 2s infinite;"></div>',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            })
        })
        .addTo(map)
        .bindPopup(`
            <div class="p-3">
                <h3 class="font-bold text-lg text-blue-600 mb-2">KANTOR PUSAT</h3>
                <p class="text-sm text-gray-700 mb-1"><strong>Koordinat:</strong> ${KANTOR.lat.toFixed(5)}, ${KANTOR.lng.toFixed(5)}</p>
                <p class="text-sm font-bold text-green-600">Radius: <span class="text-xl ">${RADIUS_KANTOR}m</span></p>
            </div>
        `);

        // KANTOR CIRCLE
        kantorCircle = L.circle([KANTOR.lat, KANTOR.lng], {
            color: 'red',
            weight: 3,
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: RADIUS_KANTOR
        }).addTo(map);
    }

    // UPDATE USER MARKER
    function updateUserMarker() {
        if (!currentGPS || !map) return;

        if (userMarker) map.removeLayer(userMarker);

        const color = currentGPS.jarak <= RADIUS_KANTOR ? '#10b981' : '#ef4444';
        const status = currentGPS.jarak <= RADIUS_KANTOR ? ' DALAM AREA' : ' LUAR AREA';
        const statusColor = currentGPS.jarak <= RADIUS_KANTOR ? 'text-green-600' : 'text-red-600';

        userMarker = L.marker([currentGPS.lat, currentGPS.lng], {
            icon: L.icon({
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                shadowSize: [41, 41]
            })
        })
        .addTo(map)
        .bindPopup(`
            <div class="p-4 max-w-xs">
                <h3 class="font-bold text-lg mb-3 flex items-center justify-between">
                    <span>POSISI ANDA</span>
                    <span class="px-2 py-1 rounded-full text-xs font-bold ${statusColor}">
                        ${status}
                    </span>
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Koordinat</span>
                        <span class="font-mono text-gray-800">
                            ${currentGPS.lat.toFixed(5)}, ${currentGPS.lng.toFixed(5)}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-600">Jarak Kantor</span>
                        <span class="font-bold text-lg ${statusColor}">
                            ${Math.round(currentGPS.jarak)}m
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Akurasi</span>
                        <span class="text-gray-800">
                            ${Math.round(currentGPS.acc)}m
                        </span>
                    </div>
                </div>
            </div>
        `);

        map.fitBounds([
            [KANTOR.lat, KANTOR.lng],
            [currentGPS.lat, currentGPS.lng]
        ], { padding: [30, 30], maxZoom: 18 });
    }

    // INIT GPS
    function initGPS() {
        logDebug(' Starting GPS...', 'start');
        
        if (!navigator.geolocation) {
            logDebug(' Browser tidak support GPS', 'error');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const acc = position.coords.accuracy;
                const jarak = hitungJarak(lat, lng, KANTOR.lat, KANTOR.lng);
                
                currentGPS = { lat, lng, acc, jarak };
                logDebug(` GPS LOCKED! ${lat.toFixed(5)}, ${lng.toFixed(5)} | Jarak: ${Math.round(jarak)}m | Acc: ${Math.round(acc)}m`, 'success');
                
                updateGPSBadge();
                updateUserMarker();
            },
            (error) => {
                let msg = '';
                switch(error.code) {
                    case 1: msg = 'IZIN GPS DITOLAK'; break;
                    case 2: msg = 'GPS SIGNAL LEMAH'; break;
                    case 3: msg = 'GPS TIMEOUT'; break;
                    default: msg = `ERROR ${error.code}`;
                }
                logDebug(msg, 'error');
                document.getElementById('gpsBadge').textContent = 'GPS Error';
                document.getElementById('gpsBadge').className = 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm animate-pulse';
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 30000
            }
        );
    }

    //UPDATE GPS BADGE
    function updateGPSBadge() {
        const badge1 = document.getElementById('gpsBadge');
        const badge2 = document.getElementById('gpsBadge2');
        const accBadge = document.getElementById('gpsAccuracy');
        
        if (currentGPS && currentGPS.acc < 50 && currentGPS.jarak <= RADIUS_KANTOR) {
            badge1.innerHTML = 'GPS Ready';
            badge1.className = 'bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm shadow-sm';
            badge2.innerHTML = 'Dalam Kantor';
            badge2.className = 'bg-gradient-to-r from-emerald-600 to-green-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg';
            accBadge.textContent = `Akurasi ${Math.round(currentGPS.acc)}m`;
            accBadge.className = 'text-sm font-semibold bg-emerald-100/80 text-emerald-800 px-3 py-1 rounded-full shadow-sm';
        } else if (currentGPS) {
            badge1.innerHTML = `GPS OK`;
            badge1.className = 'bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm animate-pulse';
            badge2.innerHTML = currentGPS.jarak <= RADIUS_KANTOR ? 'DALAM KANTOR' : 'LUAR KANTOR';
            badge2.className = currentGPS.jarak <= RADIUS_KANTOR ? 
                'bg-gradient-to-r from-emerald-600 to-green-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg' :
                'bg-gradient-to-r from-red-600 to-rose-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse';
            accBadge.textContent = `Akurasi ${Math.round(currentGPS.acc)}m`;
            accBadge.className = 'text-sm font-semibold bg-yellow-100/80 text-yellow-800 px-3 py-1 rounded-full shadow-sm animate-pulse';
        }
    }

    //CAMERA
    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: "user", width: { ideal: 640 }, height: { ideal: 480 } },
                audio: false
            });
            document.getElementById('video').srcObject = stream;
            logDebug('Kamera aktif');
        } catch(err) {
            logDebug('Kamera error: ' + err.message, 'error');
            alert('Kamera gagal. Cek izin & HTTPS');
        }
    }

    //ABSEN BUTTONS (ENHANCED)
    function setAbsen(e, type) {
        e.preventDefault();
        if (isLoading) return;
        
        const btnMasuk = document.getElementById("btnMasuk");
        const btnPulang = document.getElementById("btnPulang");

        if (type === 'masuk') {
            btnMasuk.classList.add("ring-4", "ring-blue-400", "ring-opacity-50");
            btnPulang.classList.remove("ring-4", "ring-blue-400", "ring-opacity-50");
        } else {
            btnPulang.classList.add("ring-4", "ring-blue-400", "ring-opacity-50");
            btnMasuk.classList.remove("ring-4", "ring-blue-400", "ring-opacity-50");
        }

        isLoading = true;
        captureDanKirim(type);
    }

    //ABSEN PROCESS
    function captureDanKirim(type) {
        const video = document.getElementById('video');
        if (!video.videoWidth) {
            alert("Kamera masih loading...");
            isLoading = false;
            return;
        }

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0);
        const image = canvas.toDataURL('image/png');
        console.log(image);
        
        kirimAbsensi(image, type);
    }

    sessionStorage.setItem('formattedEmail', '{{ $formattedEmail }}');
    //SEND TO SERVER
    function kirimAbsensi(image, type) {
        if (!currentGPS) {
            alert('GPS belum siap. Tunggu sebentar...');
            isLoading = false;
            return;
        }

        if (currentGPS.jarak > RADIUS_KANTOR) {
            alert(`LUAR AREA KANTOR!\n Jarak: ${Math.round(currentGPS.jarak)}m\n Radius kantor: ${RADIUS_KANTOR}m`);
            isLoading = false;
            return;
        }

        const btnMasuk = document.getElementById("btnMasuk");
        const btnPulang = document.getElementById("btnPulang");
        
        btnMasuk.innerHTML = '<div class="flex items-center gap-3"><svg class="animate-spin w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.3"/><path fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M12 4a8 8 0 018 8h-4"></path></svg><span class="font-semibold">Memproses AI...</span></div>';
        btnPulang.innerHTML = '<div class="flex items-center gap-3"><svg class="animate-spin w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.3"/><path fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M12 4a8 8 0 018 8h-4"></path></svg><span class="font-semibold">Memproses AI...</span></div>';

        fetch('/presensi/upload', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                image: image,
                type: type,
                email: document.querySelector('meta[name="user-email"]').content.toLowerCase(),
                lat: currentGPS.lat,
                lng: currentGPS.lng,
                accuracy: currentGPS.acc,
                distance: currentGPS.jarak,
                timestamp: new Date().toISOString()
            })
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                throw new Error(data.error || `HTTP ${res.status}`);
            }
            return data;
            })
        .then(data => {
            console.log('SERVER OK:', data);
            if (data.error) throw new Error(data.error);
            alert(` Absen ${type.toUpperCase()} BERHASIL!\n Jarak: ${Math.round(currentGPS.jarak)}m\n Akurasi: ${Math.round(currentGPS.acc)}m\n Skor AI: ${data.confidence || 'N/A'}%`);
            location.reload();
        })
        .catch(err => {
            console.error(' ERROR:', err);
            alert(` Gagal absen: ${err.message}`);
            logDebug('Absen gagal: ' + err.message, 'error');
        })
        .finally(() => {
            btnMasuk.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M10.3 7.7a.984.984 0 0 0 0 1.4l1.9 1.9H3c-.55 0-1 .45-1 1s.45 1 1 1h9.2l-1.9 1.9a.984.984 0 0 0 0 1.4c.39.39 1.01.39 1.4 0l3.59-3.59a.996.996 0 0 0 0-1.41L11.7 7.7a.984.984 0 0 0-1.4 0M20 19h-7c-.55 0-1 .45-1 1s.45 1 1 1h7c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-7c-.55 0-1 .45-1 1s.45 1 1 1h7z"/></svg>Absen Masuk';
            btnPulang.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 5h6c.55 0 1-.45 1-1s-.45-1-1-1H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h6c.55 0 1-.45 1-1s-.45-1-1-1H5z"/><path fill="currentColor" d="m20.65 11.65l-2.79-2.79a.501.501 0 0 0-.86.35V11h-7c-.55 0-1 .45-1 1s.45 1 1 1h7v1.79c0 .45.54.67.85.35l2.79-2.79c.2-.19.2-.51.01-.7"/></svg>Absen Pulang';
            isLoading = false;
        })
        
    }

    //INIT EVERYTHING
    window.addEventListener('load', () => {
        logDebug(' Page loaded - Absensi AI Ready');
        initMap();
        startCamera();
        setTimeout(initGPS, 1000);
        
        // Auto retry GPS
        setInterval(() => {
            if (!currentGPS) {
                logDebug(' GPS retry...');
                initGPS();
            }
        }, 20000);
    });

    // LIVE GPS UPDATE every 30s
    setInterval(() => {
        if (currentGPS) {
            navigator.geolocation.getCurrentPosition(pos => {
                const newGPS = {
                    lat: pos.coords.latitude,
                    lng: pos.coords.longitude,
                    acc: pos.coords.accuracy,
                    jarak: hitungJarak(pos.coords.latitude, pos.coords.longitude, KANTOR.lat, KANTOR.lng)
                };
                if (newGPS.acc < currentGPS.acc + 10) {
                    currentGPS = newGPS;
                    updateGPSBadge();
                    updateUserMarker();
                    logDebug(` GPS Update: Jarak ${Math.round(newGPS.jarak)}m | Acc ${Math.round(newGPS.acc)}m`);
                }
            }, () => {}, { enableHighAccuracy: true });
        }
    }, 30000);

    // Right-click map untuk debug
    document.addEventListener('DOMContentLoaded', () => {
    // Tunggu map siap
        const checkMapReady = setInterval(() => {
            const mapEl = document.getElementById('map');
            if (mapEl && map) {  // map udah di-init
                mapEl.addEventListener('contextmenu', (e) => {
                    e.preventDefault();
                    toggleDebug();
                });
                clearInterval(checkMapReady);
            }
        }, 100);
    });

    function toggleMap() {
        const panel = document.getElementById('gpsPanel');
        const btn = event.target;

        panel.classList.toggle('hidden');

        btn.innerHTML = panel.classList.contains('hidden')
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7m0 9.5a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5"/></svg> Lokasi Saya'
            : '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7m0 9.5a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5"/></svg>Tutup Lokasi';

        // Refresh map
        setTimeout(() => {
            if (map) map.invalidateSize();
        }, 200);
        
        // Right-click debug (SAFE)
        const mapEl = document.getElementById('map');
        if (mapEl && !mapEl.dataset.debugAttached) {
            mapEl.addEventListener('contextmenu', (e) => {
                e.preventDefault();
                toggleDebug();
            });
            mapEl.dataset.debugAttached = 'true';
        }
    }
</script>

</body>
</html>