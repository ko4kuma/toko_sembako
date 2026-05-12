<?php

namespace App\Models;
use app\Models\Barang;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function barang() {
        return $this->hasMany(Barang::class);
    }
}
