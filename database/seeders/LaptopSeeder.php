<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaptopSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('laptops')->insert([
            [
                'id_laptop' => 1,
                'kode_laptop' => 'LPT-0001',
                'brand' => 'ASUS',
                'model' => 'VivoBook 14',
                'spesifikasi' => 'spesifikasi: Intel i5-1135G7, RAM 8GB, SSD 512GB, Layar 14", Intel Iris Xe',
                'harga_sewa' => 100000,
                'status' => 'available'
            ],
            [
                'id_laptop' => 2,
                'kode_laptop' => 'LPT-0002',
                'brand' => 'Lenovo',
                'model' => 'ThinkPad E14',
                'spesifikasi' => 'spesifikasi: Intel i5-1240P, RAM 16GB, SSD 512GB, Layar 14", WiFi 6',
                'harga_sewa' => 120000,
                'status' => 'disewa'
            ],
            [
                'id_laptop' => 3,
                'kode_laptop' => 'LPT-0003',
                'brand' => 'Acer',
                'model' => 'Aspire 5',
                'spesifikasi' => 'spesifikasi: AMD Ryzen 5 5500U, RAM 8GB, SSD 256GB, Layar 15.6"',
                'harga_sewa' => 90000,
                'status' => 'disewa'
            ],
            [
                'id_laptop' => 4,
                'kode_laptop' => 'LPT-0004',
                'brand' => 'HP',
                'model' => 'Pavilion 14',
                'spesifikasi' => 'spesifikasi: Intel i7-1165G7, RAM 16GB, SSD 512GB, Layar 14"',
                'harga_sewa' => 120000,
                'status' => 'available'
            ],
            [
                'id_laptop' => 5,
                'kode_laptop' => 'LPT-0005',
                'brand' => 'Dell',
                'model' => 'Inspiron 15',
                'spesifikasi' => 'spesifikasi: Intel i3-1115G4, RAM 8GB, SSD 256GB, Layar 15.6"',
                'harga_sewa' => 70000,
                'status' => 'available'
            ],
            [
                'id_laptop' => 6,
                'kode_laptop' => 'LPT-0006',
                'brand' => 'MSI',
                'model' => 'Modern 14',
                'spesifikasi' => 'spesifikasi: Intel i5-1155G7, RAM 16GB, SSD 512GB, Layar 14"',
                'harga_sewa' => 115000,
                'status' => 'available'
            ],
        ]);
    }
}