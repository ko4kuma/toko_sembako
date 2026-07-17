<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diskon;

class DiskonSeeder extends Seeder
{
    public function run(): void
    {
        Diskon::insert([

            [
                'nama_diskon' => 'Promo Umum 5%',
                'tipe' => 'umum',
                'syarat_minimal' => 50000,
                'persentase' => 5,
                'berlaku_mulai' => now(),
                'berlaku_sampai' => now()->addMonth(),
                'aktif' => true,
            ],

            [
                'nama_diskon' => 'Promo Member Silver',
                'tipe' => 'member',
                'syarat_minimal' => 100000,
                'persentase' => 10,
                'berlaku_mulai' => now(),
                'berlaku_sampai' => now()->addMonth(),
                'aktif' => true,
            ],

            [
                'nama_diskon' => 'Promo Member Gold',
                'tipe' => 'member',
                'syarat_minimal' => 250000,
                'persentase' => 15,
                'berlaku_mulai' => now(),
                'berlaku_sampai' => now()->addMonths(2),
                'aktif' => true,
            ],

        ]);
    }
}