<?php

namespace App\Http\Controllers\MaxMinRoomsCapacity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Course;
use App\Models\Rotation;
use App\Models\User;

class Stock extends Controller
{
    public static function getMaxDistribution(){
        $guest_rooms = [122, 123, 124, 125, 126, 127, 128];
        $max_distribution_count=0;
        foreach (Room::toBase()->get() as $room) {
            if($room->is_active && ! in_array($room->id, $guest_rooms)){
                if($room->extra_capacity)
                    $max_distribution_count+=($room->capacity+$room->extra_capacity);
                else
                    $max_distribution_count+=$room->capacity;
            }
        }
        return $max_distribution_count;
    }
    public static function getMinDistribution(){
        $guest_rooms = [122, 123, 124, 125, 126, 127, 128];
        $min_distribution_count=0;
        foreach (Room::toBase()->get() as $room) {
            if($room->is_active && ! in_array($room->id, $guest_rooms)){
                $min_distribution_count+=$room->capacity;
            }
        }
        return $min_distribution_count;
    }
    public static function isAvailableRoom($rotation, $course, $room){
        $curr_date=$rotation->coursesProgram()->where('id',$course->id)->first()->pivot->date;
        $curr_time=$rotation->coursesProgram()->where('id',$course->id)->first()->pivot->time;
        $curr_duration=$rotation->coursesProgram()->where('id',$course->id)->first()->pivot->duration;
    
        foreach (Course::with('distributionRoom')->whereHas('distributionRoom', function($query) use($room,$rotation){
        $query->where('room_id',$room->id)->where('rotation_id',$rotation->id);})->toBase()->get() as $courseM)
                if((count($rotation->coursesProgram()->wherePivot('date',$curr_date)->wherePivot('time','>=',$curr_time)->wherePivot('time','<=',gmdate('H:i:s',strtotime($curr_time)+strtotime($curr_duration)))->where('id',$courseM->id)->get())
                ||  count($rotation->coursesProgram()->wherePivot('date',$curr_date)->wherePivot('time','<=',$curr_time)->wherePivot('time','>=',gmdate('H:i:s',strtotime($curr_time)-strtotime($curr_duration)))->where('id',$courseM->id)->get())))
                        return false;

                return true;
    }


//////////////////edit___________________///////////////////

    //calculate date time duration for specific course
    public static function getDateTimeDuration_ForThisCourse($rotation, $course){
        $date=$rotation->coursesProgram()->where('id',$course->id)->first()->pivot->date;
        $time=$rotation->coursesProgram()->where('id',$course->id)->first()->pivot->time;
        $duration=$rotation->coursesProgram()->where('id',$course->id)->first()->pivot->duration;
        return array($date, $time, $duration);   
    }
    //calculate date time duration for specific course

    //calc number students in this course
    public static function getOccupiedNumberOfStudentsInThisCourse($rotation, $course){
        $occupied_number_of_students_in_this_course=0;
        $arr_occupied_in_this_course=[];//dd($course->id);
        foreach ($course->distributionRoom()->wherePivot('rotation_id',$rotation->id)->get() as $room) {
            array_push($arr_occupied_in_this_course,$room->id);
            $occupied_number_of_students_in_this_course+=$room->pivot->num_student_in_room;
        }
        $entered_students_number=$course->rotationsProgram()->where('id',$rotation->id)->get()[0]->pivot->students_number;
        return array($entered_students_number, $occupied_number_of_students_in_this_course);
    }
    //calc number students in this course

    //calc number students in this courseRoom
    public static function getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course, $roomS_id){
        $occupied_number_of_students_in_this_course_room=0;
        foreach ($course->distributionRoom()->wherePivot('rotation_id',$rotation->id)->where('id',$roomS_id)->get() as $room)
            $occupied_number_of_students_in_this_course_room=$room->pivot->num_student_in_room;
        
        return $occupied_number_of_students_in_this_course_room;
    }
    //calc number students in this courseRoom

    //calculate rooms_this_course_rotation
    public static function getRoomsForSpecificCourse($rotation, $course){
        $rooms_this_course=[];
        foreach ($course->distributionRoom()->wherePivot('rotation_id',$rotation->id)->get() as $room) {
                array_push($rooms_this_course, $room->pivot->room_id);
        }
        return array_unique($rooms_this_course);
    }
    //calculate rooms_this_course_rotation

    //calc Joining rooms and disabled rooms and courses_common_with_time
    public static function getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course){//this method disabled room for spesific course,and joining room,and all courses that they are in date and in rage time as sell as passed course
        $disabled_rooms=[];
        $joining_rooms=[];
        $courses_common_with_time=[];
        list($date, $time, $duration)=Stock::getDateTimeDuration_ForThisCourse($rotation, $course);
        // foreach (Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){
        //     $query->where('rotation_id',$rotation->id);})->where('id','!=',$course->id)->get() as $course_whithin_range_time) {
            foreach ($rotation->coursesProgram()->where('id','!=',$course->id)->get() as $course_whithin_range_time){
                if((count($rotation->coursesProgram()->wherePivot('date',$date)->wherePivot('time','>=',$time)->wherePivot('time','<=',gmdate('H:i:s',strtotime($time)+strtotime($duration)))->where('id',$course_whithin_range_time->id)->toBase()->get())
                ||  count($rotation->coursesProgram()->wherePivot('date',$date)->wherePivot('time','<=',$time)->wherePivot('time','>=',gmdate('H:i:s',strtotime($time)-strtotime($duration)))->where('id',$course_whithin_range_time->id)->toBase()->get())))
                    foreach ($course_whithin_range_time->distributionRoom()->wherePivot('rotation_id',$rotation->id)->toBase()->get() as $room) {
                        
                        array_push($disabled_rooms,$room->id);
                        array_push($courses_common_with_time,$course_whithin_range_time);

                        if(! in_array($room->id,Stock::getRoomsForSpecificCourse($rotation, $course)))
                            array_push($joining_rooms,$room->id);
                        // else
                        //     array_push($courses_common_with_time,$course_whithin_range_time);

                    }
            }

            array_push($courses_common_with_time,$course);//dd(array_unique($courses_common_with_time));
        return array(array_unique($disabled_rooms), array_unique($joining_rooms), array_unique($courses_common_with_time));
    }
    //calc Joining rooms and disabled rooms and courses_common_with_time

    //calc accual_common_rooms_for_specific_course
    public static function getAccualCommonRoomsForSpecificRotationCourse($rotation, $course){
        $accual_common_rooms_for_specific_course=[];
        $common_rooms_ids=[];
        $rooms_this_course=Stock::getRoomsForSpecificCourse($rotation, $course);
        list($date, $time, $duration)=Stock::getDateTimeDuration_ForThisCourse($rotation, $course);
        list($disabled_rooms,,$courses_common_with_time)=Stock::getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course, $date, $time, $duration);
        //dd($disabled_rooms,$courses_common_with_time,$rooms_this_course);
        foreach ($courses_common_with_time as $course_in_time) {
            $num_students_taken_in_each_room_from_other=[];
            if($course_in_time->id == $course->id) continue;
            foreach ($course_in_time->distributionRoom()->wherePivot('rotation_id',$rotation->id)->toBase()->get() as $room) {
                if(in_array($room->id, $disabled_rooms) && in_array($room->id,$rooms_this_course)){
                    $num_students_taken_in_each_room_from_other[$room->id]=Stock::getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course_in_time, $room->id);
                    array_push($common_rooms_ids,$room->id);
                }
            }
            $accual_common_rooms_for_specific_course[$course_in_time->id]=$num_students_taken_in_each_room_from_other;    
            }
            //dd($accual_common_rooms_for_specific_course,$common_rooms_ids);
        return array($accual_common_rooms_for_specific_course,array_unique($common_rooms_ids));
    }
    //calc accual_common_rooms_for_specific_course
//////////////////edit___________________///////////////////

//////////////////User's observations function___________________///////////////////
    //get common rooms as string
    public static function getNamesSharedCoursesWithCommonRoom($rotation, $course_id, $room_id, $date, $time){
        $str_courses_common_names="";
        $course=Course::where('id',$course_id)->first();//dd($date, $time);
        $arr_courses_taken=[];
        foreach (Room::select("course_rotation.course_id")
        ->join("course_rotation",function($join) use($rotation, $date, $time){
                $join->where("course_rotation.rotation_id","=",$rotation->id)
                     ->where("course_rotation.date","=",$date)
                     ->where("course_rotation.time","=",$time);})
        ->join("course_room_rotation",function($join){
                $join->on("course_room_rotation.rotation_id","=","course_rotation.rotation_id")
                     ->on("course_room_rotation.course_id","=","course_rotation.course_id");})->get() as $course) {
                        if(!in_array($course->course_id,$arr_courses_taken)){
                            array_push($arr_courses_taken,$course->course_id);
                            $str_courses_common_names.="/".Course::where('id',$course->course_id)->first()->course_name;
                        }
        }
        foreach ($arr_courses_taken as $key=>$course_id) {
            $course_name=Course::where('id',$course_id)->first()->course_name;
            $arr_courses_taken[$key]=$course_name;
        }
        $str_courses_common_names=join("/",$arr_courses_taken);

       return $str_courses_common_names;
    }
    public static function calcInfoForEachRotationForSpecificuser($user){
        //$rotations_numbers=[];
        $all_rotations_table=[];
        $observations_number_in_latest_rotation=0;
        //calc info for each rotation for current user
        foreach (array_unique($user->rotations->SortByDesc('end_date')->toBase()->pluck('id')->toArray()) as $rotation_id) {
            $rotationInfo=Rotation::where('id',$rotation_id)->first();
            $table=[];
            $table['name']=$rotationInfo->name;
            $table['year']=$rotationInfo->year;
            $table['start_date']=$rotationInfo->start_date;
            $table['end_date']=$rotationInfo->end_date;
            //array_push($rotations_numbers, $rotation_id);
            $common_course_name_once=[];
            foreach(Rotation::
            select("*")->where('id',$rotation_id)->join("course_rotation","course_rotation.rotation_id","=","rotations.id")
            ->join("course_room_rotation_user",function($join) use($user){
                    $join->on("course_room_rotation_user.rotation_id","=","course_rotation.rotation_id")
                         ->on("course_room_rotation_user.course_id","=","course_rotation.course_id")
                         ->where("course_room_rotation_user.user_id","=",$user->id);})
                         ->orderBy("course_rotation.date")->get() as $i => $all_obseravation_info){
                            $table['observations'][$i]['date']=$all_obseravation_info['date'];
                            $table['observations'][$i]['time']=$all_obseravation_info['time'];
                            $table['observations'][$i]['roleIn']=$all_obseravation_info['roleIn'];
                            $table['observations'][$i]['room_name']=Room::where('id',$all_obseravation_info['room_id'])->toBase()->first()->room_name;
                            $table['observations'][$i]['course_name']=Stock::getNamesSharedCoursesWithCommonRoom($rotationInfo,$all_obseravation_info['course_id'],$all_obseravation_info['room_id'],$all_obseravation_info['date'],$all_obseravation_info['time']);
                            if($rotation_id == Rotation::latest()->toBase()->get()[0]->id)
                                $observations_number_in_latest_rotation++;
            }
            $all_rotations_table[$rotation_id]=$table;
        }
        return array($all_rotations_table, $observations_number_in_latest_rotation);
    }
//////////////////User's observations function___________________///////////////////


//////////////////update///////////////////
    public static function getUsersInSpecificRotationCourseRoom($rotation,$course,$room_id){
        $roomHeadsArr=[];
        $secertariesArr=[];
        $observersArr=[];
        foreach ($course->users()->wherePivot('rotation_id',$rotation->id)->wherePivot('room_id',$room_id)->get() as $user) 
            if($user->pivot->roleIn == "RoomHead")
                array_push($roomHeadsArr,$user->id);
            elseif($user->pivot->roleIn == "Secertary")
                array_push($secertariesArr,$user->id);
            elseif($user->pivot->roleIn == "Observer")
                array_push($observersArr,$user->id);
            
        return array($roomHeadsArr, $secertariesArr, $observersArr);

    }
    public static function getUsersInSpecificRotationCourse($rotation,$course){
        $members_in_course=[];
        foreach ($course->rooms()->wherePivot('rotation_id',$rotation->id)->toBase()->get() as $room) 
            $members_in_course[$room->id]=Stock::getUsersInSpecificRotationCourseRoom($rotation,$course,$room->id);
            
        return $members_in_course;

    }
    public static function getUsersInSpecificRotation($rotation){
        $members_in_rotation=[];
        foreach ($rotation->coursesProgram()->toBase()->get() as $course) 
            $members_in_rotation[$course->id]=Stock::getUsersInSpecificRotationCourse($rotation,$course);

        return $members_in_rotation;
    }
//////////////////update///////////////////
//////////////////edit room in specific course///////////////////
    public static function getDisabledUsersInSpesificCourse($rotation, $course, $date, $time, $duration){
        $disabled_roomHeadArr=[];
        $disabled_secertaryArr=[];
        $disabled_observerArr=[];
        // foreach (Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($date,$rotation){
        //     $query->where('date',$date)->where('rotation_id',$rotation->id);})->where('id','!=',$course->id)->get() as $course_whithin_range_time) {
        foreach ($rotation->coursesProgram()->where('id','!=',$course->id)->get() as $course_whithin_range_time){
                if((count($rotation->coursesProgram()->wherePivot('date',$date)->wherePivot('time','>=',$time)->wherePivot('time','<=',gmdate('H:i:s',strtotime($time)+strtotime($duration)))->where('id',$course_whithin_range_time->id)->get()->toArray())
                ||  count($rotation->coursesProgram()->wherePivot('date',$date)->wherePivot('time','<=',$time)->wherePivot('time','>=',gmdate('H:i:s',strtotime($time)-strtotime($duration)))->where('id',$course_whithin_range_time->id)->get()->toArray())))
                    foreach ($course_whithin_range_time->users()->wherePivot('rotation_id',$rotation->id)->get() as $user) {
                        if($user->pivot->roleIn=="Room-Head")
                            array_push($disabled_roomHeadArr,$user->id);
                        elseif($user->pivot->roleIn=="Secertary")
                            array_push($disabled_secertaryArr,$user->id);
                        elseif($user->pivot->roleIn=="Observer")
                            array_push($disabled_observerArr,$user->id);
                    }
            }
            return array(array_unique($disabled_roomHeadArr), array_unique($disabled_secertaryArr), array_unique($disabled_observerArr));
    }

    public static function getUsersInJoiningRoomsForDisabledThemWithRotationCourse($rotation,$course){
        
        $all_disabled_users_in_joining_room=[];
        list($date, $time, $duration)=Stock::getDateTimeDuration_ForThisCourse($rotation, $course);
        list(,$joining_rooms,$courses_common_with_time)=Stock::getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course, $date, $time, $duration);
        if(count($joining_rooms)){
            foreach ($courses_common_with_time as $course_belongs) {
                if($course_belongs->id == $course->id) continue;
                    foreach ($course_belongs->rooms as $room) {
                        if(in_array($room->id, $joining_rooms)){
                                list($roomHrads,$secertaries,$observers)=Stock::getUsersInSpecificRotationCourseRoom($rotation,$course_belongs, $room->id);
                                $all_disabled_users_in_joining_room=array_merge($all_disabled_users_in_joining_room,$roomHrads);
                                $all_disabled_users_in_joining_room=array_merge($all_disabled_users_in_joining_room,$secertaries);
                                $all_disabled_users_in_joining_room=array_merge($all_disabled_users_in_joining_room,$observers);
                                }                    
                        }
            }
        }
        return $all_disabled_users_in_joining_room;
    }
    public static function getUsersInSpecificJoiningRoomForRotationCourseRoom($rotation,$course,$roomS){
        $room_heads_in_current_joining_in_this_rotation_course_room=[];
        $secertaries_in_current_joining_in_this_rotation_course_room=[];
        $observers_in_current_joining_in_this_rotation_course_room=[];
        list($date, $time, $duration)=Stock::getDateTimeDuration_ForThisCourse($rotation, $course);
        list(,$joining_rooms,$courses_common_with_time)=Stock::getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course, $date, $time, $duration);
        if(count($joining_rooms)){
            foreach ($courses_common_with_time as $course_belongs) {
                if($course_belongs->id == $course->id) continue;
                    foreach ($course_belongs->rooms as $room) {
                        if($roomS->id == $room->id && in_array($room->id, $joining_rooms)){
                                list($roomHrads,$secertaries,$observers)=Stock::getUsersInSpecificRotationCourseRoom($rotation,$course_belongs, $room->id);
                                $room_heads_in_current_joining_in_this_rotation_course_room=array_merge($room_heads_in_current_joining_in_this_rotation_course_room,$roomHrads);
                                $secertaries_in_current_joining_in_this_rotation_course_room=array_merge($secertaries_in_current_joining_in_this_rotation_course_room,$secertaries);
                                $observers_in_current_joining_in_this_rotation_course_room=array_merge($observers_in_current_joining_in_this_rotation_course_room,$observers);
                                break;
                            }   
                        }
            }
        }
        return array($room_heads_in_current_joining_in_this_rotation_course_room,
                    $secertaries_in_current_joining_in_this_rotation_course_room,
                    $observers_in_current_joining_in_this_rotation_course_room);
    }
//////////////////edit room in specific course///////////////////


}
