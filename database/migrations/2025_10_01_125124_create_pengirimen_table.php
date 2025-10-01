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
        Schema::create('pengirimen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_to_id');
            $table->unsignedBigInteger('transportasi_id');
            $table->date('tanggal_kirim');
            $table->string('nomor_faktur');
            $table->bigInteger('total');
            $table->string('driver_helper');
            $table->string('km_awal');
            $table->string('km_akhir');
            $table->boolean('bbm')->default(false);
            $table->string('dokumentasi');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimen');
    }
};
