<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\Penyewa;
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
        // Ambil data untuk dropdown
        $penyewas = Penyewa::all();
        // Filter laptop: Cuma yang statusnya 'available'
        $laptops = Laptop::where('status', 'available')->get();

        return view('penyewaan.buatPenyewaan', compact('penyewas', 'laptops'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'tipe_penyewa' => 'required|in:lama,baru',
            'id_laptop'    => 'required|exists:laptops,id_laptop',
            'tgl_mulai'    => 'required|date',
            'tgl_selesai'  => 'required|date|after:tgl_mulai', // Harus setelah tgl mulai
        ]);

        return DB::transaction(function () use ($request) {
            
            $idPenyewa = null;

            // Logic Switch Penyewa (Tetap Sama)
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

            // Kode Sewa Otomatis
            $today = date('ymd');
            $prefix = 'SEWA-' . $today . '-';
            $lastSewa = Penyewaan::where('kode_sewa', 'like', $prefix . '%')->orderBy('id_sewa', 'desc')->first();
            $newNumber = $lastSewa ? ((int) substr($lastSewa->kode_sewa, -3) + 1) : 1;
            $kodeSewaBaru = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            
            // --- LOGIC BARU: HITUNG HARGA BULANAN ---
            
            // 1. Ambil data laptop
            $laptop = Laptop::findOrFail($request->id_laptop);
            
            // 2. Hitung Durasi dalam BULAN
            $start = Carbon::parse($request->tgl_mulai);
            $end = Carbon::parse($request->tgl_selesai);
            
            // floatDiffInMonths: Menghitung selisih bulan (bisa desimal, misal 1.2 bulan)
            // ceil: Membulatkan ke atas (1.2 jadi 2) agar penyewa bayar full bulan berjalan
            $durasiBulan = ceil($start->floatDiffInMonths($end));

            // Minimal durasi 1 bulan
            if ($durasiBulan < 1) $durasiBulan = 1;

            // 3. Kalikan (Harga Bulan x Durasi Bulan)
            $totalHarga = $durasiBulan * $laptop->harga_sewa;

            // Simpan Transaksi
            Penyewaan::create([
                // ... (field kode_sewa, id_penyewa sama) ...
                'kode_sewa'   => $kodeSewaBaru, // Pastikan variabel ini ada dari logic atas
                'id_penyewa'  => $idPenyewa,    // Pastikan variabel ini ada dari logic atas
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
        
        // 1. Tanggal Hari Ini (Saat dikembalikan)
        $tglDikembalikan = Carbon::now();
        // $tglDikembalikan = Carbon::parse('2025-12-20'); // Uncomment buat ngetes tanggal telat manual
        
        $tglDeadline = Carbon::parse($sewa->tgl_selesai);
        $tglMulai = Carbon::parse($sewa->tgl_mulai);

        // 2. Hitung Harga Sewa Dasar (Durasi Pakai x Harga Laptop)
        // Hitung durasi real pemakaian (dari mulai sampai dikembalikan)
        $durasiPakai = $tglMulai->diffInDays($tglDikembalikan);
        if ($durasiPakai < 1) $durasiPakai = 1; // Minimal bayar 1 hari
        $totalHargaSewa = $durasiPakai * $sewa->laptop->harga_sewa;

        // 3. RUMUS DENDA (Deadline vs Dikembalikan)
        // Parameter false agar bisa return nilai negatif/positif
        $selisihHari = $tglDeadline->diffInDays($tglDikembalikan, false); 
        
        $denda = 0;
        if ($selisihHari > 0) {
            // Kalau selisih positif, berarti TELAT
            $denda = $selisihHari * 50000;
        }

        // 4. Update Database
        DB::transaction(function() use ($sewa, $tglDikembalikan, $totalHargaSewa, $denda) {
            $sewa->update([
                'tgl_dikembalikan' => $tglDikembalikan,
                'status'           => 'selesai',
                'harga'            => $totalHargaSewa, // Harga sewa murni
                'denda'            => $denda // Denda keterlambatan
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