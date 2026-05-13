<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        Transaksi::create(['member_id' => 1]);
        Transaksi::create(['member_id' => 2]);
        Transaksi::create(['member_id' => 3]);
        Transaksi::create(['member_id' => null]);
        Transaksi::create(['member_id' => 1]);
    }
}