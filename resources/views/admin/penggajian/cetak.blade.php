<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center py-10">

    <!-- Button -->
    <button onclick="window.print()"
        class="no-print fixed top-5 right-5 bg-yellow-500 text-black px-4 py-2 rounded shadow">
        Cetak
    </button>

    <!-- Slip -->
    <div class="bg-white w-[380px] rounded-xl shadow-md p-6 text-sm">

        <!-- Header -->
        <div class="text-center border-b pb-4">
            <h1 class="text-xl font-bold tracking-wide">SIMOWARJO</h1>
            <p class="text-gray-500 text-xs">Slip Gaji Karyawan</p>
            <p class="text-gray-600 text-xs mt-1">
                Periode: {{ \Carbon\Carbon::createFromFormat('Y-m', $gaji->periode)->translatedFormat('F Y') }}
            </p>
        </div>

        <!-- Info -->
        <div class="mt-4 space-y-1 text-gray-700">
            <div class="flex justify-between">
                <span>Nama</span>
                <span class="font-medium">{{ $gaji->karyawan->nama }}</span>
            </div>
            <div class="flex justify-between">
                <span>Jabatan</span>
                <span>{{ $gaji->karyawan->jabatan }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal Cetak</span>
                <span>{{ date('d/m/Y') }}</span>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="mt-5">
            <h2 class="font-semibold text-gray-800 border-b pb-1 mb-2">Pendapatan</h2>
            <div class="flex justify-between">
                <span>Gaji Pokok</span>
                <span>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</span>
            </div>
            <div class="text-xs text-gray-500 mt-1 mb-2">
                Hadir: {{ $gaji->jumlah_hadir }} hari
            </div>

            @if(optional($gaji->karyawan->komponenGaji)->tunjangan_jabatan > 0)
                <div class="flex justify-between mt-1">
                    <span>Tunjangan Jabatan</span>
                    <span>Rp {{ number_format(optional($gaji->karyawan->komponenGaji)->tunjangan_jabatan, 0, ',', '.') }}</span>
                </div>
            @endif

            @if(optional($gaji->karyawan->komponenGaji)->insentif_skill > 0)
                <div class="flex justify-between mt-1">
                    <span>Insentif Skill</span>
                    <span>Rp {{ number_format(optional($gaji->karyawan->komponenGaji)->insentif_skill, 0, ',', '.') }}</span>
                </div>
            @endif
        </div>

        <!-- Potongan -->
        <div class="mt-4">
            <h2 class="font-semibold text-gray-800 border-b pb-1 mb-2">Potongan</h2>

            <div class="flex justify-between">
                <span>Izin</span>
                <span>{{ $gaji->jumlah_izin }} Hr</span>
            </div>
            <div class="flex justify-between">
                <span>Sakit</span>
                <span>{{ $gaji->jumlah_sakit }} Hr</span>
            </div>
            <div class="flex justify-between">
                <span>Alpa</span>
                <span>{{ $gaji->jumlah_alpa }} Hr</span>
            </div>

            <div class="flex justify-between mt-2 text-black-600 font-medium">
                <span>Total Potongan</span>
                <span>- Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Total -->
        <div class="mt-5 border-t pt-4">
            <div class="flex justify-between text-lg font-bold text-gray-900">
                <span>Take Home Pay</span>
                <span>Rp {{ number_format(($gaji->gaji_pokok - $gaji->total_potongan) + optional($gaji->karyawan->komponenGaji)->tunjangan_jabatan + optional($gaji->karyawan->komponenGaji)->insentif_skill, 0, ',', '.') }}</span>
            </div>

            <div class="text-right mt-1 text-xs">
                Status:
                <span class="font-semibold 
                    {{ $gaji->status_pembayaran == 'lunas' ? 'text-black-600' : 'text-yellow-600' }}">
                    {{ strtoupper($gaji->status_pembayaran) }}
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="mb-8">Penerima,</p>
            <div class="border-t w-40 mx-auto"></div>
            <p class="mt-2 font-medium">{{ $gaji->karyawan->nama }}</p>
        </div>

    </div>

</body>

</html>