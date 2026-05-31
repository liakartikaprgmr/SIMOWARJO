@extends('admin.layout')

@section('content')
    <div class="px-6 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Manajemen Payroll</h1>
                    <p class="text-gray-500 mt-1">Kalkulasi dan proses gaji bulanan karyawan</p>
                </div>

                <form action="{{ route('admin.penggajian.payroll') }}" method="GET" class="flex items-center gap-3">
                    <input type="month" name="periode" value="{{ $bulanTerpilih }}"
                        class="rounded-lg border-gray-300 border p-2 focus:ring-red-500 focus:border-red-500 text-sm">
                    <button type="submit"
                        class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Load
                        Data</button>
                </form>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Karyawan</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kehadiran<br><span class="opacity-70 text-[10px]">(Total: 26)</span></th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gaji Pokok</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tunj. & Insentif</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Potongan</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-red-700 font-bold">
                                    Gaji Bersih</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($dataGaji as $item)
                                @php
                                    $currGajiPokok = $item['gaji_pokok'];
                                    $currTunjangan = $item['tunjangan_jabatan'];
                                    $currInsentif = $item['insentif_skill'];
                                    $currPotongan = $item['total_potongan'];
                                    $currGajiBersih = $item['total_gaji'];
                                @endphp
                                <tr class="{{ $item['is_generated'] ? 'bg-gray-50' : '' }}">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item['karyawan']->nama }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $item['karyawan']->jabatan }}</div>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                                        @if($item['is_generated'])
                                            <div class="flex justify-center gap-2 text-[12px] font-medium">
                                                <div title="Hadir" class="text-green-600">H:{{ $item['penggajian']->jumlah_hadir }}
                                                </div>
                                                <div title="Izin" class="text-blue-600">I:{{ $item['penggajian']->jumlah_izin }}
                                                </div>
                                                <div title="Sakit" class="text-orange-500">S:{{ $item['penggajian']->jumlah_sakit }}
                                                </div>
                                                <div title="Alpa" class="text-red-600">A:{{ $item['penggajian']->jumlah_alpa }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex justify-center gap-2 text-[12px] font-medium">
                                                <div title="Hadir" class="text-green-600">H:{{ $item['jumlah_hadir'] }}</div>
                                                <div title="Izin" class="text-blue-600">I:{{ $item['jumlah_izin'] }}</div>
                                                <div title="Sakit" class="text-orange-500">S:{{ $item['jumlah_sakit'] }}</div>
                                                <div title="Alpa" class="text-red-600">A:{{ $item['jumlah_alpa'] }}</div>
                                            </div>
                                            <span class="text-[10px] text-red-500 block mt-1 relative top-[2px]">Estimasi
                                                Otomatis</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rp {{ number_format($currGajiPokok, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div class="text-xs text-green-600 font-medium font-bold">Tunjangan: Rp
                                            {{ number_format($currTunjangan, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-blue-600 font-medium font-bold mt-1">Insentif: Rp
                                            {{ number_format($currInsentif, 0, ',', '.') }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-red-600">
                                        @if($currPotongan > 0)
                                            - Rp {{ number_format($currPotongan, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        <div class="text-red-700">Rp
                                            {{ number_format(($currGajiPokok - $currPotongan) + $currTunjangan + $currInsentif, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-normal mt-1">Sudah termasuk Tunj. & Insentif
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        @if($item['is_generated'])
                                            @if($item['penggajian']->status_pembayaran == 'lunas')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>
                                            @elseif($item['penggajian']->status_pembayaran == 'proses_transfer')
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Proses Transfer</span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Tertunda</span>
                                            @endif
                                        @else
                                            <span
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-500">Belum
                                                Digenerate</span>
                                        @endif
                                    </td>

                                    <td
                                        class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium border-l border-gray-100">
                                        @if(!$item['is_generated'])
                                            <form action="{{ route('admin.penggajian.generate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_karyawan"
                                                    value="{{ $item['karyawan']->id_karyawan }}">
                                                <input type="hidden" name="periode" value="{{ $bulanTerpilih }}">
                                                <input type="hidden" name="gaji_pokok" value="{{ $currGajiPokok }}">
                                                <input type="hidden" name="tunjangan_jabatan" value="{{ $currTunjangan }}">
                                                <input type="hidden" name="insentif_skill" value="{{ $currInsentif }}">
                                                <input type="hidden" name="jumlah_hadir" value="{{ $item['jumlah_hadir'] }}">
                                                <input type="hidden" name="jumlah_izin" value="{{ $item['jumlah_izin'] }}">
                                                <input type="hidden" name="jumlah_sakit" value="{{ $item['jumlah_sakit'] }}">
                                                <input type="hidden" name="jumlah_alpa" value="{{ $item['jumlah_alpa'] }}">
                                                <input type="hidden" name="total_potongan" value="{{ $currPotongan }}">
                                                <input type="hidden" name="total_gaji" value="{{ $currGajiBersih }}">

                                                <button type="submit"
                                                    class="bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded-md transition text-xs font-medium">Generate
                                                    Gaji</button>
                                            </form>
                                        @else
                                            @if($item['penggajian']->status_pembayaran == 'tertunda')
                                                <button type="button" onclick="openPaymentModal({{ $item['penggajian']->id_penggajian }}, '{{ $item['karyawan']->nama_bank }}', '{{ $item['karyawan']->no_rekening }}')"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md transition text-xs font-medium w-full text-center">
                                                    Bayar
                                                </button>
                                            @elseif($item['penggajian']->status_pembayaran == 'proses_transfer')
                                                <span class="text-[10px] text-blue-600 block text-center font-medium w-full px-2 py-1.5 border border-blue-200 bg-blue-50 rounded-md">Menunggu Midtrans...</span>
                                                @if(env('MIDTRANS_MOCK_MODE', true))
                                                    <form action="{{ route('midtrans.simulate_webhook') }}" method="POST" class="mt-1">
                                                        @csrf
                                                        <input type="hidden" name="reference_no" value="{{ $item['penggajian']->midtrans_reference_no }}">
                                                        <button type="submit" class="text-[10px] bg-gray-200 hover:bg-gray-300 w-full rounded py-1 transition text-gray-700">Simulasi Webhook</button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('admin.penggajian.cetak', $item['penggajian']->id_penggajian) }}"
                                                    target="_blank"
                                                    class="bg-gray-800 hover:bg-gray-900 text-white px-3 py-1.5 rounded-md transition text-xs font-medium w-full text-center inline-block">Slip
                                                    Gaji</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(count($dataGaji) == 0)
                    <div class="p-8 text-center text-gray-500">Tidak ada data karyawan ditemukan.</div>
                @endif
            </div>
            <p class="text-xs text-gray-400 mt-4">*Note: Gaji dihitung berdasarkan target hari kerja 26 Hari per bulan.</p>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4 overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">Opsi Pembayaran</h3>
                <button type="button" onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="paymentForm" action="" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="metode_pembayaran" id="metodePembayaranInput">
                
                <p class="text-sm text-gray-600 mb-5">Pilih metode pembayaran gaji untuk karyawan ini:</p>
                
                <div class="space-y-3">
                    <!-- Tunai -->
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition border-gray-200" id="labelTunai" onclick="selectPayment('tunai')">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-md font-bold text-gray-900">Tunai / Manual</h4>
                            <p class="text-xs text-gray-500">Tandai sebagai lunas (pembayaran di luar sistem).</p>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center mr-1" id="radioTunai">
                            <div class="w-2.5 h-2.5 rounded-full bg-green-600 hidden"></div>
                        </div>
                    </label>

                    <!-- Transfer Midtrans -->
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition border-gray-200" id="labelTransfer" onclick="selectPayment('transfer')">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-md font-bold text-gray-900">Transfer Otomatis</h4>
                            <p class="text-xs text-gray-500">Kirim via Midtrans IRIS ke rekening karyawan.</p>
                            <div id="bankInfoWarning" class="text-[10px] text-red-500 mt-1 hidden font-semibold">Data bank/rekening karyawan belum lengkap!</div>
                            <div id="bankInfoSuccess" class="text-[10px] text-blue-500 mt-1 hidden font-semibold"></div>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center mr-1" id="radioTransfer">
                            <div class="w-2.5 h-2.5 rounded-full bg-blue-600 hidden"></div>
                        </div>
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-medium">Batal</button>
                    <button type="submit" id="btnSubmitPayment" disabled class="px-4 py-2 bg-gray-300 text-gray-500 cursor-not-allowed rounded-lg transition text-sm font-bold">Proses Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let isBankReady = false;

        function openPaymentModal(id, bankName, bankAccount) {
            // Set Form Action
            const form = document.getElementById('paymentForm');
            form.action = `/admin/penggajian/${id}/bayar`; // We will create this route

            // Check Bank Data
            isBankReady = (bankName && bankName.trim() !== '') && (bankAccount && bankAccount.trim() !== '');
            
            if (isBankReady) {
                document.getElementById('bankInfoSuccess').classList.remove('hidden');
                document.getElementById('bankInfoSuccess').innerText = `${bankName.toUpperCase()} - ${bankAccount}`;
                document.getElementById('bankInfoWarning').classList.add('hidden');
            } else {
                document.getElementById('bankInfoSuccess').classList.add('hidden');
                document.getElementById('bankInfoWarning').classList.remove('hidden');
            }

            // Reset selection
            resetSelection();
            
            // Show modal
            const modal = document.getElementById('paymentModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePaymentModal() {
            const modal = document.getElementById('paymentModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            resetSelection();
        }

        function resetSelection() {
            document.getElementById('metodePembayaranInput').value = '';
            document.getElementById('btnSubmitPayment').disabled = true;
            document.getElementById('btnSubmitPayment').classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            document.getElementById('btnSubmitPayment').classList.remove('bg-red-700', 'text-white', 'hover:bg-red-800');

            document.getElementById('labelTunai').classList.remove('border-green-500', 'bg-green-50');
            document.querySelector('#radioTunai div').classList.add('hidden');

            document.getElementById('labelTransfer').classList.remove('border-blue-500', 'bg-blue-50', 'opacity-50');
            document.querySelector('#radioTransfer div').classList.add('hidden');
        }

        function selectPayment(metode) {
            resetSelection();

            if (metode === 'transfer' && !isBankReady) {
                alert('Tidak bisa memilih transfer karena data bank karyawan belum lengkap! Silakan update di menu Kelola Karyawan.');
                return;
            }

            document.getElementById('metodePembayaranInput').value = metode;
            const btnSubmit = document.getElementById('btnSubmitPayment');
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            btnSubmit.classList.add('bg-red-700', 'text-white', 'hover:bg-red-800');

            if (metode === 'tunai') {
                document.getElementById('labelTunai').classList.add('border-green-500', 'bg-green-50');
                document.querySelector('#radioTunai div').classList.remove('hidden');
            } else if (metode === 'transfer') {
                document.getElementById('labelTransfer').classList.add('border-blue-500', 'bg-blue-50');
                document.querySelector('#radioTransfer div').classList.remove('hidden');
            }
        }
    </script>
@endsection