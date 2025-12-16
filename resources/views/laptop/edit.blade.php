<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laptop - Meine Laptop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                    Edit Laptop
                </h1>
                <p class="text-gray-500 text-sm mt-2 ml-1">
                    Update laptop details.
                </p>
            </div>

            <a href="{{ route('laptop.index') }}"
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
                
                <form action="{{ route('laptop.update', $laptop->id_laptop) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kode Laptop</label>
                            <input type="text" name="kode_laptop" value="{{ old('kode_laptop', $laptop->kode_laptop) }}"
                                class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-black focus:border-black focus:outline-none transition-all placeholder-gray-400 bg-gray-50 focus:bg-white"
                                placeholder="Contoh: LPT-001" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $laptop->brand) }}"
                                class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-black focus:border-black focus:outline-none transition-all placeholder-gray-400 bg-gray-50 focus:bg-white"
                                placeholder="Asus, Lenovo, dll" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Model / Tipe</label>
                            <input type="text" name="model" value="{{ old('model', $laptop->model) }}"
                                class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-black focus:border-black focus:outline-none transition-all placeholder-gray-400 bg-gray-50 focus:bg-white"
                                placeholder="ThinkPad X1 Carbon" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga Sewa (Per Hari)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold text-sm">Rp</span>
                                <input type="number" name="harga_sewa" value="{{ old('harga_sewa', $laptop->harga_sewa) }}"
                                    class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black focus:border-black focus:outline-none transition-all placeholder-gray-400 bg-gray-50 focus:bg-white"
                                    placeholder="0" required>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Status Ketersediaan</label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black focus:border-black focus:outline-none transition-all bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                    <option value="available" {{ old('status', $laptop->status) == 'available' ? 'selected' : '' }}>Available (Bisa Disewa)</option>
                                    <option value="disewa" {{ old('status', $laptop->status) == 'disewa' ? 'selected' : '' }}>Disewa (Sedang Dipakai)</option>
                                    <option value="tidak disewakan" {{ old('status', $laptop->status) == 'tidak disewakan' ? 'selected' : '' }}>Tidak Disewakan (Rusak/Maintenance)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 ml-1">
                                <i class="fa-solid fa-circle-info mr-1"></i> Please be careful when changing status if unit is currently rented.
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Spesifikasi Lengkap</label>
                            <textarea name="spesifikasi" rows="4" 
                                class="w-full border border-gray-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-black focus:border-black focus:outline-none transition-all placeholder-gray-400 bg-gray-50 focus:bg-white"
                                placeholder="Processor, RAM, Storage, dll..." required>{{ old('spesifikasi', $laptop->spesifikasi) }}</textarea>
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100 mt-8">
                        <a href="{{ route('laptop.index') }}" 
                           class="px-6 py-3 rounded-xl text-gray-600 hover:text-black hover:bg-gray-100 font-semibold transition text-sm">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2 text-sm">
                            <i class="fa-solid fa-floppy-disk"></i> Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

</body>
</html>