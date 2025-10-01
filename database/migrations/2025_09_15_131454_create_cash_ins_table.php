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
        Schema::create('cash_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('category_id');
            $table->date('tanggal');
            $table->string('nomor_faktur')->nullable();
            $table->decimal('total_sebelum_potongan', 15, 2)->nullable();
            $table->decimal('total_potongan', 15, 2)->nullable();
            $table->decimal('dibayarkan', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_ins');
    }
};
