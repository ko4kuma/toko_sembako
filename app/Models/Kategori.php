<?php

namespace App\Models;
use app\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    public function barang() {
        return $this->belongsToMany(Barang::class);
    }
}
