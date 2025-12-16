<?php

namespace App\Http\Controllers;

use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index()
    {
        $laptops = Laptop::orderBy('kode_laptop', 'asc')->get();
        return view('laptop.index', compact('laptops'));
    }

    public function create()
    {
        return view('laptop.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_laptop' => 'required|unique:laptops,kode_laptop',
            'brand'       => 'required',
            'model'       => 'required',
            'harga_sewa'  => 'required|numeric',
            'status'      => 'required',
            'spesifikasi' => 'required',
        ]);

        Laptop::create([
            'kode_laptop' => $request->kode_laptop,
            'brand'       => $request->brand,
            'model'       => $request->model,
            'harga_sewa'  => $request->harga_sewa,
            'status'      => $request->status,
            'spesifikasi' => $request->spesifikasi,
        ]);

        return redirect()->route('laptop.index')
            ->with('success', 'Laptop baru berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $laptop = Laptop::findOrFail($id);
        
        return view('laptop.edit', compact('laptop'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_laptop' => 'required|unique:laptops,kode_laptop,'.$id.',id_laptop',
            'brand'       => 'required',
            'model'       => 'required',
            'harga_sewa'  => 'required|numeric',
            'status'      => 'required',
            'spesifikasi' => 'required',
        ]);

        $laptop = Laptop::findOrFail($id);

        if ($laptop->status == 'disewa') {
            return redirect()->route('laptop.index')
                ->with('error', 'Gagal! Laptop sedang disewa tidak bisa diedit');
        }
        
        $laptop->update([
            'kode_laptop' => $request->kode_laptop,
            'brand'       => $request->brand,
            'model'       => $request->model,
            'harga_sewa'  => $request->harga_sewa,
            'status'      => $request->status,
            'spesifikasi' => $request->spesifikasi,
        ]);

        return redirect()->route('laptop.index')->with('success', 'Data laptop berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $laptop = Laptop::findOrFail($id);

        if ($laptop->status == 'disewa') {
            return redirect()->route('laptop.index')
                ->with('error', 'Gagal! Laptop sedang disewa tidak bisa dihapus');
        }

        $laptop->delete();

        return redirect()->route('laptop.index')
            ->with('success', 'Data laptop berhasil dihapus');
    }
}
