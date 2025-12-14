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
        Schema::create('laptops', function (Blueprint $table) {
            // Primary Key: id_laptop
            $table->id('id_laptop');

            // Unique Key: kode_laptop
            $table->string('kode_laptop', 30)->unique();

            $table->string('brand', 30);
            $table->string('model', 30);
            $table->text('spesifikasi');
            $table->bigInteger('harga_sewa');

            // Enum sesuai SQL dump, nullable karena default null
            $table->enum('status', ['available', 'disewa', 'tidak disewakan'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
