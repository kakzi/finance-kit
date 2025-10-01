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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('office_id');
            $table->date('tanggal_order');
            $table->date('tanggal_kirim');
            $table->string('nomor_faktur')->nullable();
            $table->string('number_transaction');
            $table->enum('method_payment', ['cash', 'credit', 'penitipan']);
            $table->bigInteger('total_perkiraan');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
