<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penyewa - Meine Laptop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

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
            background-color: #f9fafb; /* gray-50 */
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <x-navbar />

    <div class="container mx-auto px-4 py-10 max-w-7xl">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 animate-fade-in-up">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-extrabold text-black flex items-center gap-3 tracking-tight">
                    Data Penyewa
                </h1>
                <p class="text-gray-500 text-sm mt-2 ml-1">Manage all customers in one place.</p>
            </div>

            <a href="{{ route('penyewa.create') }}"
               class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-300 bg-black rounded-xl hover:bg-gray-800 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <i class="fa-solid fa-plus mr-2 transition-transform group-hover:rotate-90"></i>
                <span>Tambah Penyewa</span>
            </a>
        </div>

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="animate-fade-in-up bg-white border border-gray-200 border-l-4 border-l-black text-gray-800 p-4 mb-8 rounded-lg shadow-sm flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-black"></i>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-black transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- TABLE CONTAINER --}}
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-bold">
                            <th class="px-6 py-5 text-left">Nama</th>
                            <th class="px-6 py-5 text-left">Telp</th>
                            <th class="px-6 py-5 text-left">Email</th>
                            <th class="px-6 py-5 text-left">Alamat</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                        @forelse($penyewas as $p)
                        <tr class="table-row-hover bg-white transition-colors duration-200">

                            {{-- NAMA (Tanpa Icon, Bold Hitam) --}}
                            <td class="px-6 py-5 align-middle">
                                <span class="text-base font-bold text-black tracking-tight">
                                    {{ $p->nama }}
                                </span>
                            </td>

                            {{-- TELP (Mono font) --}}
                            <td class="px-6 py-5 align-middle">
                                <span class="font-mono text-gray-600 bg-gray-50 px-2 py-1 rounded border border-gray-200 text-xs">
                                    {{ $p->telp }}
                                </span>
                            </td>

                            {{-- EMAIL --}}
                            <td class="px-6 py-5 align-middle text-gray-600">
                                {{ $p->email ?? '-' }}
                            </td>

                            {{-- ALAMAT --}}
                            <td class="px-6 py-5 align-middle text-gray-500 max-w-xs truncate">
                                {{ $p->alamat ?? '-' }}
                            </td>

                            {{-- AKSI (Icon Style Minimalis) --}}
                            <td class="px-6 py-5 align-middle text-center">
                                <div class="flex justify-center items-center space-x-4">
                                    {{-- EDIT --}}
                                    <a href="{{ route('penyewa.edit', $p) }}" 
                                       class="text-gray-400 hover:text-black hover:scale-110 transition-transform duration-200" 
                                       title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-lg"></i>
                                    </a>

                                    {{-- HAPUS --}}
                                    <form action="{{ route('penyewa.destroy', $p) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus penyewa ini? Data akan terhapus permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-gray-400 hover:text-red-600 hover:scale-110 transition-transform duration-200" 
                                                title="Hapus">
                                            <i class="fa-solid fa-trash-can text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-400 bg-white">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-200"></i>
                                    <p class="font-medium text-gray-500">Belum ada data penyewa.</p>
                                    <p class="text-xs mt-1 text-gray-400">Silakan tambahkan data baru.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
        
        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Meine Laptop System.
        </div>

    </div>

</body>
</html>