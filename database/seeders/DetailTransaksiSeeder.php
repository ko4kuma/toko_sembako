<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailTransaksi;

class DetailTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DetailTransaksi::create([
            'transaksi_id' => 1,
            'barang_id' => 1,
            'jumlah' => 2,
            'harga_satuan' => 10000,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => 1,
            'barang_id' => 2,
            'jumlah' => 1,
            'harga_satuan' => 15000,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => 2,
            'barang_id' => 3,
            'jumlah' => 3,
            'harga_satuan' => 18000,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => 2,
            'barang_id' => 4,
            'jumlah' => 1,
            'harga_satuan' => 28000,
        ]);

        DetailTransaksi::create([
            'transaksi_id' => 3,
            'barang_id' => 1,
            'jumlah' => 1,
            'harga_satuan' => 10000,
        ]);
    }
}