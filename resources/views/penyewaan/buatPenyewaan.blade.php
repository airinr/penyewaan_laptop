<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Sewa Baru - Meine Laptop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <x-navbar />

    <div class="container mx-auto px-4 py-10 max-w-4xl">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 animate-fade-in-up gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-black flex items-center gap-3 tracking-tight">
                    Buat Sewa Baru
                </h1>
                <p class="text-gray-500 text-sm mt-2 ml-1">
                    Create a new monthly rental transaction.
                </p>
            </div>

            <a href="{{ route('penyewaan') }}"
               class="group inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-black transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- ERROR ALERT --}}
        @if ($errors->any())
            <div class="animate-fade-in-up bg-white border border-gray-200 border-l-4 border-l-red-600 text-gray-800 p-4 rounded-lg shadow-sm mb-6">
                <div class="flex items-center gap-2 mb-2 text-red-600 font-bold">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Please fix the following errors:</span>
                </div>
                <ul class="list-disc ml-6 text-sm text-gray-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM CARD --}}
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-200 animate-fade-in-up" style="animation-delay: .1s;">
            <div class="p-8 md:p-10">
                
                <form action="{{ route('penyewaan.store') }}" method="POST" id="rentalForm" class="space-y-8">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Pilih Unit Laptop
                        </label>
                        <div class="relative">
                            <select name="id_laptop" id="laptopSelect" 
                                class="block w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-black focus:border-black focus:outline-none transition-all bg-gray-50 focus:bg-white appearance-none cursor-pointer" 
                                required onchange="hitungTotal()">
                                <option value="" data-price="0">-- Klik untuk memilih --</option>
                                @foreach($laptops as $laptop)
                                    <option value="{{ $laptop->id_laptop }}" data-price="{{ $laptop->harga_sewa }}">
                                        {{ $laptop->brand }} {{ $laptop->model }} - Rp {{ number_format($laptop->harga_sewa) }} / bulan
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <div x-data="{ tipe: 'lama' }">
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Identitas Penyewa
                        </label>
                        
                        <div class="flex p-1 bg-gray-100 rounded-xl w-full md:w-fit mb-6 border border-gray-200">
                            <label class="flex-1 text-center cursor-pointer px-6 py-2 rounded-lg text-sm font-medium transition-all" 
                                :class="tipe === 'lama' ? 'bg-black text-white shadow-md' : 'text-gray-500 hover:text-gray-900'">
                                <input type="radio" name="tipe_penyewa" value="lama" x-model="tipe" class="hidden">
                                Member Lama
                            </label>
                            
                            <label class="flex-1 text-center cursor-pointer px-6 py-2 rounded-lg text-sm font-medium transition-all"
                                :class="tipe === 'baru' ? 'bg-black text-white shadow-md' : 'text-gray-500 hover:text-gray-900'">
                                <input type="radio" name="tipe_penyewa" value="baru" x-model="tipe" class="hidden">
                                Member Baru
                            </label>
                        </div>

                        <div x-show="tipe === 'lama'" x-transition>
                            <div class="relative">
                                <select name="id_penyewa_lama" class="block w-full border border-gray-200 rounded-xl py-3 px-4 text-gray-700 focus:ring-2 focus:ring-black focus:border-black focus:outline-none bg-gray-50 focus:bg-white appearance-none">
                                    <option value="">-- Cari Nama Penyewa --</option>
                                    @foreach($penyewas as $p)
                                        <option value="{{ $p->id_penyewa }}">{{ $p->nama }} ({{ $p->telp }})</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-search text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div x-show="tipe === 'baru'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-5 bg-gray-50 p-6 rounded-2xl border border-gray-200">
                            <div class="md:col-span-1">
                                <input type="text" name="nama_baru" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-black focus:border-black focus:outline-none" placeholder="Nama Lengkap">
                            </div>
                            <div class="md:col-span-1">
                                <input type="number" name="telp_baru" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-black focus:border-black focus:outline-none" placeholder="No Telp/WA">
                            </div>
                            <div class="md:col-span-1">
                                <input type="email" name="email_baru" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-black focus:border-black focus:outline-none" placeholder="Email">
                            </div>
                            <div class="md:col-span-1">
                                <input type="text" name="alamat_baru" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-black focus:border-black focus:outline-none" placeholder="Alamat Domisili">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Ambil</label>
                            <input type="date" name="tgl_mulai" id="tglMulai" value="{{ date('Y-m-d') }}" 
                                class="w-full border border-gray-200 rounded-xl py-3 px-4 text-gray-700 focus:ring-2 focus:ring-black focus:border-black focus:outline-none bg-gray-50 focus:bg-white" 
                                onchange="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Rencana Selesai</label>
                            <input type="date" name="tgl_selesai" id="tglSelesai" 
                                class="w-full border border-gray-200 rounded-xl py-3 px-4 text-gray-700 focus:ring-2 focus:ring-black focus:border-black focus:outline-none bg-gray-50 focus:bg-white" 
                                required onchange="hitungTotal()">
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Estimasi Tagihan</p>
                            <p class="text-sm text-gray-600 mt-1 font-medium" id="infoDurasi">-- Bulan</p>
                        </div>
                        <div class="text-right">
                            <span class="text-3xl font-extrabold text-black tracking-tight" id="displayHarga">Rp 0</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6">
                        <a href="{{ route('penyewaan') }}" 
                           class="px-6 py-3 rounded-xl text-gray-600 hover:text-black hover:bg-gray-100 font-semibold transition text-sm">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-paper-plane"></i> Submit Rental
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function hitungTotal() {
            const laptopSelect = document.getElementById('laptopSelect');
            const selectedOption = laptopSelect.options[laptopSelect.selectedIndex];
            const hargaPerBulan = parseFloat(selectedOption.getAttribute('data-price')) || 0;

            const tglMulai = new Date(document.getElementById('tglMulai').value);
            const tglSelesai = new Date(document.getElementById('tglSelesai').value);

            let total = 0;
            let bulan = 0;

            if (hargaPerBulan > 0 && tglMulai && tglSelesai && !isNaN(tglMulai) && !isNaN(tglSelesai)) {
                if (tglSelesai > tglMulai) {
                    
                    let years = tglSelesai.getFullYear() - tglMulai.getFullYear();
                    let months = tglSelesai.getMonth() - tglMulai.getMonth();
                    let days = tglSelesai.getDate() - tglMulai.getDate();

                    bulan = (years * 12) + months;

                    if (days > 0) {
                        bulan += 1;
                    } 
                    if (bulan < 1) bulan = 1;

                    total = bulan * hargaPerBulan;
                }
            }

            document.getElementById('infoDurasi').innerText = `Harga Bulanan x ${bulan} Bulan`;
            document.getElementById('displayHarga').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>

</body>
</html>