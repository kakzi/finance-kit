<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LevelApproval;

class LevelApprovalSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ================= KEUANGAN =================
            ['kategori' => 'Keuangan', 'jenis_transaksi' => '-', 'level' => 'L1', 'limit_amount' => 10000000],
            ['kategori' => 'Keuangan', 'jenis_transaksi' => '-', 'level' => 'L2', 'limit_amount' => 50000000],
            ['kategori' => 'Keuangan', 'jenis_transaksi' => '-', 'level' => 'L3', 'limit_amount' => 999999999],

            // ================= PEMBELIAN =================
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Pesanan (Order)', 'level' => 'L1', 'limit_amount' => 10000000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Pesanan (Order)', 'level' => 'L2', 'limit_amount' => 50000000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Pesanan (Order)', 'level' => 'L3', 'limit_amount' => 999999999],

            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Penerimaan Barang', 'level' => 'L1', 'limit_amount' => 10000000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Penerimaan Barang', 'level' => 'L2', 'limit_amount' => 50000000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Penerimaan Barang', 'level' => 'L3', 'limit_amount' => 999999999],

            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Faktur Pembelian', 'level' => 'L1', 'limit_amount' => 10000000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Faktur Pembelian', 'level' => 'L2', 'limit_amount' => 50000000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Faktur Pembelian', 'level' => 'L3', 'limit_amount' => 999999999],

            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Return Pembelian', 'level' => 'L1', 'limit_amount' => 500000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Return Pembelian', 'level' => 'L2', 'limit_amount' => 1000000],
            ['kategori' => 'Pembelian', 'jenis_transaksi' => 'Return Pembelian', 'level' => 'L3', 'limit_amount' => 3000000],

            // ================= PERSEDIAAN =================
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Pesanan Cabang', 'level' => 'L1', 'limit_amount' => 10000000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Pesanan Cabang', 'level' => 'L2', 'limit_amount' => 50000000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Pesanan Cabang', 'level' => 'L3', 'limit_amount' => 999999999],

            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Mutasi Barang', 'level' => 'L1', 'limit_amount' => 10000000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Mutasi Barang', 'level' => 'L2', 'limit_amount' => 50000000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Mutasi Barang', 'level' => 'L3', 'limit_amount' => 999999999],

            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Pengiriman', 'level' => 'L1', 'limit_amount' => 25000000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Pengiriman', 'level' => 'L2', 'limit_amount' => 50000000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Pengiriman', 'level' => 'L3', 'limit_amount' => 999999999],

            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Hasil Stok Opname', 'level' => 'L1', 'limit_amount' => 500000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Hasil Stok Opname', 'level' => 'L2', 'limit_amount' => 1000000],
            ['kategori' => 'Persediaan', 'jenis_transaksi' => 'Hasil Stok Opname', 'level' => 'L3', 'limit_amount' => 3000000],
        ];

        foreach ($data as $item) {
            LevelApproval::create([
                'kategori'        => $item['kategori'],
                'jenis_transaksi' => $item['jenis_transaksi'],
                'level'           => $item['level'],
                'role_id'         => 1, // default ke admin, bisa diubah nanti
                'limit_amount'    => $item['limit_amount'],
            ]);
        }
    }
}
