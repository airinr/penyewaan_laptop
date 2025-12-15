<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penyewa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }

        /* Animasi Custom */
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Smooth Row Hover */
        .table-row-hover:hover {
            transform: scale(1.01);
            background-color: #f8fafc;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 10;
            position: relative;
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    {{-- Navbar dari resources/views/components/navbar.blade.php --}}
    <x-navbar />

    <div class="container mx-auto px-4 py-10">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 animate-fade-in-up">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fa-solid fa-users text-indigo-600"></i>
                    Data Penyewa
                </h1>
                <p class="text-gray-500 text-sm mt-1 ml-10">Daftar penyewa yang terdaftar pada sistem.</p>
            </div>

            <a href="{{ route('penyewa.create') }}"
               class="group bg-indigo-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-indigo-700 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                <i class="fa-solid fa-plus transition-transform group-hover:rotate-180"></i>
                <span>Tambah Penyewa</span>
            </a>
        </div>

        {{-- ALERT SUCCESS (opsional) --}}
        @if(session('success'))
            <div class="animate-fade-in-up bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- TABLE --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-indigo-50 text-indigo-900 uppercase text-xs font-bold tracking-wider">
                            <th class="px-6 py-4 text-left"><i class="fa-solid fa-user mr-1"></i> Nama</th>
                            <th class="px-6 py-4 text-left"><i class="fa-solid fa-phone mr-1"></i> Telp</th>
                            <th class="px-6 py-4 text-left"><i class="fa-solid fa-envelope mr-1"></i> Email</th>
                            <th class="px-6 py-4 text-left"><i class="fa-solid fa-location-dot mr-1"></i> Alamat</th>
                            <th class="px-6 py-4 text-center"><i class="fa-solid fa-sliders mr-1"></i> Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                        @forelse($penyewas as $p)
                        <tr class="table-row-hover bg-white transition-colors duration-200">

                            {{-- NAMA dibuat lebih besar & rapi --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="text-base font-extrabold text-gray-800">
                                        {{ $p->nama }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-gray-600 font-mono">{{ $p->telp }}</td>
                            <td class="px-6 py-5 text-blue-600">{{ $p->email ?? '-' }}</td>
                            <td class="px-6 py-5 text-gray-600">{{ $p->alamat ?? '-' }}</td>

                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- EDIT (resource route) --}}
                                    <a href="{{ route('penyewa.edit', $p) }}"
                                       class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold py-2 px-3 rounded-lg shadow-md transition-all transform hover:scale-105 inline-flex items-center gap-2">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>

                                    {{-- HAPUS (resource route) --}}
                                    <form action="{{ route('penyewa.destroy', $p) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus penyewa ini? Data akan terhapus permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 active:bg-red-800 text-white text-xs font-bold py-2 px-3 rounded-lg shadow-md transition-all transform hover:scale-105 inline-flex items-center gap-2">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                    <p>Belum ada data penyewa.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</body>
</html>
