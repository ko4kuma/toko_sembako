<?php

namespace App\Models;
use app\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    public function barang() {
        return $this->belongsTo(Barang::class);
    }
}
