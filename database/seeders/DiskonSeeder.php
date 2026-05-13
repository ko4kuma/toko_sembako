<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diskon;

class DiskonSeeder extends Seeder
{
    public function run(): void
    {
        Diskon::create([
            'nama_diskon' => 'Tidak Ada Diskon',
            'persentase' => 0,
        ]);

        Diskon::create([
            'nama_diskon' => 'Silver',
            'persentase' => 5,
        ]);

        Diskon::create([
            'nama_diskon' => 'Gold',
            'persentase' => 10,
        ]);

        Diskon::create([
            'nama_diskon' => 'Platinum',
            'persentase' => 15,
        ]);
    }
}