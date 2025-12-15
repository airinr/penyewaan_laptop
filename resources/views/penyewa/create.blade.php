<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penyewa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <x-navbar />

    <div class="container mx-auto px-4 py-10 max-w-3xl">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fa-solid fa-user-plus text-indigo-600"></i>
                    Tambah Penyewa
                </h1>
                <p class="text-gray-500 text-sm mt-1 ml-10">Isi data penyewa baru di bawah ini.</p>
            </div>

            <a href="{{ route('penyewa.index') }}"
               class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-full shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="animate-fade-in-up bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-6">
                <ul class="list-disc ml-6 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="p-8">
                <form action="{{ route('penyewa.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-user text-indigo-500 mr-2"></i> Nama
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                               class="w-full border border-gray-300 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                               placeholder="Nama lengkap" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-phone text-indigo-500 mr-2"></i> Telp / WA
                        </label>
                        <input type="text" name="telp" value="{{ old('telp') }}"
                               class="w-full border border-gray-300 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                               placeholder="Contoh: 081234567890" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-envelope text-indigo-500 mr-2"></i> Email 
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full border border-gray-300 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                               placeholder="contoh@email.com">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-location-dot text-indigo-500 mr-2"></i> Alamat 
                        </label>
                        <textarea name="alamat" rows="3"
                                  class="w-full border border-gray-300 rounded-xl py-3 px-4 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                  placeholder="Alamat domisili">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('penyewa.index') }}"
                           class="px-6 py-3 rounded-xl text-gray-600 hover:bg-gray-100 font-semibold transition">
                            Batal
                        </a>

                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-1 transition-all duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</body>
</html>
