<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penyewaan</title>
    
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
 <x-navbar />
    <div class="container mx-auto px-4 py-10">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 animate-fade-in-up">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fa-solid fa-laptop-code text-indigo-600"></i>
                    Rental Laptop System
                </h1>
                <p class="text-gray-500 text-sm mt-1 ml-10">Kelola peminjaman dengan mudah dan cepat.</p>
            </div>
            
            <a href="{{ route('penyewaan.create') }}" class="group bg-indigo-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-indigo-700 transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2">
                <i class="fa-solid fa-plus transition-transform group-hover:rotate-180"></i>
                <span>Sewa Baru</span>
            </a>
        </div>

        @if(session('success'))
            <div class="animate-fade-in-up bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr class="bg-indigo-50 text-indigo-900 uppercase text-xs font-bold tracking-wider">
                            <th class="px-6 py-4 text-left"><i class="fa-solid fa-hashtag mr-1"></i> Kode</th>
                            <th class="px-6 py-4 text-left"><i class="fa-solid fa-users mr-1"></i> Penyewa & Unit</th>
                            <th class="px-6 py-4 text-center"><i class="fa-regular fa-clock mr-1"></i> Jadwal & Status</th>
                            <th class="px-6 py-4 text-right"><i class="fa-solid fa-money-bill-wave mr-1"></i> Tagihan</th>
                            <th class="px-6 py-4 text-right text-red-600"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Denda</th>
                            <th class="px-6 py-4 text-center"><i class="fa-solid fa-sliders mr-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                        @forelse($penyewaans as $sewa)
                        <tr class="table-row-hover bg-white transition-colors duration-200">
                            
                            <td class="px-6 py-5">
                                <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">
                                    {{ $sewa->kode_sewa }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-start gap-3">
                                    <div class="mt-1 text-gray-400"><i class="fa-solid fa-user-circle fa-lg"></i></div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $sewa->penyewa->nama }}</div>
                                        <div class="text-xs text-gray-500 mb-1">{{ $sewa->penyewa->telp }}</div>
                                        <div class="inline-flex items-center gap-1 bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs border border-gray-200">
                                            <i class="fa-solid fa-laptop text-gray-400"></i>
                                            {{ $sewa->laptop->brand }} {{ $sewa->laptop->model }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <div class="text-xs text-gray-500">
                                    <i class="fa-solid fa-calendar-plus text-green-500 mr-1"></i> {{ \Carbon\Carbon::parse($sewa->tgl_mulai)->format('d M') }}
                                </div>
                                <div class="text-xs font-bold text-blue-600 mt-1">
                                    <i class="fa-solid fa-flag-checkered mr-1"></i> Deadline: {{ \Carbon\Carbon::parse($sewa->tgl_selesai)->format('d M') }}
                                </div>
                                
                                <div class="mt-2">
                                    @if($sewa->status == 'ongoing')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 font-semibold text-yellow-700 bg-yellow-100 rounded-full text-xs animate-pulse">
                                            <i class="fa-solid fa-hourglass-half"></i> Sedang Sewa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 font-semibold text-green-700 bg-green-100 rounded-full text-xs">
                                            <i class="fa-solid fa-check-double"></i> Selesai
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-5 text-right font-mono font-bold text-indigo-700">
                                @if($sewa->harga)
                                    Rp {{ number_format($sewa->harga, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400 italic text-xs font-normal opacity-50">Menunggu..</span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-right">
                                @if($sewa->denda !== null)
                                    @if($sewa->denda > 0)
                                        <span class="inline-flex items-center gap-1 text-red-600 font-bold bg-red-50 px-2 py-1 rounded text-xs border border-red-200">
                                            <i class="fa-solid fa-fire"></i> Rp {{ number_format($sewa->denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-green-600 font-bold text-xs"><i class="fa-solid fa-thumbs-up"></i> Aman</span>
                                    @endif
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-center">
                                @if($sewa->status == 'ongoing')
                                    <form action="{{ route('penyewaan.kembali', $sewa->id_sewa) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian laptop? Total harga & denda akan dihitung otomatis.')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-md transition-all transform hover:scale-105 flex items-center gap-2 mx-auto">
                                            <i class="fa-solid fa-rotate-left"></i> Kembalikan
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="cursor-not-allowed opacity-50 bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded-lg text-xs flex items-center gap-2 mx-auto">
                                        <i class="fa-solid fa-file-circle-check"></i> Done
                                    </button>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                    <p>Belum ada data penyewaan saat ini.</p>
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