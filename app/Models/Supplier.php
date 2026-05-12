<?php

namespace App\Models;
use App\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama_supplier', 'alamat', 'no_hp'];

    public function barang() {
        return $this->hasMany(Barang::class);
    }
}
