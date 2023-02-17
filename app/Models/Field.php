<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    public function university(){
        return $this->belongsTo(University::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }


}
