<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::insert([

            [
                'nama_barang' => 'Beras Ramos 5 Kg',
                'harga' => 72000,
                'kategori_id' => 1,
                'supplier_id' => 2,
            ],

            [
                'nama_barang' => 'Gula Pasir 1 Kg',
                'harga' => 18000,
                'kategori_id' => 1,
                'supplier_id' => 2,
            ],

            [
                'nama_barang' => 'Minyak Goreng Bimoli 2L',
                'harga' => 42000,
                'kategori_id' => 1,
                'supplier_id' => 2,
            ],

            [
                'nama_barang' => 'Teh Botol Sosro',
                'harga' => 5000,
                'kategori_id' => 2,
                'supplier_id' => 3,
            ],

            [
                'nama_barang' => 'Aqua 600 ml',
                'harga' => 4000,
                'kategori_id' => 2,
                'supplier_id' => 3,
            ],

            [
                'nama_barang' => 'Indomie Goreng',
                'harga' => 3500,
                'kategori_id' => 3,
                'supplier_id' => 2,
            ],

            [
                'nama_barang' => 'Chitato Sapi Panggang',
                'harga' => 11000,
                'kategori_id' => 4,
                'supplier_id' => 3,
            ],

            [
                'nama_barang' => 'Royco Ayam',
                'harga' => 2500,
                'kategori_id' => 5,
                'supplier_id' => 2,
            ],

            [
                'nama_barang' => 'Sunlight 750 ml',
                'harga' => 18000,
                'kategori_id' => 6,
                'supplier_id' => 4,
            ],

            [
                'nama_barang' => 'Lifebuoy 80 gr',
                'harga' => 6000,
                'kategori_id' => 7,
                'supplier_id' => 4,
            ],

        ]);
    }
}