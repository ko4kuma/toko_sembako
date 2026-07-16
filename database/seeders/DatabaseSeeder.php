<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pegawai;
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
        $admin = User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        Pegawai::create([
            'user_id' => $admin->id,
            'nama_lengkap' => 'Admin Toko',
            'tanggal_masuk' => now(),
        ]);

        // 2. Membuat akun Kasir
        $kasir = User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);

        Pegawai::create([
            'user_id' => $kasir->id,
            'nama_lengkap' => 'Kasir Toko',
            'tanggal_masuk' => now(),
        ]);

        // 3. Membuat akun Gudang
        $gudang = User::create([
            'name' => 'Petugas Gudang',
            'email' => 'gudang@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'gudang',
        ]);
        Pegawai::create([
            'user_id' => $gudang->id,
            'nama_lengkap' => 'Petugas Gudang',
            'tanggal_masuk' => now(),
        ]);

        // 4. Membuat akun Purchasing
        $purchasing = User::create([
            'name' => 'Bagian Purchasing',
            'email' => 'purchasing@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'purchasing',
        ]);

        Pegawai::create([
            'user_id' => $purchasing->id,
            'nama_lengkap' => 'Bagian Purchasing',
            'tanggal_masuk' => now(),
        ]);
    }
}
