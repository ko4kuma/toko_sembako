<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::insert([
            ['nama_kategori' => 'Sembako'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Makanan'],
            ['nama_kategori' => 'Snack'],
            ['nama_kategori' => 'Bumbu Dapur'],
            ['nama_kategori' => 'Kebersihan'],
            ['nama_kategori' => 'Perawatan Tubuh'],
            ['nama_kategori' => 'Alat Tulis'],
        ]);
    }
}