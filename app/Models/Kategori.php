<?php

namespace App\Models;
use app\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori'];

    public function barang() {
        return $this->hasMany(Barang::class);
    }
}
