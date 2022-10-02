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
        'faculty_id'
   ];



    //program1
        public function coursesProgram(){
            return $this->belongsToMany('App\Models\Course','course_rotation')->withPivot('course_id','rotation_id','date','time','students_number','duration');
        }
    //program1
    //distribution_of_students_to_the_rooms2
    public function distributionCourse(){//2
        return $this->belongsToMany('App\Models\Course','course_room_rotation')->withPivot('course_id','room_id','rotation_id','num_student_in_room');
    }
    public function distributionRoom(){//2
        return $this->belongsToMany('App\Models\Room','course_room_rotation')->withPivot('course_id','room_id','rotation_id','num_student_in_room');
    }
    //distribution_of_students_to_the_rooms2
    //observation2
    public function usersObservation(){
        return $this->belongsToMany('App\Models\User','course_rotation_user')->withPivot('course_id','user_id','rotation_id');
    }
    public function coursesObservation(){
        return $this->belongsToMany('App\Models\Course','course_rotation_user')->withPivot('course_id','user_id','rotation_id');
    }
    //observation2

    //assign_users_in_rooms3
    public function users(){//many to many between Rotation & User
        return $this->belongsToMany('App\Models\User','course_room_rotation_user')->withPivot('course_id','room_id','date','time','roleIn','num_student_in_room');
    }
    public function courses(){//many to many between Rotation & Course
        return $this->belongsToMany(Course::class,'course_room_rotation_user')->withPivot('user_id','room_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    public function rooms(){//many to many between Rotation & Room
        return $this->belongsToMany(Room::class,'course_room_rotation_user')->withPivot('user_id','course_id','date','time','roleIn','num_student_in_room','rotation_id');
    }
    //assign_users_in_rooms3

    public function faculty(){//one to many between faculty & rotation
        return $this->belongsTo(Faculty::class);//->withDefault(['name1'=>'dfd','name2'=>'ks']);// can access to this properties like i name foreginKey dept_id instead of name department_id  if doesn't has any problem i can't access to this properties
        //when reletionship has a problem the benifit of this to acees to this properties when access to this relationship from any user as   <h1>{{$user->department->name1}}</h1><h1>{{$user->department->name2}}</h1>
    }
}
