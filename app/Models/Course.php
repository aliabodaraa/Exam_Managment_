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
        'duration',
        'faculty_id'
    ];

    //program1
    public function rotationsProgram(){//1
        return $this->belongsToMany('App\Models\Rotation','course_rotation')->withPivot('course_id','rotation_id','date','time','students_number','duration');
    }
    //program1
    //observation2
    public function rotationsObjection(){//many to many between course & rotation & user
        return $this->belongsToMany('App\Models\Rotation','course_rotation_user')->withPivot('course_id','user_id','rotation_id');
    }
    public function usersObjection(){//many to many between course & rotation & user
        return $this->belongsToMany('App\Models\User','course_rotation_user')->withPivot('course_id','user_id','rotation_id');
    }
    //observation2
    //distribution_of_students_to_the_rooms2
    public function distributionRotation(){//2
        return $this->belongsToMany('App\Models\Rotation','course_room_rotation')->withPivot('course_id','room_id','rotation_id','num_student_in_room');
    }
    public function distributionRoom(){//2
        return $this->belongsToMany('App\Models\Room','course_room_rotation')->withPivot('course_id','room_id','rotation_id','num_student_in_room');
    }
    //distribution_of_students_to_the_rooms2

    //assign_users_in_rooms3
    public function users(){//many to many between course & user
        return $this->belongsToMany('App\Models\User','course_room_rotation_user')->withPivot('rotation_id','course_id','room_id','user_id','roleIn');
    }
    public function rooms(){//many to many between course & user
        return $this->belongsToMany('App\Models\Room','course_room_rotation_user')->withPivot('rotation_id','course_id','room_id','user_id','roleIn');
    }
    public function rotations(){//many to many between User & Rotation
        return $this->belongsToMany('App\Models\Rotation','course_room_rotation_user')->withPivot('rotation_id','course_id','room_id','user_id','roleIn');
    }
    //assign_users_in_rooms3

    public function departments(){//many to many between Department & course
        return $this->belongsToMany('App\Models\Department');
    }
    public function faculty(){//one to many between faculty & course
        return $this->belongsTo(Faculty::class);//->withDefault(['name1'=>'dfd','name2'=>'ks']);// can access to this properties like i name foreginKey dept_id instead of name department_id  if doesn't has any problem i can't access to this properties
        //when reletionship has a problem the benifit of this to acees to this properties when access to this relationship from any user as   <h1>{{$user->department->name1}}</h1><h1>{{$user->department->name2}}</h1>
    }
}
