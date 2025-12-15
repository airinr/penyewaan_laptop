<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Laptop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased">
    <x-navbar />

    <div class="container mx-auto px-4 py-10 max-w-6xl">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Daftar Laptop</h1>
                <p class="text-gray-500 mt-2 text-lg">Manage inventaris penyewaan dengan mudah.</p>
            </div>
            <a href="{{ route('laptop.create') }}" 
               class="group relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white transition-all duration-200 bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5">
                <i class="fa-solid fa-plus mr-2 transition-transform group-hover:rotate-90"></i> 
                Tambah Laptop
            </a>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-r shadow-sm flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-regular fa-circle-check text-xl"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-green-500 hover:text-green-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-r shadow-sm flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i> <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Brand & Model</th>
                        <th class="px-6 py-4">Harga Sewa</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Detail</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                
                @forelse($laptops as $laptop)
                <tbody x-data="{ open: false }" class="border-b border-gray-100 group hover:bg-gray-50/50 transition-colors duration-150">
                    
                    <tr>
                        <td class="px-6 py-4 align-middle">
                            <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded border border-gray-300 font-mono">
                                {{ $laptop->kode_laptop }}
                            </span>
                        </td>

                        <td class="px-6 py-4 align-middle">
                            <div class="flex flex-col">
                                <span class="text-gray-900 font-bold text-base">{{ $laptop->brand }}</span>
                                <span class="text-gray-500 text-sm">{{ $laptop->model }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 align-middle">
                            <span class="text-indigo-600 font-bold">Rp {{ number_format($laptop->harga_sewa, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-xs">/hari</span>
                        </td>

                        <td class="px-6 py-4 align-middle text-center">
                            @php
                                $statusStyle = match($laptop->status) {
                                    'available' => 'bg-green-100 text-green-700 border-green-200 ring-green-500',
                                    'disewa' => 'bg-amber-100 text-amber-700 border-amber-200 ring-amber-500',
                                    'tidak disewakan' => 'bg-red-100 text-red-700 border-red-200 ring-red-500',
                                    default => 'bg-gray-100 text-gray-600 border-gray-200 ring-gray-400'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusStyle }}">
                                {{ ucfirst($laptop->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 align-middle text-center">
                            <button @click="open = !open" 
                                    class="group inline-flex items-center justify-center px-3 py-1.5 rounded-full border border-gray-200 hover:border-indigo-300 bg-white hover:bg-indigo-50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-300 shadow-sm">
                                    
                                <span class="text-xs font-semibold text-gray-500 group-hover:text-indigo-600 mr-2 transition-colors duration-300"
                                    x-text="open ? 'Tutup' : 'Lihat'"></span>

                                <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-indigo-600 transition-transform duration-500"
                                :class="{'rotate-180': open}"></i>
                            </button>
                        </td>

                        <td class="px-6 py-4 align-middle text-center">
                            <div class="flex justify-center items-center space-x-3 opacity-80 hover:opacity-100 transition-opacity">
                                @if($laptop->status == 'disewa')
                                    <button type="button" class="text-gray-300 cursor-not-allowed" title="Sedang disewa (Tidak bisa diedit)">
                                        <i class="fa-solid fa-pen-to-square text-lg"></i>
                                    </button>
                                @else
                                    <a href="{{ route('laptop.edit', $laptop->id_laptop) }}" class="text-amber-500 hover:text-amber-600 hover:scale-110 transition-transform" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-lg"></i>
                                    </a>
                                @endif
                                
                                <form action="{{ route('laptop.destroy', $laptop->id_laptop) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 hover:scale-110 transition-transform" title="Hapus">
                                        <i class="fa-solid fa-trash-can text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <tr x-show="open" 
                        class="bg-indigo-50/30 shadow-inner border-t border-indigo-100 relative">
                        <td colspan="6" class="p-0">
                            <div class="overflow-hidden"
                                 x-show="open"
                                 x-transition:enter="transition-all ease-out duration-500"
                                 x-transition:enter-start="max-h-0 opacity-0 translate-y-[-10px]"
                                 x-transition:enter-end="max-h-96 opacity-100 translate-y-0"
                                 x-transition:leave="transition-all ease-in duration-300"
                                 x-transition:leave-start="max-h-96 opacity-100 translate-y-0"
                                 x-transition:leave-end="max-h-0 opacity-0 translate-y-[-10px]">
                                
                                <div class="p-6 flex items-start gap-5">
                                    <div class="flex-shrink-0 mt-1"
                                         x-show="open"
                                         x-transition:enter="transition-all ease-out duration-700 delay-100"
                                         x-transition:enter-start="opacity-0 scale-0 rotate-[-45deg]"
                                         x-transition:enter-end="opacity-100 scale-100 rotate-0">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                                            <i class="fa-solid fa-microchip text-xl"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-grow"
                                         x-show="open"
                                         x-transition:enter="transition-all ease-out duration-500 delay-200"
                                         x-transition:enter-start="opacity-0 translate-x-4"
                                         x-transition:enter-end="opacity-100 translate-x-0">
                                        <h4 class="text-sm font-bold text-indigo-900 uppercase tracking-wide mb-2">Spesifikasi Teknis</h4>
                                        <p class="text-gray-700 text-sm leading-relaxed bg-white/60 p-3 rounded-lg border border-indigo-100">
                                            {{ $laptop->spesifikasi }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </td>
                    </tr>
                </tbody>
                @empty
                <tbody>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 bg-gray-50">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-folder-open text-5xl mb-4 text-gray-300"></i>
                                <p class="text-lg font-medium">Belum ada data laptop.</p>
                                <p class="text-sm mt-1">Silakan tambahkan data baru.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
                @endforelse
            </table>
        </div>
        
        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; 2025 Rental Laptop System. All rights reserved.
        </div>

    </div>

</body>
</html>