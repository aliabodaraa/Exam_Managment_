<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_room_User extends Model
{
    use HasFactory;
    public function objection(){//One to One between Objection & Course_Room_User
        return $this->hasOne("App\Objection");
    }
}
