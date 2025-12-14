<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyewaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penyewas')->insert([
            [
                'id_penyewa' => 1,
                'nama' => 'Andi Pratama',
                'telp' => '0812000111',
                'email' => 'andi@mail.com',
                'alamat' => 'Jln. Melati No.12, RT 03/RW 05, Kec. Coblong, Kel. Dago, Kota Bandung, Jawa Barat'
            ],
            [
                'id_penyewa' => 2,
                'nama' => 'Budi Santoso',
                'telp' => '0812000222',
                'email' => 'budi@mail.com',
                'alamat' => 'Jln. Kenanga No.7, RT 02/RW 01, Kec. Sukajadi, Kel. Pasteur, Kota Bandung, Jawa Barat'
            ],
            [
                'id_penyewa' => 3,
                'nama' => 'Citra Lestari',
                'telp' => '0812000333',
                'email' => 'citra@mail.com',
                'alamat' => 'Jln. Anggrek No.9, RT 01/RW 04, Kec. Cicendo, Kel. Pajajaran, Kota Bandung, Jawa Barat'
            ],
            [
                'id_penyewa' => 4,
                'nama' => 'Dewi Kartika',
                'telp' => '0812000444',
                'email' => 'dewi@mail.com',
                'alamat' => 'Jln. Teratai No.15, RT 05/RW 02, Kec. Antapani, Kel. Antapani Kidul, Kota Bandung, Jawa Barat'
            ],
            [
                'id_penyewa' => 5,
                'nama' => 'Eko Nugroho',
                'telp' => '0812000555',
                'email' => 'eko@mail.com',
                'alamat' => 'Jln. Dahlia No.21, RT 04/RW 03, Kec. Buahbatu, Kel. Kujangsari, Kota Bandung, Jawa Barat'
            ],
            [
                'id_penyewa' => 6,
                'nama' => 'Fajar Hidayat',
                'telp' => '0812000666',
                'email' => 'fajar@mail.com',
                'alamat' => 'Jln. Flamboyan No.3, RT 06/RW 06, Kec. Cibeunying Kidul, Kel. Sukamaju, Kota Bandung, Jawa Barat'
            ],
            [
                'id_penyewa' => 7,
                'nama' => 'Gita Permata',
                'telp' => '0812000777',
                'email' => 'gita@mail.com',
                'alamat' => 'Jln. Bougenville No.18, RT 07/RW 07, Kec. Astanaanyar, Kel. Karanganyar, Kota Bandung, Jawa Barat'
            ],
        ]);
    }
}