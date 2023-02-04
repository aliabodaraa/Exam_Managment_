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
         'extra_capacity',
         'location',
         'notes',
         'faculty_id'
    ];

    //distribution_of_students_to_the_rooms2
    public function distributionCourse(){//2
        return $this->belongsToMany('App\Models\Course','course_room_rotation')->withPivot('course_id','room_id','rotation_id','num_student_in_room');
    }
    public function distributionRotation(){//2
        return $this->belongsToMany('App\Models\Rotation','course_room_rotation')->withPivot('course_id','room_id','rotation_id','num_student_in_room');
    }
    //distribution_of_students_to_the_rooms2

    //assign_users_in_rooms3
    public function courses(){//many to many between Room & Course
        return $this->belongsToMany('App\Models\Course','course_room_rotation_user')->withPivot('rotation_id','course_id','room_id','user_id','roleIn');
    }
    public function users(){//many to many between Room & User
        return $this->belongsToMany('App\Models\User','course_room_rotation_user')->withPivot('rotation_id','course_id','room_id','user_id','roleIn');
    }
    public function rotations(){//many to many between Room & Rotation
        return $this->belongsToMany('App\Models\Rotation','course_room_rotation_user')->withPivot('rotation_id','course_id','room_id','user_id','roleIn');
    }
    //assign_users_in_rooms3

    public function faculty(){//one to many between faculty & room
        return $this->belongsTo(Faculty::class);//->withDefault(['name1'=>'dfd','name2'=>'ks']);// can access to this properties like i name foreginKey dept_id instead of name department_id  if doesn't has any problem i can't access to this properties
        //when reletionship has a problem the benifit of this to acees to this properties when access to this relationship from any user as   <h1>{{$user->department->name1}}</h1><h1>{{$user->department->name2}}</h1>
    }
}
