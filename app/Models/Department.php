<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'faculty_id'
    ];

    public function users(){//one to many between Department & user
        return $this->hasMany(User::class);
     }
     public function students(){//one to many between Department & student
        return $this->hasMany(Student::class);
     }
     public function courses(){//many to many between Department & course
        return $this->belongsToMany('App\Models\Course');
    }

    public function faculty(){//one to many between faculty & department
        return $this->belongsTo(Faculty::class);//->withDefault(['name1'=>'dfd','name2'=>'ks']);// can access to this properties like i name foreginKey dept_id instead of name department_id  if doesn't has any problem i can't access to this properties
        //when reletionship has a problem the benifit of this to acees to this properties when access to this relationship from any user as   <h1>{{$user->department->name1}}</h1><h1>{{$user->department->name2}}</h1>
    }
}
