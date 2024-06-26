<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    public function transactions(){
        return $this->belongsToMany(Transaction::class)->orderBy('name');
    }

    public function dependency(){
        return $this->belongsTo(Dependency::class);
    }
}
