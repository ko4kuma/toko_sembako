<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Transaksi;

class Member extends Model
{
    protected $fillable = ['nama_member', 'alamat', 'no_hp'];

    public function transaksi() {
        return $this->hasMany(Transaksi::class);
    }
}
