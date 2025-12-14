<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Laptop Bulanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .slide-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-800">

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden slide-up">
            
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6 flex items-center justify-between">
                <h2 class="text-white text-2xl font-bold flex items-center gap-3">
                    <i class="fa-solid fa-calendar-days"></i> Sewa Bulanan
                </h2>
                <div class="text-white opacity-80 text-sm bg-white/20 px-3 py-1 rounded-full">
                    <i class="fa-solid fa-calendar-check"></i> {{ date('d M Y') }}
                </div>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm">
                        <ul class="list-disc ml-6 text-sm">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('penyewaan.store') }}" method="POST" id="rentalForm">
                    @csrf

                    <div class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-laptop text-purple-500"></i> Pilih Unit Laptop
                        </label>
                        <div class="relative">
                            <select name="id_laptop" id="laptopSelect" class="block w-full bg-gray-50 border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-400 cursor-pointer" required onchange="hitungTotal()">
                                <option value="" data-price="0">-- Klik untuk memilih --</option>
                                @foreach($laptops as $laptop)
                                    <option value="{{ $laptop->id_laptop }}" data-price="{{ $laptop->harga_sewa }}">
                                        {{ $laptop->brand }} {{ $laptop->model }} - Rp {{ number_format($laptop->harga_sewa) }} / bulan
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-8"></div>

                    <div x-data="{ tipe: 'lama' }" class="mb-8">
                        <label class="block text-gray-700 text-sm font-bold mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-user-tag text-purple-500"></i> Identitas Penyewa
                        </label>
                        
                        <div class="flex p-1 bg-gray-100 rounded-lg w-full md:w-fit mb-6">
                            <label class="flex-1 text-center cursor-pointer px-4 py-2 rounded-md text-sm font-medium transition-all" 
                                :class="tipe === 'lama' ? 'bg-white text-purple-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'">
                                <input type="radio" name="tipe_penyewa" value="lama" x-model="tipe" class="hidden">
                                Member Lama
                            </label>
                            
                            <label class="flex-1 text-center cursor-pointer px-4 py-2 rounded-md text-sm font-medium transition-all"
                                :class="tipe === 'baru' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'">
                                <input type="radio" name="tipe_penyewa" value="baru" x-model="tipe" class="hidden">
                                Member Baru
                            </label>
                        </div>

                        <div x-show="tipe === 'lama'" x-transition>
                            <select name="id_penyewa_lama" class="block w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:ring-2 focus:ring-purple-400">
                                <option value="">-- Cari Nama Penyewa --</option>
                                @foreach($penyewas as $p)
                                    <option value="{{ $p->id_penyewa }}">{{ $p->nama }} ({{ $p->telp }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div x-show="tipe === 'baru'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-5 bg-gray-50 p-5 rounded-xl border border-gray-200">
                            <div class="col-span-2 md:col-span-1"><input type="text" name="nama_baru" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-green-400 border-gray-300" placeholder="Nama Lengkap"></div>
                            <div class="col-span-2 md:col-span-1"><input type="number" name="telp_baru" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-green-400 border-gray-300" placeholder="No Telp/WA"></div>
                            <div class="col-span-2 md:col-span-1"><input type="email" name="email_baru" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-green-400 border-gray-300" placeholder="Email"></div>
                            <div class="col-span-2 md:col-span-1"><input type="text" name="alamat_baru" class="w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-green-400 border-gray-300" placeholder="Alamat Domisili"></div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-8"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-regular fa-calendar-check text-purple-500"></i> Tanggal Ambil</label>
                            <input type="date" name="tgl_mulai" id="tglMulai" value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:ring-2 focus:ring-purple-400" onchange="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-regular fa-calendar-xmark text-red-500"></i> Rencana Selesai</label>
                            <input type="date" name="tgl_selesai" id="tglSelesai" class="w-full border border-red-200 bg-red-50 rounded-lg py-3 px-4 text-gray-700 focus:ring-2 focus:ring-red-400" required onchange="hitungTotal()">
                        </div>
                    </div>

                    <div class="mb-8 bg-purple-50 p-6 rounded-xl border border-purple-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Estimasi Tagihan</p>
                            <p class="text-xs text-purple-400 mt-1" id="infoDurasi">Harga Bulanan x 0 Bulan</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-bold text-purple-700" id="displayHarga">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-10">
                        <a href="{{ route('penyewaan') }}" class="px-6 py-3 rounded-lg text-gray-500 hover:bg-gray-100 font-semibold transition-colors">Batal</a>
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-purple-500/30 transform hover:-translate-y-1 transition-all duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Simpan Transaksi
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function hitungTotal() {
            // 1. Ambil Harga Per Bulan
            const laptopSelect = document.getElementById('laptopSelect');
            const selectedOption = laptopSelect.options[laptopSelect.selectedIndex];
            const hargaPerBulan = parseFloat(selectedOption.getAttribute('data-price')) || 0;

            // 2. Ambil Tanggal
            const tglMulai = new Date(document.getElementById('tglMulai').value);
            const tglSelesai = new Date(document.getElementById('tglSelesai').value);

            let total = 0;
            let bulan = 0;

            if (hargaPerBulan > 0 && tglMulai && tglSelesai && !isNaN(tglMulai) && !isNaN(tglSelesai)) {
                // Pastikan tanggal selesai > tanggal mulai
                if (tglSelesai > tglMulai) {
                    
                    // Hitung selisih Tahun dan Bulan
                    let years = tglSelesai.getFullYear() - tglMulai.getFullYear();
                    let months = tglSelesai.getMonth() - tglMulai.getMonth();
                    let days = tglSelesai.getDate() - tglMulai.getDate();

                    // Total selisih bulan murni
                    bulan = (years * 12) + months;

                    // LOGIC CEILING (Pembulatan ke Atas):
                    // Jika ada kelebihan hari (misal 1 Jan - 2 Feb), dianggap masuk bulan ke-2
                    if (days > 0) {
                        bulan += 1;
                    } 
                    // Jika bulan masih 0 (kurang dari sebulan), hitung 1 bulan
                    if (bulan < 1) bulan = 1;

                    total = bulan * hargaPerBulan;
                }
            }

            // Update UI
            document.getElementById('infoDurasi').innerText = 'Harga Bulanan x ' + bulan + ' Bulan';
            document.getElementById('displayHarga').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>

</body>
</html>