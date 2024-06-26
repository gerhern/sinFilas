<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function offices(){
        return $this->belongsToMany(Office::class)->orderBy('name');
    }
    public function appointment(){
        return $this->hasMany(Appointment::class);
    }
}
