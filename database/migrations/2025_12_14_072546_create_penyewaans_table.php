<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyewaans', function (Blueprint $table) {
            // Primary Key: id_sewa
            $table->id('id_sewa');

            // Unique Key: kode_sewa
            $table->string('kode_sewa', 30)->unique();

            // Foreign Keys Columns (Harus unsignedBigInteger agar cocok dengan id() laravel)
            $table->foreignId('id_penyewa')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_laptop')->constrained()->onDelete('restrict')->onUpdate('cascade');

            // Date Columns
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->date('tgl_dikembalikan')->nullable(); // Boleh NULL

            // Status & Harga
            $table->string('status', 20); // Bisa diganti enum jika mau strict
            $table->bigInteger('harga');
            $table->bigInteger('denda')->nullable(); // Boleh NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaan');
    }
};