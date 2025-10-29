<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'aset_barus',
            'aset_rusaks',
            'barang_barus',
            'barang_returns',
            'faktur_pembelians',
            'mutasi_barangs',
            'pemeliharaans',
            'penerimaan_barangs',
            'pengirimen',
            'pesanan_cabangs',
            'return_pembelians',
            'stock_opnames',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'status')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])
                            ->default('draft')
                            ->before('created_at');
                });
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'aset_barus',
            'aset_rusaks',
            'barang_barus',
            'barang_returns',
            'faktur_pembelians',
            'mutasi_barangs',
            'pemeliharaans',
            'penerimaan_barangs',
            'pengirimen',
            'pesanan_cabangs',
            'return_pembelians',
            'stock_opnames',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'status')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('status');
                });
            }
        }
    }
};
