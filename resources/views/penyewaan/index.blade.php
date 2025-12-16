<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyewaan - Meine Laptop</title>
    
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
            transition: all 0.2s ease;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">
 
    <x-navbar />

    <div class="container mx-auto px-4 py-10 max-w-7xl">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 animate-fade-in-up">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-extrabold text-black flex items-center gap-3 tracking-tight">
                    Rental Dashboard
                </h1>
                <p class="text-gray-500 text-sm mt-2 ml-1">Manage all transactions in one place.</p>
            </div>
            
            <a href="{{ route('penyewaan.create') }}" class="group bg-black text-white px-6 py-3 rounded-xl shadow-lg hover:bg-gray-800 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 font-medium text-sm">
                <i class="fa-solid fa-plus transition-transform group-hover:rotate-90"></i>
                <span>Sewa Baru</span>
            </a>
        </div>

        @if(session('success'))
            <div class="animate-fade-in-up bg-white border border-gray-200 border-l-4 border-l-black text-gray-800 p-4 rounded-lg shadow-sm mb-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-black"></i>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-black transition-colors"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-200 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs font-bold tracking-wider">
                            <th class="px-6 py-5 text-left">Kode</th>
                            <th class="px-6 py-5 text-left">Penyewa & Unit</th> <th class="px-6 py-5 text-center">Jadwal & Status</th>
                            <th class="px-6 py-5 text-right">Tagihan</th>
                            <th class="px-6 py-5 text-right">Denda</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                        @forelse($penyewaans as $sewa)
                        <tr class="table-row-hover bg-white transition-colors duration-200 group">
                            
                            <td class="px-6 py-5 align-middle">
                                <span class="font-mono font-bold text-xs text-gray-600 border border-gray-300 px-2 py-1 rounded">
                                    {{ $sewa->kode_sewa }}
                                </span>
                            </td>

                            <td class="px-6 py-5 align-middle">
                                <div class="flex flex-col">
                                    <span class="font-bold text-black text-base">{{ $sewa->penyewa->nama }}</span>
                                    <span class="text-xs text-gray-400 mb-1">{{ $sewa->penyewa->telp }}</span>
                                    
                                    <div class="inline-flex items-center gap-1 mt-1">
                                        <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-md text-xs font-medium border border-gray-200">
                                            {{ $sewa->laptop->brand }} {{ $sewa->laptop->model }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center align-middle">
                                <div class="flex flex-col items-center gap-1">
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($sewa->tgl_mulai)->format('d M') }} 
                                        <span class="text-gray-300 mx-1">&rarr;</span> 
                                        {{ \Carbon\Carbon::parse($sewa->tgl_selesai)->format('d M') }}
                                    </div>
                                    
                                    <div class="mt-2">
                                        @if($sewa->status == 'ongoing')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 font-bold text-gray-800 bg-white border border-gray-300 rounded-full text-xs shadow-sm">
                                                <span class="w-2 h-2 rounded-full bg-black animate-pulse"></span>
                                                Sedang Sewa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 font-bold text-white bg-black rounded-full text-xs">
                                                <i class="fa-solid fa-check"></i> Selesai
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-right align-middle">
                                @if($sewa->harga)
                                    <span class="font-bold text-black text-sm">
                                        Rp {{ number_format($sewa->harga, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-right align-middle">
                                @if($sewa->denda !== null)
                                    @if($sewa->denda > 0)
                                        <span class="font-bold text-gray-900 border-b-2 border-gray-900 pb-0.5">
                                            Rp {{ number_format($sewa->denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs font-medium">Aman</span>
                                    @endif
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center align-middle">
                                @if($sewa->status == 'ongoing')
                                    <form action="{{ route('penyewaan.kembali', $sewa->id_sewa) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian laptop? Total harga & denda akan dihitung otomatis.')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-black hover:bg-gray-800 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-md transition-all transform hover:-translate-y-0.5 flex items-center gap-2 mx-auto">
                                            <i class="fa-solid fa-rotate-left"></i> Return
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs font-medium flex justify-center items-center gap-1">
                                        <i class="fa-solid fa-check-circle"></i> Closed
                                    </span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-400 bg-white">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-200"></i>
                                    <p class="font-medium">Belum ada data penyewaan.</p>
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