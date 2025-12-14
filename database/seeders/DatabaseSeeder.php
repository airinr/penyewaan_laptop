<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LaptopSeeder::class,    // Master
            PenyewaSeeder::class,   // Master
            PenyewaanSeeder::class, // Transaksi (punya FK ke Laptop & Penyewa)
        ]);
    }
}