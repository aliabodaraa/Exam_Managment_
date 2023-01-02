<?php

namespace App\Http\Controllers\MaxFlow;
use App\Models\Course;
use App\Models\Rotation;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class Courses extends Controller
{
    private Rotation $rotation;
    private array $courses_ids;
    private int $length;
    private int $num_distict_times;

    public function __construct($rotation){
        $this->rotation=$rotation;
        $courses=$this->rotation->coursesProgram()->orderBy('course_rotation.date','asc')->get()->pluck('id')->toarray();
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

    public function coursesInSameTimes(){
        $same_times[0]=$counter=0;
        for ($i=1; $i < $this->length ; $i++) {
            $date1=Carbon::parse(Course::where('id',$this->courses_ids[$i])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->date);
            $date2=Carbon::parse(Course::where('id',$this->courses_ids[$i-1])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->date);
            if($date1->eq($date2)){
                $same_times[$i]=$same_times[$i-1];
                continue;
            }
            $same_times[$i]=++$counter;
        }
        $num_distict_times=count(array_unique($same_times));

        return array($same_times,$num_distict_times);
    }
    
}
