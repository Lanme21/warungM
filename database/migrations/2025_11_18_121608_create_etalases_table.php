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
        Schema::create('etalases', function (Blueprint $table) {
            $table->id();
            $table->string('barang_kode')->unique()->foreign()->references('kode')->on('barangs')->onDelete('cascade');
            $table->integer('harga_lama')->nullable(true);
            $table->integer('harga_baru')->nullable(true);
            $table->integer('harga_jual')->nullable(true);
            $table->integer('stok')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etalases');
    }
};
