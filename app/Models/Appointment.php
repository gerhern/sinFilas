<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public $fillable = [
        'appointment_status'
    ];

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
