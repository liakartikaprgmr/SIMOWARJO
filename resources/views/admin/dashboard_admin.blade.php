@extends('admin.layout')

@section('content')

<main class="ml-45 mt-10 p-5">

<!-- HERO -->
<div class="bg-red-800 text-white rounded-xl p-6 md:p-8 mb-8">

<h1 class="text-2xl md:text-3xl font-bold mb-3">
Dashboard Admin SIMOWARJO
</h1>


<button class="bg-white text-black px-4 py-2 rounded-lg">
Lihat Laporan
</button>

</div>



<!-- CARD STATS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

<!-- TOTAL KARYAWAN -->
<div class="bg-sky-400 p-6 rounded-xl shadow">
<h3 class="text-black text-sm">Total Karyawan</h3>
<p class="text-2xl font-bold mt-2">45</p>
</div>

<!-- KEHADIRAN -->
<div class="bg-green-500 p-6 rounded-xl shadow">
<h3 class="text-black text-sm">Kehadiran Hari Ini</h3>
<p class="text-2xl font-bold mt-2">38</p>
</div>

<!-- PENGGAJIAN -->
<div class="bg-yellow-400 p-6 rounded-xl shadow">
<h3 class="text-black text-sm">Penggajian Bulan Ini</h3>
<p class="text-2xl font-bold mt-2">Rp120JT</p>
</div>

<!-- STOK -->
<div class="bg-orange-500 p-6 rounded-xl shadow">
<h3 class="text-black text-sm">Stok Barang</h3>
<p class="text-2xl font-bold mt-2">124</p>
</div>

</div>



<!-- CHART SECTION -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

<!-- BAR CHART -->
<div class="bg-white p-6 rounded-xl shadow h-80">
<h2 class="text-lg font-semibold mb-4">Statistik Kehadiran</h2>
<canvas id="attendanceChart"></canvas>
</div>




<!-- PIE CHART -->
<div class="bg-white p-6 rounded-xl shadow ">
    <h2 class="text-lg font-semibold mb-4">
    Distribusi Stok Barang
    </h2>
    <canvas id="stockChart"></canvas>
</div>

</div>

</main>



<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// BAR CHART KEHADIRAN
const attendanceCtx = document.getElementById('attendanceChart');

new Chart(attendanceCtx, {
type: 'bar',
data: {
labels: ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
datasets: [{
label: 'Jumlah Kehadiran',
data: [40,42,38,41,39,35],
backgroundColor: '#3b82f6'
}]
},
options: {
responsive: true,
maintainAspectRatio: false,
plugins: {
legend: {
display: false
}
}
}
});



// PIE CHART STOK
const stockCtx = document.getElementById('stockChart');

new Chart(stockCtx, {
type: 'pie',
data: {
labels: ['Bahan Makanan','Minuman','Peralatan','Lainnya'],
datasets: [{
data: [40,25,20,15],
backgroundColor: [
'#22c55e',
'#3b82f6',
'#f59e0b',
'#ef4444'
]
}]
},
options: {
responsive: true
}
});

</script>

@endsection