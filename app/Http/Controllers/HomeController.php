<?php

namespace App\Http\Controllers;
use App\Models\Rotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;

class HomeController extends Controller
{
    public function index()
    { $latest_rotation=Rotation::latest()->first();
        list($all_rotations_table, $observations_number_in_latest_rotation)=Stock::calcInfoForEachRotationForSpecificuser(Auth::user());
                // Warning Section lack of Members start
                $courses_rooms_roles=[];
                foreach ($latest_rotation->coursesProgram()->get() as $course){
                    $rooms_taken=[];
                    foreach ($course->distributionRoom()->wherePivot('rotation_id',$latest_rotation->id)->get() as $room){
                        if(in_array($room->id,$rooms_taken)) continue;
                        array_push($rooms_taken,$room->id);
                        $current_roles_exist_in_room=$room->users()->wherePivot('rotation_id',$latest_rotation->id)->wherePivot('course_id',$course->id)->pluck('roleIn')->toBase()->toarray();
                        $arr_of_str_roles_in_room=[];
                        if(count($current_roles_exist_in_room)<3){
                            if(!in_array("RoomHead",$current_roles_exist_in_room)){
                                array_push($arr_of_str_roles_in_room,"<span class='badge bg-success'>رئيس قاعة</span>");
                            }
                            if(!in_array("Secertary",$current_roles_exist_in_room)){
                                array_push($arr_of_str_roles_in_room,"<span class='badge bg-success'>أمين سر</span>");
                            }
                            if(!in_array("Observer",$current_roles_exist_in_room)){
                                array_push($arr_of_str_roles_in_room,"<span class='badge bg-success'>مراقب</span>");
                            }
                            $courses_rooms_roles[$course->course_name][$room->room_name]=$arr_of_str_roles_in_room;
                    }
                    }
                }
        // $dept=Auth::user()->department->id;
        // $someCoursesBelongToYourDepatment=Course::with(['departments'])->whereHas('departments', function($q) use($dept){
        // $q->where('department_id', '=',$dept);})->where('year',Auth::user()->studing_year)->orderBy('created_at','ASC')->limit(3)->get();

        //$somePostsBelongToYourDepatment=Auth::user()->posts;
        if(Auth::check()){
            if(array_key_exists($latest_rotation->id,$all_rotations_table)){
                return view('home.index', [
                'latest_rotation'=>$latest_rotation,
                'courses_rooms_roles'=>$courses_rooms_roles,
                'user' => Auth::user(),
                'rotations_in_lastet_rotation_table' => $all_rotations_table[$latest_rotation->id],
                'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation]);
            }else{
                return view('home.index', [
                    'latest_rotation'=>$latest_rotation,
                    'courses_rooms_roles'=>$courses_rooms_roles,
                    'user' => Auth::user(),
                    'rotations_in_lastet_rotation_table' => [],
                    'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation]);
            }

        }else
           return view('home.index');
    }
}
