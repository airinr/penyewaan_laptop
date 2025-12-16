<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\penyewa;
use App\Models\Laptop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyewaanController extends Controller
{
    public function index()
    {
        $penyewaans = Penyewaan::with(['penyewa', 'laptop'])->latest('id_sewa')->get();
        return view('penyewaan.index', compact('penyewaans'));
    }

    public function create()
    {
        $penyewas = Penyewa::all();
        $laptops = Laptop::where('status', 'available')->get();

        return view('penyewaan.buatPenyewaan', compact('penyewas', 'laptops'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_penyewa' => 'required|in:lama,baru',
            'id_laptop'    => 'required|exists:laptops,id_laptop',
            'tgl_mulai'    => 'required|date',
            'tgl_selesai'  => 'required|date|after:tgl_mulai',
        ]);

        return DB::transaction(function () use ($request) {
            
            $idPenyewa = null;

            if ($request->tipe_penyewa == 'baru') {
                $request->validate([
                    'nama_baru'   => 'required|string|max:70',
                    'telp_baru'   => 'required|numeric|unique:penyewas,telp',
                    'email_baru'  => 'required|email|unique:penyewas,email',
                    'alamat_baru' => 'required|string',
                ]);
                $penyewaBaru = Penyewa::create([
                    'nama' => $request->nama_baru, 'telp' => $request->telp_baru, 
                    'email' => $request->email_baru, 'alamat' => $request->alamat_baru
                ]);
                $idPenyewa = $penyewaBaru->id_penyewa;
            } else {
                $request->validate(['id_penyewa_lama' => 'required|exists:penyewas,id_penyewa']);
                $idPenyewa = $request->id_penyewa_lama;
            }

            $today = date('ymd');
            $prefix = 'SEWA-' . $today . '-';
            $lastSewa = Penyewaan::where('kode_sewa', 'like', $prefix . '%')->orderBy('id_sewa', 'desc')->first();
            $newNumber = $lastSewa ? ((int) substr($lastSewa->kode_sewa, -3) + 1) : 1;
            $kodeSewaBaru = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            
            
            $laptop = Laptop::findOrFail($request->id_laptop);
            
            $start = Carbon::parse($request->tgl_mulai);
            $end = Carbon::parse($request->tgl_selesai);
            
            $durasiBulan = ceil($start->floatDiffInMonths($end));

            if ($durasiBulan < 1) $durasiBulan = 1;

            $totalHarga = $durasiBulan * $laptop->harga_sewa;

            Penyewaan::create([
                'kode_sewa'   => $kodeSewaBaru,
                'id_penyewa'  => $idPenyewa, 
                'id_laptop'   => $request->id_laptop,
                'tgl_mulai'   => $request->tgl_mulai,
                'tgl_selesai' => $request->tgl_selesai,
                'status'      => 'ongoing',
                'harga'       => $totalHarga, 
                'denda'       => null,
            ]);

            Laptop::where('id_laptop', $request->id_laptop)->update(['status' => 'disewa']);

            return redirect()->route('penyewaan')->with('success', 'Sewa Bulanan Berhasil! Durasi: ' . $durasiBulan . ' Bulan. Total: Rp ' . number_format($totalHarga));
        });
    }
    
    public function kembali($id)
    {
        $sewa = Penyewaan::with('laptop')->findOrFail($id);
        
        $tglDikembalikan = Carbon::now();
        
        $tglDeadline = Carbon::parse($sewa->tgl_selesai);
        $tglMulai = Carbon::parse($sewa->tgl_mulai);

        $durasiPakai = $tglMulai->diffInDays($tglDikembalikan);
        if ($durasiPakai < 1) $durasiPakai = 1; 
        $totalHargaSewa = $durasiPakai * $sewa->laptop->harga_sewa;

        $selisihHari = $tglDeadline->diffInDays($tglDikembalikan, false); 
        
        $denda = 0;
        if ($selisihHari > 0) {
            $denda = $selisihHari * 50000;
        }

        DB::transaction(function() use ($sewa, $tglDikembalikan, $totalHargaSewa, $denda) {
            $sewa->update([
                'tgl_dikembalikan' => $tglDikembalikan,
                'status'           => 'selesai',
                'harga'            => $totalHargaSewa, 
                'denda'            => $denda 
            ]);

            $sewa->laptop->update(['status' => 'available']);
        });

        $pesan = "Laptop dikembalikan. Biaya Sewa: Rp " . number_format($totalHargaSewa);
        if ($denda > 0) {
            $pesan .= " + DENDA TELAT: Rp " . number_format($denda);
        }

        return redirect()->back()->with('success', $pesan);
    }
}