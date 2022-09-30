<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
         'room_name',
         'capacity',
         'location',
         'notes',
    ];
    public function courses(){//many to many between Room & Course
        return $this->belongsToMany('App\Models\Course','course_room_rotation_user')->withPivot('user_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function users(){//many to many between Room & User
        return $this->belongsToMany('App\Models\User','course_room_rotation_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function rotations(){//many to many between Room & Rotation
        return $this->belongsToMany('App\Models\Rotation','course_room_rotation_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
}
