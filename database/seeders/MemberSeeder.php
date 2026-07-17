<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::insert([

            [
                'nama_member' => 'Budi Santoso',
                'alamat' => 'Bandung',
                'no_hp' => '081234567801'
            ],

            [
                'nama_member' => 'Siti Aminah',
                'alamat' => 'Lembang',
                'no_hp' => '081234567802'
            ],

            [
                'nama_member' => 'Andi Saputra',
                'alamat' => 'Cimahi',
                'no_hp' => '081234567803'
            ],

            [
                'nama_member' => 'Rina Marlina',
                'alamat' => 'Padalarang',
                'no_hp' => '081234567804'
            ],

            [
                'nama_member' => 'Dedi Kurniawan',
                'alamat' => 'Bandung Barat',
                'no_hp' => '081234567805'
            ],

            [
                'nama_member' => 'Yuni Lestari',
                'alamat' => 'Ngamprah',
                'no_hp' => '081234567806'
            ],

            [
                'nama_member' => 'Rudi Hartono',
                'alamat' => 'Cisarua',
                'no_hp' => '081234567807'
            ]

        ]);
    }
}