<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rotation;
use App\Models\Course;
use App\Models\Department;
use App\Models\Room;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\DB;
class CourseRotationController extends Controller
{
    public function get_room_for_course(Rotation $rotation, Course $course, Room $specific_room){
        $common_rooms=[];
        $date=null;
        $time=null;$users_in_rooms=[];            $room_Distinct=[];$disabled_rooms=[];            $disabled_roomHeadArr=[];
        $disabled_secertaryArr=[];
        $disabled_observerArr=[];$all_common_courses=[];
        $roomsArr=[];$users_commom_courses=[];
        if(count($course->users->toArray()) /*&& in_array($course->id,$rotation->courses->toArray())*/){
            //calc disabled_users
            foreach ($course->rotations as $rot) {
                if($rot->pivot->rotation_id == $rotation->id){
                    $date = $course->users[0]->pivot->date;
                    $time = $course->users[0]->pivot->time;
                    break;
                }
            }

            foreach ($course->rooms as $room) {
                if($rotation->id == $room->pivot->rotation_id)
                    array_push($roomsArr,$room->pivot->room_id);
            }
            $roomsArr=array_unique($roomsArr);

            //calc disabled_rooms
            
            foreach (Course::with('users')
            ->whereHas('users', function($query) use($date,$rotation){
            $query->where('date',$date)->where('rotation_id',$rotation->id);
                })->get() as $courseN) {
                        if($courseN->id == $course->id)
                            continue;
                        foreach ($courseN->rooms as $room) {
                            if($rotation->id == $room->pivot->rotation_id)
                                if( (($time < $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>$room->pivot->time ))
                                || (($time >  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) > $time)) ){
                                    array_push($disabled_rooms,$room->id);
                    }
                }
            }
            //dd($disabled_rooms);
            $disabled_rooms=array_unique($disabled_rooms);
            //dd($disabled_rooms);
            //calc common_room
            foreach ($course->rooms as $room)
                if($rotation->id == $room->pivot->rotation_id)
                    if(in_array($room->id,$disabled_rooms) && in_array($room->id,$roomsArr))
                        array_push($common_rooms,$room->id);

            $common_rooms=array_unique($common_rooms);

            //the same code privous for store observers and secertaries and roomheads for each room
            $roomHeadArr=[];
            $secertaryArr=[];
            $observerArr=[];

            
            foreach ($course->rooms as $room) {
                if($rotation->id == $room->pivot->rotation_id)
                    if(! in_array($room->id,$common_rooms)){//for does not appear common rooms cause we will put the common rooms on the array users_commom_courses
                        $secertaryArr=[];
                        $roomHeadArr=[];
                        $observerArr=[];
                        array_push($room_Distinct,$room->id);
                        foreach ($room->users as $user) {
                            if($rotation->id == $user->pivot->rotation_id)
                                if($user->pivot->course_id==$course->id){
                                    if($user->pivot->roleIn=="Secertary"){
                                        array_push($secertaryArr,$user->pivot->user_id);
                                    }elseif($user->pivot->roleIn=="Room-Head"){
                                        array_push($roomHeadArr,$user->pivot->user_id);
                                    }else{
                                        array_push($observerArr,$user->pivot->user_id);
                                    }
                                }
                            }
                        $users_in_rooms[$room->id]['roomHeads']=$roomHeadArr;
                        $users_in_rooms[$room->id]['secertaries']=$secertaryArr;
                        $users_in_rooms[$room->id]['observers']=$observerArr;
                    }
            }
            foreach (Room::all() as $roomN) {
                if(! in_array($roomN->id,$room_Distinct)){
                    $users_in_rooms[$roomN->id]['roomHeads']=[];
                    $users_in_rooms[$roomN->id]['secertaries']=[];
                    $users_in_rooms[$roomN->id]['observers']=[];
                }
            }
                
                //calc courses that causes common room
                foreach (Course::with('users')
                ->whereHas('users', function($query) use($date,$rotation){$query->where('date',$date)->where('rotation_id',$rotation->id);})->get() as $courseN) {
                    foreach ($courseN->rooms as $room) {
                        if(!in_array($room->id,$common_rooms)) continue;
                        if($rotation->id == $room->pivot->rotation_id)
                            if( (($time < $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration)) > $room->pivot->time ))
                            || (($time >  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) > $time)) )
                                array_push($all_common_courses,$courseN->course_name);
                    }
                }
                $all_common_courses=array_unique($all_common_courses);

                foreach (Course::with('users')
                ->whereHas('users', function($query) use($date,$rotation){
                $query->where('date',$date)->where('rotation_id',$rotation->id);
                    })->get() as $courseN) {
                    foreach ($courseN->users as $user) {
                        if($rotation->id == $user->pivot->rotation_id)
                            if( (($time <= $user->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration)) >= $user->pivot->time ))
                            || (($time >=  $user->pivot->time) && (gmdate('H:i:s',strtotime($user->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                                if($user->pivot->roleIn=="Room-Head")
                                    array_push($disabled_roomHeadArr,$user->id);
                                elseif($user->pivot->roleIn=="Secertary")
                                    array_push($disabled_secertaryArr,$user->id);
                                elseif($user->pivot->roleIn=="Observer")
                                    array_push($disabled_observerArr,$user->id);
                            }
                    }
                }
                //calc users_commom_courses
                $courses_common=Course::whereIn('course_name',$all_common_courses)->get();
                
                $users_roomHeads_commom_courses=[];
                $users_secertaries_commom_courses=[];
                $users_observers_commom_courses=[];
                foreach ($courses_common as $courseQ) {
                $courseE=Course::find($courseQ->id);
                foreach ($courseE->users as $course_user) {
                    if($rotation->id == $course_user->pivot->rotation_id)
                        if(in_array($course_user->pivot->room_id,$common_rooms)){
                            if($course_user->pivot->roleIn=="Secertary"){
                                array_push($users_secertaries_commom_courses,$course_user->id);
                            }elseif($course_user->pivot->roleIn=="Room-Head"){
                                array_push($users_roomHeads_commom_courses,$course_user->id);
                            }else{
                                array_push($users_observers_commom_courses,$course_user->id);
                            }
                        }
                }
                $users_roomHeads_commom_courses=array_unique($users_roomHeads_commom_courses);
                $users_secertaries_commom_courses=array_unique($users_secertaries_commom_courses);
                $users_observers_commom_courses=array_unique($users_observers_commom_courses);
                $users_commom_courses['roomHeads']=$users_roomHeads_commom_courses;
                $users_commom_courses['secertaries']=$users_secertaries_commom_courses;
                $users_commom_courses['observers']=$users_observers_commom_courses;
                }
            }

            $users_will_in_common_Room_Head=User::with('rooms','courses')
            ->whereHas('rooms', function($query) use($date,$time,$specific_room,$rotation){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id)->where('roleIn','Room-Head')->where('rotation_id',$rotation->id);})->get();
            $users_will_in_common_Secertary=User::with('rooms','courses')
            ->whereHas('rooms', function($query) use($date,$time,$specific_room,$rotation){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id)->where('roleIn','Secertary')->where('rotation_id',$rotation->id);})->get();
            $users_will_in_common_Observer=User::with('rooms','courses')
            ->whereHas('rooms', function($query) use($date,$time,$specific_room,$rotation){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id)->where('roleIn','Observer')->where('rotation_id',$rotation->id);})->get();
            //dd($users_will_in_common_Room_Head,$users_will_in_common_Secertary,$users_will_in_common_Observer);

            $users_will_in_common_ids["Room_Head"]=$users_will_in_common_Room_Head->pluck('id')->toArray();
            $users_will_in_common_ids["Secertary"]=$users_will_in_common_Secertary->pluck('id')->toArray();
            $users_will_in_common_ids["Observer"]=$users_will_in_common_Observer->pluck('id')->toArray();

            return view('courses.edit_course_room',compact('rotation','course','specific_room','users_in_rooms','room_Distinct','disabled_rooms','users_will_in_common_ids'
            ,'disabled_secertaryArr','disabled_roomHeadArr','disabled_observerArr','common_rooms'
            ,'all_common_courses','users_commom_courses'));
    }

    public function customize_room_for_course(Request $request, Rotation $rotation, Course $course, Room $specific_room){
 
        $common_rooms=[];            $disabled_rooms=[];            $date=null;
        $time=null;
            //dd($users_in_rooms);
        if(count($course->users->toArray()) /*&& in_array($course->id,$rotation->courses->toArray())*/){
            //calc disabled_users
            foreach ($course->rotations as $rot) {
                if($rot->pivot->rotation_id == $rotation->id){
                    $date = $course->users[0]->pivot->date;
                    $time = $course->users[0]->pivot->time;
                    break;
                }
            }
            $disabled_roomHeadArr=[];
            $disabled_secertaryArr=[];
            $disabled_observerArr=[];
            foreach (Course::with('users')
            ->whereHas('users', function($query) use($date,$rotation){
            $query->where('date',$date)->where('rotation_id',$rotation->id);
                })->get() as $courseN) {
                if($courseN->id == $course->id)
                    continue;
                foreach ($courseN->users as $user) {
                    if($rotation->id == $user->pivot->rotation_id)
                        if( (($time <= $user->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$user->pivot->time ))
                        || (($time >=  $user->pivot->time) && (gmdate('H:i:s',strtotime($user->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                                if($user->pivot->roleIn=="Room-Head")
                                    array_push($disabled_roomHeadArr,$user->id);
                                elseif($user->pivot->roleIn=="Secertary")
                                    array_push($disabled_secertaryArr,$user->id);
                                elseif($user->pivot->roleIn=="Observer")
                                    array_push($disabled_observerArr,$user->id);
                            }
                }
            }
            $roomsArr=[];
            foreach ($course->rooms as $room) {
                if($rotation->id == $room->pivot->rotation_id)
                    array_push($roomsArr,$room->pivot->room_id);
            }
            $roomsArr=array_unique($roomsArr);

            //calc disabled_rooms
            foreach (Course::with('users')
            ->whereHas('users', function($query) use($date){
            $query->where('date',$date);
                })->get() as $courseN) {
                if($courseN->id == $course->id)
                    continue;
                foreach ($courseN->rooms as $room) {
                    if($rotation->id == $room->pivot->rotation_id)
                        if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
                        || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                             array_push($disabled_rooms,$room->id);
                        }
                }
            }
            $disabled_rooms=array_unique($disabled_rooms);
        //calc common_room
        foreach ($course->rooms as $room)
            if($rotation->id == $room->pivot->rotation_id)
                if(in_array($room->id,$disabled_rooms) && in_array($room->id,$roomsArr))
                        array_push($common_rooms,$room->id);
        $common_rooms=array_unique($common_rooms);

        //the same code privous for store observers and secertaries and roomheads for each room
        $roomHeadArr=[];
        $secertaryArr=[];
        $observerArr=[];
        $room_Distinct=[];
        $users_in_rooms=[];
        foreach ($course->rooms as $room) {
        if(! in_array($room->id,$common_rooms)){//for does not appear common rooms cause we will put the common rooms on the array users_commom_courses
            $secertaryArr=[];
            $roomHeadArr=[];
            $observerArr=[];
            array_push($room_Distinct,$room->id);
            foreach ($room->users as $user) {
                if($rotation->id == $user->pivot->rotation_id)
                    if($user->pivot->course_id==$course->id){
                        if($user->pivot->roleIn=="Secertary"){
                            array_push($secertaryArr,$user->pivot->user_id);
                        }elseif($user->pivot->roleIn=="Room-Head"){
                            array_push($roomHeadArr,$user->pivot->user_id);
                        }else{
                            array_push($observerArr,$user->pivot->user_id);
                        }
                    }
                }
            $users_in_rooms[$room->id]['roomHeads']=$roomHeadArr;
            $users_in_rooms[$room->id]['secertaries']=$secertaryArr;
            $users_in_rooms[$room->id]['observers']=$observerArr;
        }
        }
        foreach (Room::all() as $roomN) {
            if(! in_array($roomN->id,$room_Distinct)){
                $users_in_rooms[$roomN->id]['roomHeads']=[];
                $users_in_rooms[$roomN->id]['secertaries']=[];
                $users_in_rooms[$roomN->id]['observers']=[];
            }
        }
            $all_common_courses=[];
            //calc courses that causes common room
            foreach (Course::with('users')
            ->whereHas('users', function($query) use($date,$rotation){$query->where('date',$date)->where('rotation_id',$rotation->id);})->get() as $courseN) {
                //if($courseN->id == $course->id) continue;
                foreach ($courseN->rooms as $room) {
                    if($rotation->id == $room->pivot->rotation_id){
                        if(!in_array($room->id,$common_rooms)) continue;
                        if( (($room->pivot->time >= gmdate('H:i',strtotime($time))) && ($room->pivot->time <= gmdate('H:i',strtotime($time)+strtotime($courseN->duration))))
                        || (($room->pivot->time <= gmdate('H:i',strtotime($time))) && ($room->pivot->time >= gmdate('H:i',strtotime($time)-strtotime($courseN->duration)))) )
                            array_push($all_common_courses,$courseN->course_name);
                    }
                }
            }
            $all_common_courses=array_unique($all_common_courses);


            //calc users_commom_courses
            $courses_common=Course::whereIn('course_name',$all_common_courses)->get();
            $users_commom_courses=[];
            $users_roomHeads_commom_courses=[];
            $users_secertaries_commom_courses=[];
            $users_observers_commom_courses=[];
            foreach ($courses_common as $courseQ) {
            $courseE=Course::find($courseQ->id);
            foreach ($courseE->users as $course_user) {
                if($rotation->id == $course_user->pivot->rotation_id)
                    if($course_user->pivot->roleIn=="Secertary"){
                        array_push($users_secertaries_commom_courses,$course_user->id);
                    }elseif($course_user->pivot->roleIn=="Room-Head"){
                        array_push($users_roomHeads_commom_courses,$course_user->id);
                    }else{
                        array_push($users_observers_commom_courses,$course_user->id);
                    }
            }
            $users_roomHeads_commom_courses=array_unique($users_roomHeads_commom_courses);
            $users_secertaries_commom_courses=array_unique($users_secertaries_commom_courses);
            $users_observers_commom_courses=array_unique($users_observers_commom_courses);
            $users_commom_courses['roomHeads']=$users_roomHeads_commom_courses;
            $users_commom_courses['secertaries']=$users_secertaries_commom_courses;
            $users_commom_courses['observers']=$users_observers_commom_courses;
            }
        }
        // else{
        //     dd("OMG");
        //     return;
        // }

        if(!$request->get('roomheads') && !$request->get('secertaries') && !$request->get('observers')){
            return redirect()->back()->with('detemine-users-in-room',"you already have'nt any selected user , Please select One user at least");
        }else{
                if(in_array($specific_room->id,$common_rooms)){//edit existing common rooms
                    foreach (Course::whereIn("course_name",$all_common_courses)->where('id','!=',$course->id)->get() as $courseT) {
                        foreach ($courseT->rooms as $roomp)
                            if($roomp->id == $specific_room->id && $rotation->id == $roomp->pivot->rotation_id){
                                $courseF=Course::find($courseT->id);
                                $courseF->rooms()->detach($roomp->id);
                                $courseF->users()->attach($request->get('roomheads'),['num_student_in_room'=>$roomp->pivot->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                                $courseF->users()->attach($request->get('secertaries'),['num_student_in_room'=>$roomp->pivot->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                                $courseF->users()->attach($request->get('observers'),['num_student_in_room'=>$roomp->pivot->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                            }
                    }
                    //for currnt course get the new number
                    foreach ($course->rooms as $roomp)
                        if($roomp->id == $specific_room->id && $rotation->id == $roomp->pivot->rotation_id){
                            $course->rooms()->detach($roomp->id);
                            $course->users()->attach($request->get('roomheads'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                            $course->users()->attach($request->get('secertaries'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                            $course->users()->attach($request->get('observers'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                        }
                }elseif(in_array($specific_room->id,$disabled_rooms)){//edit before it becomes common "Joining State"
                    $target_saved_courses=Course::with('rooms')->whereHas('rooms', function($query) use($date,$time,$rotation){$query->where('date',$date)->where('time',$time)->where('rotation_id',$rotation->id);})->get();
                     foreach ($target_saved_courses as $courseV) {
                            foreach ($courseV->rooms as $roomp) {
                                if($roomp->id == $specific_room->id && $rotation->id == $roomp->pivot->rotation_id){
                                    $courseF=Course::find($courseV->id);
                                    $courseF->rooms()->detach($roomp->id);
                                    $courseF->users()->attach($request->get('roomheads'),['num_student_in_room'=>$roomp->pivot->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                                    $courseF->users()->attach($request->get('secertaries'),['num_student_in_room'=>$roomp->pivot->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                                    $courseF->users()->attach($request->get('observers'),['num_student_in_room'=>$roomp->pivot->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                                }
                            }
                     }
                    //insert currnt course becouse it does not exist in DB
                    $course->users()->attach($request->get('roomheads'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                    $course->users()->attach($request->get('secertaries'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                    $course->users()->attach($request->get('observers'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                    array_push($common_rooms,$specific_room->id);$disabled_rooms=array_diff($disabled_rooms, array($specific_room->id));//dd($common_rooms,$disabled_rooms);
                }else{//new room
                        $exist_rooms_before=Course::with('rooms')->whereHas('rooms', function($query) use($date,$time,$specific_room,$course,$rotation){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id)->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->get();
                        $target_saved_courses=Course::with('rooms')->whereHas('rooms', function($query) use($date,$time,$rotation){$query->where('date',$date)->where('time',$time)->where('rotation_id',$rotation->id);})->get();
                        if(count($exist_rooms_before) != 0){//dd("ali");
                            foreach ($target_saved_courses as $courseV) {
                                foreach ($courseV->rooms as $roomp) //for edit the users in the new room after added
                                    if($roomp->id == $specific_room->id && $rotation->id == $roomp->pivot->rotation_id){
                                        $courseF=Course::find($courseV->id);
                                        $rotation->courses()->detach($courseF->id);
                                        $courseF->users()->attach($request->get('roomheads'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                                        $courseF->users()->attach($request->get('secertaries'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                                        $courseF->users()->attach($request->get('observers'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                                    }
                            }
                        }else{//store for edit the users in the first insertion without editing
                            $course->users()->attach($request->get('roomheads'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                            $course->users()->attach($request->get('secertaries'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                            $course->users()->attach($request->get('observers'),['num_student_in_room'=>$request->num_student_in_room,'room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                        }
                }
        }

        return redirect("/rotations/$rotation->id/course/$course->id/edit")->with('update-course-room','Room '.$specific_room->room_name.' in Course '.$course->course_name.' updated successfully')->with(['disabled_rooms'=>$disabled_rooms,'common_rooms'=>$common_rooms]);
    }

    public function show(Rotation $rotation, Course $course)
    {
        return view('courses.show',compact('course'));
    }

    public function edit(Rotation $rotation, Course $course)
    {
        //calculate disabled_rooms
        $roomsArr=[];
        foreach ($course->rooms as $room) {
            if($room->pivot->rotation_id == $rotation->id)
                array_push($roomsArr,$room->pivot->room_id);
        }
        
        //calculate disabled_rooms
        $disabled_rooms=[];
        $courses_common_rooms=[];
        $joining_rooms=[];
        $accual_common_rooms=[];
        $disabled_common_rooms_send=[];
        if(count($course->users->toArray())){
                $date=null;
                $time=null;
                foreach ($course->rotations as $rot) {
                    if($rot->pivot->rotation_id == $rotation->id){
                        $date = $course->users[0]->pivot->date;
                        $time = $course->users[0]->pivot->time;
                        break;
                    }
                }
                foreach (Course::with('users')->whereHas('users', function($query) use($date,$rotation){ $query->where('date',$date)->where('rotation_id',$rotation->id);})->get() as $courseN) {
                    if($courseN->id == $course->id) continue;
                    //dd($courseN->rooms);
                    foreach ($courseN->rooms as $room) {
                        if($rotation->id == $room->pivot->rotation_id)
                            if( (($time < $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration)) > $room->pivot->time ))
                            || (($time >  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) > $time)) ){
                                    array_push($disabled_rooms,$room->id);
                                }elseif(($time == $room->pivot->time) && ! in_array($room->id,$roomsArr)){
                                    array_push($joining_rooms,$room->id);
                                    array_push($disabled_rooms,$room->id);
                            }
                    }
                }
                //calc courses that causes common room
                foreach (Course::with('users')->whereHas('users', function($query) use($date,$rotation){$query->where('date',$date)->where('rotation_id',$rotation->id);})->get() as $courseN) {
                    if($courseN->id == $course->id) continue;
                    foreach ($courseN->rooms as $room) {
                        if($rotation->id == $room->pivot->rotation_id)
                            if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
                            || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                                    array_push($courses_common_rooms,$courseN->course_name);
                                }
                    }
                }
                $courses_common_rooms=array_unique($courses_common_rooms);

                //calc accual_common_rooms
                
                $courses_common_with_this_room=Course::with('rooms')->whereHas('rooms', function($query) use($course,$rotation){$query->where('date',$course->rooms[0]->pivot->date)->where('time',$course->rooms[0]->pivot->time)->where('course_id','!=',$course->id)->where('rotation_id',$rotation->id);})->get();
                    foreach ($courses_common_with_this_room as $course_common){
                        foreach ($course_common->rooms as $roomY) {
                            if($rotation->id == $roomY->pivot->rotation_id)
                                if(!in_array($roomY->id,$disabled_rooms))
                                        array_push($accual_common_rooms,$roomY->id);
                        }
                    }
                //calc rooms_single_in_course
                $rooms_single_in_course=[];
                $courses_common_with_this_room=Course::with('rooms')->whereHas('rooms', function($query) use($course,$rotation){$query->where('date',$course->rooms[0]->pivot->date)->where('time',$course->rooms[0]->pivot->time)->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->get();
                foreach ($courses_common_with_this_room as $single_course_common){
                    foreach ($single_course_common->rooms as $roomY) {
                        if($rotation->id == $roomY->pivot->rotation_id)
                            if(!in_array($roomY->id,$disabled_rooms) && !in_array($roomY->id,$accual_common_rooms))
                                    array_push($rooms_single_in_course,$roomY->id);
                    }
                }

                //check if there is common rom between roomsArr and disabled_rooms
                $is_there=0;
                foreach ($disabled_rooms as $disabled_common) {
                    if(in_array($disabled_common,$roomsArr)){
                            $is_there=1;
                            break;
                        }
                }
                //clear each common room common with $disabled_rooms
                
                if($is_there){
                    $disabled_rooms_accual=[];
                    $mssg_unchecked_spesific_room='';
                    foreach ($disabled_rooms as $co_dis_room) {
                        if(!in_array($co_dis_room,$roomsArr))
                            array_push($disabled_rooms_accual,$co_dis_room);
                        else
                            array_push($disabled_common_rooms_send,$co_dis_room);
                    }
                    $disabled_rooms=array_unique($disabled_rooms_accual);
                }
        }

            //calc number students in this course
            $number_students_in_this_course=0;$arr=[];
            foreach ($course->rooms as $key => $room) {
                if(!in_array($room->id,$arr)){
                    array_push($arr,$room->id);
                    $number_students_in_this_course+=$room->pivot->num_student_in_room;
                }
        }

        return view('courses.edit', compact('rotation','course','roomsArr','disabled_rooms','courses_common_rooms','joining_rooms','accual_common_rooms','disabled_common_rooms_send','roomsArr','number_students_in_this_course'));
    }
    public function update(Request $request, Rotation $rotation, Course $course)
    {
            $course->update($request->only('course_name','studing_year','semester','duration','students_number','faculty_id'));
            //when enabled a checkbox for specific room
            $roomHeadArr=[];
            $secertaryArr=[];
            $observerArr=[];
            $room_Distinct=[];
            $users_in_rooms=[];
            foreach ($course->rooms as $room) {
                if($rotation->id == $room->pivot->rotation_id){
                    $secertaryArr=[];
                    $roomHeadArr=[];
                    $observerArr=[];
                    array_push($room_Distinct,$room->id);
                    foreach ($room->users as $user) {
                        if($rotation->id == $user->pivot->rotation_id){
                            if($user->pivot->course_id==$course->id){
                                if($user->pivot->roleIn=="Secertary"){
                                    array_push($secertaryArr,$user->pivot->user_id);
                                }elseif($user->pivot->roleIn=="Room-Head"){
                                    array_push($roomHeadArr,$user->pivot->user_id);
                                }else{
                                    array_push($observerArr,$user->pivot->user_id);
                                }
                            }
                        }
                    }
                    $users_in_rooms[$room->id]['roomHeads']=$roomHeadArr;
                    $users_in_rooms[$room->id]['secertaries']=$secertaryArr;
                    $users_in_rooms[$room->id]['observers']=$observerArr;
                }
            }

            foreach (Room::all() as $roomN) {
                if(! in_array($roomN->id,$room_Distinct)){
                    $users_in_rooms[$roomN->id]['roomHeads']=[];
                    $users_in_rooms[$roomN->id]['secertaries']=[];
                    $users_in_rooms[$roomN->id]['observers']=[];
                }
            }
            //dd($users_in_rooms);


        //copy from edit
                //calculate disabled_rooms
                $roomsArr=[];
                foreach ($course->rooms as $room) {
                    array_push($roomsArr,$room->pivot->room_id);
                }
                //calculate disabled_rooms
                $disabled_rooms=[];
                $courses_common_rooms=[];
                $joining_rooms=[];
                if(count($course->users->toArray())){
                    $date = $course->users[0]->pivot->date;
                    $time = $course->users[0]->pivot->time;
                    foreach (Course::with('users')
                    ->whereHas('users', function($query) use($date,$rotation){
                    $query->where('date',$date)->where('rotation_id',$rotation->id);
                        })->get() as $courseN) {
                        if($courseN->id == $course->id)
                            continue;
                        foreach ($courseN->rooms as $room) {
                            if($room->pivot->rotation_id == $rotation->id)
                                if( (($time < $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration)) > $room->pivot->time ))
                                || (($time >  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) > $time)) ){
                                        array_push($disabled_rooms,$room->id);
                                    }elseif(($time == $room->pivot->time) && ! in_array($room->id,$roomsArr)){
                                        array_push($joining_rooms,$room->id);
                                        array_push($disabled_rooms,$room->id);
                                }
                        }
                    }
                    //calc courses that causes common room
                    foreach (Course::with('users')->whereHas('users', function($query) use($date,$rotation){$query->where('date',$date)->where('rotation_id',$rotation->id);})->get() as $courseN) {
                        if($courseN->id == $course->id) continue;
                        foreach ($courseN->rooms as $room) {
                            if($room->pivot->rotation_id == $rotation->id)
                                if( (($time < $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>$room->pivot->time ))
                                || (($time >  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) > $time)) ){
                                        array_push($courses_common_rooms,$courseN->course_name);
                                    }
                        }
                    }
                    $courses_common_rooms=array_unique($courses_common_rooms);

                //calc accual_common_rooms
                $accual_common_rooms=[];
                $courses_common_with_this_room=Course::with('rooms')->whereHas('rooms', function($query) use($course,$rotation){$query->where('date',$course->rooms[0]->pivot->date)->where('time',$course->rooms[0]->pivot->time)->where('course_id','!=',$course->id)->where('rotation_id',$rotation->id);})->get();
                    foreach ($courses_common_with_this_room as $course_common){
                        foreach ($course_common->rooms as $roomY) {
                            if($roomY->pivot->rotation_id == $rotation->id)
                                if($roomY->pivot->rotation_id == $rotation->id)
                                    if(!in_array($roomY->id,$disabled_rooms))
                                        array_push($accual_common_rooms,$roomY->id);
                        }
                    }
                //calc rooms_single_in_course
                $rooms_single_in_course=[];
                $courses_common_with_this_room=Course::with('rooms')->whereHas('rooms', function($query) use($course,$rotation){$query->where('date',$course->rooms[0]->pivot->date)->where('time',$course->rooms[0]->pivot->time)->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->get();
                foreach ($courses_common_with_this_room as $single_course_common){
                    foreach ($single_course_common->rooms as $roomY) {
                        if($roomY->pivot->rotation_id == $rotation->id)
                            if(!in_array($roomY->id,$disabled_rooms) && !in_array($roomY->id,$accual_common_rooms))
                                array_push($rooms_single_in_course,$roomY->id);
                    }
                }

                //check if there is common rom between roomsArr and disabled_rooms
                $is_there=0;
                foreach ($disabled_rooms as $disabled_common) {
                    if(in_array($disabled_common,$roomsArr)){
                            $is_there=1;
                            break;
                        }
                }

                if($request->rooms);
                //clear each common room common with $disabled_rooms
                $disabled_common_rooms_send=[];
                if($is_there){
                    $disabled_rooms_accual=[];
                    $mssg_unchecked_spesific_room='';
                    foreach ($disabled_rooms as $co_dis_room) {
                        if(!in_array($co_dis_room,$roomsArr))
                            array_push($disabled_rooms_accual,$co_dis_room);
                        else
                        array_push($disabled_common_rooms_send,$co_dis_room);
                    }
                    $disabled_rooms=array_unique($disabled_rooms_accual);
                }
                $disabled_common_rooms_send=array_unique($disabled_common_rooms_send);

                $rooms_filtered=[];
                if($request->rooms)
                foreach ($request->rooms as $room_id_req) 
                    if(!in_array($room_id_req, $disabled_common_rooms_send))
                        array_push($rooms_filtered, (int)$room_id_req);
                    elseif(in_array($room_id_req, $disabled_common_rooms_send))
                        return redirect()->back()->with('disabled_rooms',"!! ");
        }


        //copy from edit

        //fetch num_student_in_room from DB
        $rooms_assoc_filtered_with_number_users=[];
        foreach ($rooms_filtered as $room_filtered) {
            $num_student_in_room=Room::with('courses')->whereHas('courses',function($query) use($room_filtered,$course,$rotation) {
                $query->
                where('date',$course->users[0]->pivot->date)->
                where('time',$course->users[0]->pivot->time)->
                where('course_id',$course->id)->
                where('rotation_id',$rotation->id);})->
                where('id',$room_filtered)->first();
                //dd($num_student_in_room);
                if($num_student_in_room)
                foreach ($num_student_in_room->users as $rr) {
                    if($rr->pivot->rotation_id == $rotation->id)
                        if($rr->pivot->course_id == $course->id)
                            $rooms_assoc_filtered_with_number_users[$room_filtered]=$rr->pivot->num_student_in_room;
                }
        }
        //dd($rooms_assoc_filtered_with_number_users,$rooms_filtered,$num_student_in_room->users[0]->pivot);   
             if($rooms_filtered){
                 $num_rooms_empty=0;
                 foreach ($rooms_filtered as $roomD) {//verify if the room's selected in not empty
                     if (count($users_in_rooms[$roomD]['roomHeads']) || count($users_in_rooms[$roomD]['secertaries']) || $users_in_rooms[$roomD]['observers'])
                         $num_rooms_empty=++$num_rooms_empty;
                 }
                 //dd($rooms_filtered);
                 if($num_rooms_empty){
                     for ($i=0; $i < $course->users->count() ; $i++)
                         $course->users[$i]->courses()->detach($course);
                     foreach ($rooms_assoc_filtered_with_number_users as $roomD=>$roomD_number_users_taken) {
                         $course->users()->attach($users_in_rooms[$roomD]['roomHeads'],['room_id'=>$roomD,'num_student_in_room'=> $roomD_number_users_taken,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                         $course->users()->attach($users_in_rooms[$roomD]['secertaries'],['room_id'=>$roomD,'num_student_in_room'=> $roomD_number_users_taken ,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                         $course->users()->attach($users_in_rooms[$roomD]['observers'],['room_id'=>$roomD,'num_student_in_room'=> $roomD_number_users_taken,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                        }
                     return redirect("/rotations/$rotation->id/show")->with('user-update','Course update successfully');
                 }else
                     return redirect()->back()->with('detemine-rooms',"The rooms that you have already selected have not any user , Please select One user at least in any room");
         }else{
            return redirect()->back()->with('detemine-rooms',"Please select One room at least");


        }
    }

}
