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
        Schema::create('mutasi_barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_from_id');
            $table->unsignedBigInteger('office_to_id');
            $table->unsignedBigInteger('transportasi_id');
            $table->date('tanggal_mutasi');
            $table->date('tanggal_kirim');
            $table->string('nomor_faktur');
            $table->bigInteger('total_mutasi');
            $table->string('checker');
            $table->string('driver_helper');
            $table->string('recipient');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_barangs');
    }
};
