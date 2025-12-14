<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyewaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penyewaan')->insert([
            [
                'id_sewa' => 1,
                'kode_sewa' => 'SEWA-2025-001',
                'id_penyewa' => 1,
                'id_laptop' => 1,
                'tgl_mulai' => '2025-09-01',
                'tgl_selesai' => '2025-09-05',
                'tgl_dikembalikan' => '2025-09-05',
                'status' => 'selesai',
                'harga' => 450000,
                'denda' => 0
            ],
            [
                'id_sewa' => 2,
                'kode_sewa' => 'SEWA-2025-002',
                'id_penyewa' => 2,
                'id_laptop' => 2,
                'tgl_mulai' => '2025-09-10',
                'tgl_selesai' => '2025-09-12',
                'tgl_dikembalikan' => '2025-09-15',
                'status' => 'selesai',
                'harga' => 330000,
                'denda' => 150000
            ],
            [
                'id_sewa' => 3,
                'kode_sewa' => 'SEWA-2025-003',
                'id_penyewa' => 3,
                'id_laptop' => 3,
                'tgl_mulai' => '2025-10-25',
                'tgl_selesai' => '2025-10-30',
                'tgl_dikembalikan' => null, // NULL di SQL
                'status' => 'ongoing',
                'harga' => 510000,
                'denda' => null // NULL di SQL
            ],
            [
                'id_sewa' => 4,
                'kode_sewa' => 'SEWA-2025-004',
                'id_penyewa' => 4,
                'id_laptop' => 4,
                'tgl_mulai' => '2025-10-15',
                'tgl_selesai' => '2025-10-18',
                'tgl_dikembalikan' => null,
                'status' => 'ongoing',
                'harga' => 480000,
                'denda' => null
            ],
            [
                'id_sewa' => 5,
                'kode_sewa' => 'SEWA-2025-005',
                'id_penyewa' => 5,
                'id_laptop' => 5,
                'tgl_mulai' => '2025-08-01',
                'tgl_selesai' => '2025-08-03',
                'tgl_dikembalikan' => '2025-08-04',
                'status' => 'selesai',
                'harga' => 210000,
                'denda' => 50000
            ],
            [
                'id_sewa' => 6,
                'kode_sewa' => 'SEWA-2025-006',
                'id_penyewa' => 6,
                'id_laptop' => 6,
                'tgl_mulai' => '2025-07-10',
                'tgl_selesai' => '2025-07-12',
                'tgl_dikembalikan' => '2025-07-12',
                'status' => 'selesai',
                'harga' => 345000,
                'denda' => 0
            ],
            [
                'id_sewa' => 7,
                'kode_sewa' => 'SEWA-2025-007',
                'id_penyewa' => 7,
                'id_laptop' => 1,
                'tgl_mulai' => '2025-09-20',
                'tgl_selesai' => '2025-09-22',
                'tgl_dikembalikan' => '2025-09-22',
                'status' => 'selesai',
                'harga' => 270000,
                'denda' => 0
            ],
        ]);
    }
}