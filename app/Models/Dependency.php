<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependency extends Model
{
    use HasFactory;

    public function offices(){
        return $this->hasMany(Office::class);
    }
}
