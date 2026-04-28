@extends('admin.layout')

@section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="px-6 py-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Geolokasi Kantor</h1>
            <p class="text-gray-500 mb-6">Tentukan titik pusat dan radius jangkauan absensi karyawan.</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Card -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-1 h-fit">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Konfigurasi Koordinat</h2>
                    <form action="{{ route('admin.geolokasi.update') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" value="{{ old('nama_lokasi', $geolokasi->nama_lokasi) }}"
                                required
                                class="shadow-sm appearance-none border border-gray-300 rounded w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500">
                            @error('nama_lokasi') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Latitude (Garis Lintang)</label>
                            <input type="text" id="latitudeInput" name="latitude"
                                value="{{ old('latitude', $geolokasi->latitude) }}" required readonly
                                class="bg-gray-50 shadow-sm appearance-none border border-gray-300 rounded w-full py-2.5 px-3 text-gray-500 leading-tight focus:outline-none cursor-not-allowed">
                            @error('latitude') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Longitude (Garis Bujur)</label>
                            <input type="text" id="longitudeInput" name="longitude"
                                value="{{ old('longitude', $geolokasi->longitude) }}" required readonly
                                class="bg-gray-50 shadow-sm appearance-none border border-gray-300 rounded w-full py-2.5 px-3 text-gray-500 leading-tight focus:outline-none cursor-not-allowed">
                            @error('longitude') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Radius Absensi (Meter)</label>
                            <div class="flex items-center">
                                <input type="number" id="radiusInput" name="radius"
                                    value="{{ old('radius', $geolokasi->radius) }}" required min="10"
                                    class="shadow-sm appearance-none border border-gray-300 rounded-l w-full py-2.5 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500">
                                <span
                                    class="bg-gray-100 border border-l-0 border-gray-300 px-4 py-2.5 rounded-r text-gray-600 font-medium">m</span>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-1">Ubah angka ini untuk menyesuaikan besar lingkaran pada
                                peta.</p>
                            @error('radius') <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2.5 px-4 rounded-lg focus:outline-none focus:shadow-outline transition">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Map Card -->
                <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-100 lg:col-span-2 flex flex-col">
                    <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-lg">
                        <div>
                            <h2 class="text-sm font-bold text-gray-800">Peta Interaktif</h2>
                            <p class="text-xs text-gray-500">Geser atau klik pada peta untuk mengubah titik kordinat.</p>
                        </div>
                        <button type="button" id="btnCurrentLocation"
                            class="text-xs bg-white border shadow-sm px-3 py-1.5 rounded-md hover:bg-gray-50 flex items-center gap-1 font-medium text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4s-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7s7 3.13 7 7s-3.13 7-7 7z" />
                            </svg>
                            Gunakan Lokasi Saat Ini
                        </button>
                    </div>
                    <div id="map" class="w-full h-[500px] rounded-b-lg z-0"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Init variables
            const latInput = document.getElementById('latitudeInput');
            const lngInput = document.getElementById('longitudeInput');
            const radiusInput = document.getElementById('radiusInput');

            let currentLat = parseFloat(latInput.value) || -6.4915853;
            let currentLng = parseFloat(lngInput.value) || 107.8846398;
            let currentRadius = parseInt(radiusInput.value) || 150;

            // Init Map
            const map = L.map('map').setView([currentLat, currentLng], 16);

            // Add Google Streets tile layer
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            // Add Marker
            let marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

            // Add Circle to represent Radius
            let circle = L.circle([currentLat, currentLng], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.2,
                radius: currentRadius
            }).addTo(map);

            // Function to update inputs and map visuals
            function updateLocation(lat, lng, rad) {
                latInput.value = lat.toFixed(8);
                lngInput.value = lng.toFixed(8);

                const newLatLng = new L.LatLng(lat, lng);
                marker.setLatLng(newLatLng);
                circle.setLatLng(newLatLng);
                circle.setRadius(rad);

                map.panTo(newLatLng);
            }

            // Marker drag event
            marker.on('dragend', function (e) {
                const position = marker.getLatLng();
                updateLocation(position.lat, position.lng, parseInt(radiusInput.value) || 150);
            });

            // Map click event
            map.on('click', function (e) {
                updateLocation(e.latlng.lat, e.latlng.lng, parseInt(radiusInput.value) || 150);
            });

            // Radius input change event
            radiusInput.addEventListener('input', function (e) {
                let newRadius = parseInt(e.target.value);
                if (newRadius > 0) {
                    circle.setRadius(newRadius);
                }
            });

            // Current Location Button
            document.getElementById('btnCurrentLocation').addEventListener('click', function () {
                if (navigator.geolocation) {
                    this.innerHTML = "Mencari...";
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            updateLocation(position.coords.latitude, position.coords.longitude, parseInt(radiusInput.value) || 150);
                            document.getElementById('btnCurrentLocation').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4s-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7s7 3.13 7 7s-3.13 7-7 7z"/></svg> Gunakan Lokasi Saat Ini`;
                        },
                        function (error) {
                            alert("Tidak bisa mendeteksi lokasi: " + error.message);
                            document.getElementById('btnCurrentLocation').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4s-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7s7 3.13 7 7s-3.13 7-7 7z"/></svg> Gunakan Lokasi Saat Ini`;
                        },
                        { enableHighAccuracy: true }
                    );
                } else {
                    alert("Geolocation tidak didukung oleh browser ini.");
                }
            });
        });
    </script>
@endsection