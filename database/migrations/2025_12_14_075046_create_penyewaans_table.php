<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan nama tabel di sini 'penyewaans' (jamak/plural)
        Schema::create('penyewaans', function (Blueprint $table) {
            
            // Primary Key
            $table->id('id_sewa'); 

            // Unique Key
            $table->string('kode_sewa', 30)->unique();

            // Kolom Foreign Key (Tipe data harus sama dengan id tabel induk)
            $table->unsignedBigInteger('id_penyewa');
            $table->unsignedBigInteger('id_laptop');

            // Data Tanggal
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->date('tgl_dikembalikan')->nullable();

            // Status & Harga
            $table->string('status', 20);
            $table->bigInteger('harga');
            $table->bigInteger('denda')->nullable();

            // --- BAGIAN INI YANG MEMPERBAIKI ERROR 150 ---
            
            // 1. Relasi ke tabel PENYEWAS (Plural)
            $table->foreign('id_penyewa')
                  ->references('id_penyewa')  // Kolom PK di tabel penyewas
                  ->on('penyewas')            // Nama tabel tujuan (HARUS SAMA persis dengan migration kamu)
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // 2. Relasi ke tabel LAPTOPS (Plural)
            $table->foreign('id_laptop')
                  ->references('id_laptop')   // Kolom PK di tabel laptops
                  ->on('laptops')             // Nama tabel tujuan (HARUS SAMA persis dengan migration kamu)
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyewaans');
    }
};