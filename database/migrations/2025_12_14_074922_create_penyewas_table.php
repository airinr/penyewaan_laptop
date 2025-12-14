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
        Schema::create('penyewas', function (Blueprint $table) {
            // Primary Key: id_penyewa
            $table->id('id_penyewa');

            $table->string('nama', 70);

            // Unique Key: telp & email
            $table->string('telp', 12)->unique();
            $table->string('email', 50)->unique();

            $table->string('alamat', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewas');
    }
};
