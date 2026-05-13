<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::create([
            'nama_member' => 'Budi',
            'alamat' => 'Bandung',
            'no_hp' => '08123456789',
            'diskon_id' => 1,
        ]);

        Member::create([
            'nama_member' => 'Siti',
            'alamat' => 'Jakarta',
            'no_hp' => '082233445566',
            'diskon_id' => 2,
        ]);

        Member::create([
            'nama_member' => 'Andi',
            'alamat' => 'Bekasi',
            'no_hp' => '081299887766',
            'diskon_id' => 3,
        ]);
    }
}