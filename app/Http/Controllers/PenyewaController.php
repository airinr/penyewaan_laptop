<?php

namespace App\Http\Controllers;

use App\Models\penyewa;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyewas = Penyewa::all();
        return view('penyewa.index', compact('penyewas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penyewa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'nama'   => ['required', 'string', 'max:100'],
            'telp'   => ['required', 'string', 'max:20'],
            'email'  => ['nullable', 'email', 'max:100'],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);

        Penyewa::create($validated);

        return redirect()->route('penyewa.index')->with('success', 'Penyewa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(penyewa $penyewa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(penyewa $penyewa)
    {
        return view('penyewa.edit', compact('penyewa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, penyewa $penyewa)
    {
            $validated = $request->validate([
            'nama'   => ['required','string','max:100'],
            'telp'   => ['required','string','max:20'],
            'email'  => ['nullable','email','max:100'],
            'alamat' => ['nullable','string','max:255'],
        ]);

        $penyewa->update($validated);

        return redirect()->route('penyewa.index')->with('success', 'Data penyewa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(penyewa $penyewa)
    {
        $penyewa->delete();

        return redirect()->route('penyewa.index')
            ->with('success', 'Data penyewa berhasil dihapus.');
    }
}
