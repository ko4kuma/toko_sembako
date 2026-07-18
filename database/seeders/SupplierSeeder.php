<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            [
                'nama_supplier' => 'PT Indofood CBP',
                'alamat' => 'Bandung',
                'no_hp' => '081234567890'
            ],
            [
                'nama_supplier' => 'PT Wings Food',
                'alamat' => 'Jakarta',
                'no_hp' => '081234567891'
            ],
            [
                'nama_supplier' => 'PT Mayora Indah',
                'alamat' => 'Tangerang',
                'no_hp' => '081234567892'
            ],
            [
                'nama_supplier' => 'PT Unilever Indonesia',
                'alamat' => 'Bekasi',
                'no_hp' => '081234567893'
            ],
            [
                'nama_supplier' => 'CV Sumber Rejeki',
                'alamat' => 'Lembang',
                'no_hp' => '081234567894'
            ]
        ]);
    }
}