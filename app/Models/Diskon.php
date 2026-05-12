<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Member;

class Diskon extends Model
{
    protected $fillable = ['nama_diskon', 'persentase'];
    
    public function member() {
        return $this->hasMany(Member::class);
    }
}
