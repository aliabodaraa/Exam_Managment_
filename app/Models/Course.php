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

    public function users(){//many to many between course & user
        return $this->belongsToMany(User::class,'course_room_rotation_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function rooms(){//many to many between course & user
        return $this->belongsToMany(Room::class,'course_room_rotation_user')->withPivot('user_id','course_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function rotations(){//many to many between User & Rotation
        return $this->belongsToMany('App\Models\Rotation','course_room_rotation_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }



    public function rotationsObservation(){//many to many between course & rotation & user
        return $this->belongsToMany('App\Models\Rotation','course_rotation_user')->withPivot('course_id','user_id','rotation_id');
    }
    public function usersObservation(){//many to many between course & rotation & user
        return $this->belongsToMany('App\Models\User','course_rotation_user')->withPivot('course_id','user_id','rotation_id');
    }

    public function departments(){//many to many between Department & course
        return $this->belongsToMany('App\Models\Department');
    }
    public function faculty(){//one to many between faculty & course
        return $this->belongsTo(Faculty::class);//->withDefault(['name1'=>'dfd','name2'=>'ks']);// can access to this properties like i name foreginKey dept_id instead of name department_id  if doesn't has any problem i can't access to this properties
        //when reletionship has a problem the benifit of this to acees to this properties when access to this relationship from any user as   <h1>{{$user->department->name1}}</h1><h1>{{$user->department->name2}}</h1>
    }
}
