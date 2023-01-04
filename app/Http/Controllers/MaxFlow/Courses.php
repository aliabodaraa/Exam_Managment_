<?php

namespace App\Http\Controllers\MaxFlow;
use App\Models\Course;
use App\Models\Rotation;
use App\Http\Controllers\Controller;
class Courses extends Controller
{
    private Rotation $rotation;
    private array $courses_ids;
    private int $length;

    public function __construct($rotation){
        $this->rotation=$rotation;
        $courses=$this->rotation->coursesProgram()->orderBy('course_rotation.date','asc')->toBase()->pluck('id')->toarray();
        $this->courses_ids=$courses;
        $this->length=count($courses);
    }

    public function getLength(){
        return $this->length;
    }

    public function getCourses(){
        //note : check count courses in latestRotation if it is equal to the number of courses in DB
        return $this->courses_ids;
    }
    
}
