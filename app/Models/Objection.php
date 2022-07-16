<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    public function course_room_user(){//One to One between Objection & Course_Room_User
        return $this->belongsTo("App\Course_room_User");
    }
}
