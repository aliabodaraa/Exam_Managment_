<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable=[
        'course_name',
        'studing_year',
        'semester',
        'students_number',
        'duration'
    ];

    public function users(){//many to many between course & user
        return $this->belongsToMany(User::class,'course_room_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function rooms(){//many to many between course & user
        return $this->belongsToMany(Room::class,'course_room_user')->withPivot('user_id','course_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function rotations(){//many to many between User & Rotation
        return $this->belongsToMany('App\Models\Rotation','course_room_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
}
