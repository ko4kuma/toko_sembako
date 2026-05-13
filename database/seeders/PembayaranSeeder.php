<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembayaran;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        Pembayaran::create([
            'transaksi_id' => 1,
            'metode' => 'Cash',
            'jumlah' => 35000,
        ]);

        Pembayaran::create([
            'transaksi_id' => 2,
            'metode' => 'QRIS',
            'jumlah' => 82000,
        ]);

        Pembayaran::create([
            'transaksi_id' => 3,
            'metode' => 'Transfer',
            'jumlah' => 54000,
        ]);

        Pembayaran::create([
            'transaksi_id' => 4,
            'metode' => 'Cash',
            'jumlah' => 10000,
        ]);

        Pembayaran::create([
            'transaksi_id' => 5,
            'metode' => 'QRIS',
            'jumlah' => 28000,
        ]);
    }
}