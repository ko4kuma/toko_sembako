<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Diskon;
use App\Models\Transaksi;

class Member extends Model
{
    protected $fillable = ['nama_member', 'alamat', 'no_hp', 'diskon_id'];

    public function diskon() {
        return $this->belongsTo(Diskon::class);
    }
    public function transaksi() {
        return $this->hasMany(Transaksi::class);
    }
}
