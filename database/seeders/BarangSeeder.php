<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::create([
            'nama_barang' => 'Beras 5kg',
            'harga' => 75000,
            'kategori_id' => 1,
             'supplier_id' => 1
        ]);

        Barang::create([
            'nama_barang' => 'Gula 1kg',
            'harga' => 15000,
            'kategori_id' => 1,
            'supplier_id' => 1
        ]);

        Barang::create([
            'nama_barang' => 'Minyak Goreng 1L',
            'harga' => 18000,
            'kategori_id' => 1,
            'supplier_id' => 1
        ]);

        Barang::create([
            'nama_barang' => 'Telur 1kg',
            'harga' => 28000,
            'kategori_id' => 1,
            'supplier_id' => 1
        ]);
    }
}