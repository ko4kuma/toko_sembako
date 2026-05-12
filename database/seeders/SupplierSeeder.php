<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::create([
            'nama_supplier' => 'PT Sumber Rejeki',
            'alamat' => 'Bandung',
            'no_hp' => '081234567890'
        ]);

        Supplier::create([
            'nama_supplier' => 'PT Maju Jaya',
            'alamat' => 'Jakarta',
            'no_hp' => '081298765432'
        ]);
    }
}