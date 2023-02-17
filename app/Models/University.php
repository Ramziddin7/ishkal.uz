<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    public function field(){
        return $this->hasMany(Field::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
