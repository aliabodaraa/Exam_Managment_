<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    public function rotation(){//one to many between Rotation & Objection
        return $this->belongsTo('App\Models\Rotation');
    }
}
