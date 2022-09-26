<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'year',
        'start_date',
        'end_date',
   ];
    public function objections(){//one to many between Rotation & Objection
        return $this->hasMany('App\Models\Objection');
    }
    public function users(){//many to many between Rotation & User
        return $this->belongsToMany('App\Models\User','course_room_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room');
    }
    public function courses(){//many to many between Rotation & Course
        return $this->belongsToMany(Course::class,'course_room_user')->withPivot('user_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function rooms(){//many to many between Rotation & Room
        return $this->belongsToMany(Room::class,'course_room_user')->withPivot('user_id','course_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
}
