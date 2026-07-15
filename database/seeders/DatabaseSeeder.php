<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Wajib ditambahkan untuk enkripsi password

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat akun Admin
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Membuat akun Kasir
        User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);

        // 3. Membuat akun Gudang
        User::create([
            'name' => 'Petugas Gudang',
            'email' => 'gudang@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'gudang',
        ]);

        // 4. Membuat akun Purchasing
        User::create([
            'name' => 'Bagian Purchasing',
            'email' => 'purchasing@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'purchasing',
        ]);
    }
}
