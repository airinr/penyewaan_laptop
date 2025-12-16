<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Laptop - Meine Laptop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .table-row-hover:hover {
            background-color: #f9fafb;
            transform: scale-[1.01];
            transition: all 0.2s ease;
        }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    <x-navbar />

    <div class="container mx-auto px-4 py-10 max-w-7xl">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 animate-fade-in-up">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-extrabold text-black tracking-tight">Daftar Laptop</h1>
                <p class="text-gray-500 mt-2 text-sm">Manage all laptops in one place.</p>
            </div>
            
            <a href="{{ route('laptop.create') }}" 
               class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-300 bg-black rounded-xl hover:bg-gray-800 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <i class="fa-solid fa-plus mr-2 transition-transform group-hover:rotate-90"></i> 
                Tambah Unit
            </a>
        </div>

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
                <button @click="show = false" class="text-gray-400 hover:text-black transition-colors"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="animate-fade-in-up bg-white border border-gray-200 border-l-4 border-l-red-600 text-gray-800 p-4 mb-8 rounded-lg shadow-sm flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i> 
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-red-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200 animate-fade-in-up" style="animation-delay: 0.2s;">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-500 font-bold">
                        <th class="px-6 py-5">Kode</th>
                        <th class="px-6 py-5">Brand & Model</th>
                        <th class="px-6 py-5">Harga Sewa</th>
                        <th class="px-6 py-5 text-center">Status</th>
                        <th class="px-6 py-5 text-center">Detail</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                
                @forelse($laptops as $laptop)
                <tbody x-data="{ open: false }" class="border-b border-gray-100 group hover:bg-gray-50/50 transition-colors duration-150">
                    
                    <tr class="table-row-hover bg-white transition-colors duration-200">
                        <td class="px-6 py-5 align-middle">
                            <span class="inline-block bg-white text-gray-600 text-xs px-2 py-1 rounded border border-gray-300 font-mono font-bold shadow-sm">
                                {{ $laptop->kode_laptop }}
                            </span>
                        </td>

                        <td class="px-6 py-5 align-middle">
                            <div class="flex flex-col">
                                <span class="text-black font-bold text-base">{{ $laptop->brand }}</span>
                                <span class="text-gray-500 text-sm">{{ $laptop->model }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-5 align-middle">
                            <span class="text-black font-extrabold text-sm">Rp {{ number_format($laptop->harga_sewa, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-xs font-medium">/bulan</span>
                        </td>

                        <td class="px-6 py-5 align-middle text-center">
                            @php
                                $statusStyle = match($laptop->status) {
                                    'available' => 'bg-white text-black border border-gray-300 shadow-sm',
                                    'disewa' => 'bg-black text-white border border-black shadow-md',
                                    'tidak disewakan' => 'bg-gray-100 text-gray-400 border border-gray-200 decoration-slice',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                                
                                $dotIndicator = $laptop->status == 'available' ? '<span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse mr-2"></span>' : '';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $statusStyle }}">
                                {!! $dotIndicator !!}
                                {{ ucfirst($laptop->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-5 align-middle text-center">
                            <button @click="open = !open" 
                                    class="group inline-flex items-center justify-center px-3 py-1.5 rounded-full border border-gray-200 hover:border-black bg-white hover:bg-gray-50 transition-all duration-300 focus:outline-none shadow-sm">
                                    
                                <span class="text-xs font-semibold text-gray-500 group-hover:text-black mr-2 transition-colors duration-300"
                                    x-text="open ? 'Tutup' : 'Lihat'"></span>

                                <i class="fa-solid fa-chevron-down text-xs text-gray-400 group-hover:text-black transition-transform duration-500"
                                :class="{'rotate-180': open}"></i>
                            </button>
                        </td>

                        <td class="px-6 py-5 align-middle text-center">
                            <div class="flex justify-center items-center space-x-3">
                                @if($laptop->status == 'disewa')
                                    <button type="button" class="text-gray-300 cursor-not-allowed" title="Sedang disewa (Tidak bisa diedit)">
                                        <i class="fa-solid fa-pen-to-square text-lg"></i>
                                    </button>
                                @else
                                    <a href="{{ route('laptop.edit', $laptop->id_laptop) }}" class="text-gray-400 hover:text-black hover:scale-110 transition-transform duration-200" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-lg"></i>
                                    </a>
                                @endif
                                
                                <form action="{{ route('laptop.destroy', $laptop->id_laptop) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 hover:scale-110 transition-transform duration-200" title="Hapus">
                                        <i class="fa-solid fa-trash-can text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <tr x-show="open" 
                        class="bg-gray-50 shadow-inner border-t border-gray-200 relative">
                        <td colspan="6" class="p-0">
                            <div class="overflow-hidden"
                                 x-show="open"
                                 x-transition:enter="transition-all ease-out duration-500"
                                 x-transition:enter-start="max-h-0 opacity-0 translate-y-[-10px]"
                                 x-transition:enter-end="max-h-96 opacity-100 translate-y-0"
                                 x-transition:leave="transition-all ease-in duration-300"
                                 x-transition:leave-start="max-h-96 opacity-100 translate-y-0"
                                 x-transition:leave-end="max-h-0 opacity-0 translate-y-[-10px]">
                                
                                <div class="p-6 flex items-start gap-6 pl-10">
                                    <div class="flex-shrink-0 mt-1"
                                         x-show="open"
                                         x-transition:enter="transition-all ease-out duration-700 delay-100"
                                         x-transition:enter-start="opacity-0 scale-0 rotate-[-45deg]"
                                         x-transition:enter-end="opacity-100 scale-100 rotate-0">
                                        <div class="w-12 h-12 rounded-xl bg-black flex items-center justify-center text-white shadow-lg">
                                            <i class="fa-solid fa-microchip text-xl"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="flex-grow"
                                         x-show="open"
                                         x-transition:enter="transition-all ease-out duration-500 delay-200"
                                         x-transition:enter-start="opacity-0 translate-x-4"
                                         x-transition:enter-end="opacity-100 translate-x-0">
                                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Spesifikasi Teknis</h4>
                                        <p class="text-gray-800 text-sm leading-relaxed bg-white p-4 rounded-lg border border-gray-200 shadow-sm max-w-3xl">
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
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400 bg-white">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-200"></i>
                                <p class="font-medium text-gray-500">Belum ada data laptop.</p>
                                <p class="text-xs mt-1 text-gray-400">Silakan tambahkan unit baru.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
                @endforelse
            </table>
        </div>
        
        <div class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Meine Laptop System.
        </div>

    </div>

</body>
</html>