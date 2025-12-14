<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laptop - {{ $laptop->brand }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <div class="container mx-auto px-4 py-10 max-w-3xl">

        <a href="{{ route('laptop.index') }}" class="inline-flex items-center text-gray-500 hover:text-indigo-600 mb-6 transition-colors duration-200">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>

        <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100">
            
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Data Laptop</h1>
                    <p class="text-sm text-gray-500 mt-1">Update informasi spesifikasi atau status laptop.</p>
                </div>
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-lg">
                    <i class="fa-solid fa-pen-to-square text-xl"></i>
                </div>
            </div>

            <form action="{{ route('laptop.update', $laptop->id_laptop) }}" method="POST" class="px-8 py-8 space-y-6">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kode Laptop</label>
                        <input type="text" name="kode_laptop" value="{{ old('kode_laptop', $laptop->kode_laptop) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Contoh: LPT-001" required>
                        @error('kode_laptop') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand', $laptop->brand) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Asus, Lenovo, dll" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Model / Tipe</label>
                        <input type="text" name="model" value="{{ old('model', $laptop->model) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="ThinkPad X1 Carbon" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga Sewa (Per Hari)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">Rp</span>
                            <input type="number" name="harga_sewa" value="{{ old('harga_sewa', $laptop->harga_sewa) }}"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="0" required>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Ketersediaan</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors bg-white">
                            <option value="available" {{ old('status', $laptop->status) == 'available' ? 'selected' : '' }}>Available (Bisa Disewa)</option>
                            <option value="disewa" {{ old('status', $laptop->status) == 'disewa' ? 'selected' : '' }}>Disewa (Sedang Dipakai)</option>
                            <option value="tidak disewakan" {{ old('status', $laptop->status) == 'tidak disewakan' ? 'selected' : '' }}>Tidak Disewakan (Rusak/Maintenance)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">*Hati-hati mengubah status jika laptop sedang disewa user.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Spesifikasi Lengkap</label>
                        <textarea name="spesifikasi" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            placeholder="Processor, RAM, Storage, dll..." required>{{ old('spesifikasi', $laptop->spesifikasi) }}</textarea>
                    </div>

                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('laptop.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-medium shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-regular fa-floppy-disk mr-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>