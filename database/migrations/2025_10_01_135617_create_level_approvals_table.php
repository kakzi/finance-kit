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
        Schema::create('level_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('kategori'); // contoh: Keuangan, Pembelian, Persediaan
            $table->string('jenis_transaksi'); // contoh: Pesanan, Penerimaan Barang, Mutasi Barang, dll
            $table->string('level'); // L1, L2
            $table->unsignedBigInteger('role_id'); // relasi ke role
            $table->bigInteger('limit_amount'); // contoh < 10.000.000, < 50.000.000
            $table->timestamps();
            // foreign key ke users
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_approvals');
    }
};
