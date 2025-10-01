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
        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->string('module'); // contoh: 'order', 'mutasi_barang', 'stok_opname'
            $table->unsignedBigInteger('module_id'); // id transaksi terkait
            $table->decimal('amount', 20, 2);
            $table->unsignedBigInteger('requested_by'); // user pembuat transaksi
            $table->unsignedBigInteger('approval_by')->nullable(); // user approver sesuai level
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_requests');
    }
};
