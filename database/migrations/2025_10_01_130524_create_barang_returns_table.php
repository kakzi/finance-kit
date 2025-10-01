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
        Schema::create('barang_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_from_id');
            $table->unsignedBigInteger('office_to_id');
            $table->string('nama_barang');
            $table->date('tanggal_kirim');
            $table->bigInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_returns');
    }
};
