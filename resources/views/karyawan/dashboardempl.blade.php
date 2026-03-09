@extends('karyawan.layoutempl')

@section('content')

<main class="ml-45 mt-10 p-5">

<!-- HERO -->
<div class="bg-red-800 text-white rounded-xl p-6 md:p-8 mb-8">

<h1 class="text-2xl md:text-3xl font-bold mb-3">
Dashboard Karyawan SIMOWARJO
</h1>


<button class="bg-white text-black px-4 py-2 rounded-lg">
Lihat Laporan
</button>

</div>

<!-- CARD STATS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

<!-- STATUS ABSEN -->
<div class="bg-green-500 p-6 rounded-xl shadow text-white">
<h3 class="text-sm">Status Kehadiran</h3>
<p class="text-2xl font-bold mt-2">Hadir</p>
</div>

<!-- TOTAL JAM KERJA -->
<div class="bg-blue-500 p-6 rounded-xl shadow text-white">
<h3 class="text-sm">Jam Kerja Minggu Ini</h3>
<p class="text-2xl font-bold mt-2">32 Jam</p>
</div>

<!-- SHIFT HARI INI -->
<div class="bg-purple-500 p-6 rounded-xl shadow text-white">
<h3 class="text-sm">Shift Hari Ini</h3>
<p class="text-2xl font-bold mt-2">Siang</p>
</div>

<!-- GAJI BULAN INI -->
<div class="bg-yellow-400 p-6 rounded-xl shadow text-black">
<h3 class="text-sm">Estimasi Gaji</h3>
<p class="text-2xl font-bold mt-2">Rp3.200.000</p>
</div>

</div>


@endsection