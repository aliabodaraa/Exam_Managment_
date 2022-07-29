<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Room;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CoursesController extends Controller
{
    public function get_room_for_course(Course $course, Room $specific_room){


        $common_rooms=[];
            //dd($users_in_rooms);
        if(count($course->users->toArray())){
            //calc disabled_users
            $date = $course->users[0]->pivot->date;
            $time = $course->users[0]->pivot->time;
            $disabled_roomHeadArr=[];
            $disabled_secertaryArr=[];
            $disabled_observerArr=[];
            $roomsArr=[];
            foreach ($course->rooms as $room) {
                array_push($roomsArr,$room->pivot->room_id);
            }
            $roomsArr=array_unique($roomsArr);

            //calc disabled_rooms
            $disabled_rooms=[];
            $date = $course->users[0]->pivot->date;
            $time = $course->users[0]->pivot->time;
            foreach (Course::with('users')
            ->whereHas('users', function($query) use($date){
            $query->where('date',$date);
                })->get() as $courseN) {
                if($courseN->id == $course->id)
                    continue;
                        foreach ($courseN->rooms as $room) {
                            if($room->pivot->time >= "00:00:00" && $room->pivot->time <= "00:59:59")
                                $room->pivot->time=gmdate('H:i:s',strtotime($room->pivot->time)+9201600);
                            if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
                            || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                        array_push($disabled_rooms,$room->id);
                    }
                }
            }
            $disabled_rooms=array_unique($disabled_rooms);
            //dd($disabled_rooms);
        //calc common_room
        foreach ($course->rooms as $room)
            if(in_Array($room->id,$disabled_rooms) && in_Array($room->id,$roomsArr))
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
            ->whereHas('users', function($query) use($date){$query->where('date',$date);})->get() as $courseN) {
                //if($courseN->id == $course->id) continue;
                if($time>="00:00:00" && $time <="00:59:59")
                $time=gmdate('H:i:s',strtotime($time)+9201600);
                foreach ($courseN->rooms as $room) {
                    if(!in_array($room->id,$common_rooms)) continue;
                    if($room->pivot->time >= "00:00:00" && $room->pivot->time <="00:59:59")
                        $room->pivot->time=gmdate('H:i:s',strtotime($room->pivot->time)+9201600);
                    if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
                    || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) )
                        array_push($all_common_courses,$courseN->course_name);
                }
            }
            $all_common_courses=array_unique($all_common_courses);

//

foreach (Course::with('users')
->whereHas('users', function($query) use($date){
$query->where('date',$date);
    })->get() as $courseN) {
    // if($courseN->id == $course->id)
    //     continue;
    if($time>="00:00:00" && $time <="00:59:59")
    $time=gmdate('H:i:s',strtotime($time)+9201600);
    foreach ($courseN->users as $user) {
            if($user->pivot->time >= "00:00:00" && $user->pivot->time <="00:59:59")
                $user->pivot->time=gmdate('H:i:s',strtotime($user->pivot->time)+9201600);
            if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
            || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
            if($user->pivot->roleIn=="Room-Head")
                array_push($disabled_roomHeadArr,$user->id);
            elseif($user->pivot->roleIn=="Secertary")
                array_push($disabled_secertaryArr,$user->id);
            elseif($user->pivot->roleIn=="Observer")
                array_push($disabled_observerArr,$user->id);
        }
    }
}
//dd(array_unique($disabled_roomHeadArr));
            //calc users_commom_courses
            $courses_common=Course::whereIn('course_name',$all_common_courses)->get();
            $users_commom_courses=[];
            $users_roomHeads_commom_courses=[];
            $users_secertaries_commom_courses=[];
            $users_observers_commom_courses=[];
            foreach ($courses_common as $courseQ) {
            $courseE=Course::find($courseQ->id);
            foreach ($courseE->users as $course_user) {
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
        //dd($users_commom_courses);
        //dd($disabled_roomHeadArr,$disabled_secertaryArr,$disabled_observerArr);

        $users_will_in_common=User::with('rooms','courses')
        ->whereHas('rooms', function($query) use($date,$time,$specific_room){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id);})->get();
        $users_will_in_common_ids=[];
        foreach ($users_will_in_common as $userR) {
           array_push($users_will_in_common_ids,$userR->id);
        }
//dd($users_will_in_common->toArray()[1]['id']);
        //remove all rows that owns the course
        //dd($room_Distinct);
        //dd($request->get('roomheads'),$request->get('secertaries'),$request->get('observers'));
        return view('courses.edit_course_room',compact('course','specific_room','users_in_rooms','room_Distinct','disabled_rooms','users_will_in_common_ids'
        ,'disabled_secertaryArr','disabled_roomHeadArr','disabled_observerArr','common_rooms'
        ,'all_common_courses','users_commom_courses'));
    }

    public function customize_room_for_course(Request $request, Course $course, Room $specific_room){

        $common_rooms=[];
            //dd($users_in_rooms);
        if(count($course->users->toArray())){
            //calc disabled_users
            $date = $course->users[0]->pivot->date;
            $time = $course->users[0]->pivot->time;
            $disabled_roomHeadArr=[];
            $disabled_secertaryArr=[];
            $disabled_observerArr=[];
            foreach (Course::with('users')
            ->whereHas('users', function($query) use($date){
            $query->where('date',$date);
                })->get() as $courseN) {
                if($courseN->id == $course->id)
                    continue;
                foreach ($courseN->users as $user) {
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
                array_push($roomsArr,$room->pivot->room_id);
            }
            $roomsArr=array_unique($roomsArr);

            //calc disabled_rooms
            $disabled_rooms=[];
            $date = $course->users[0]->pivot->date;
            $time = $course->users[0]->pivot->time;
            foreach (Course::with('users')
            ->whereHas('users', function($query) use($date){
            $query->where('date',$date);
                })->get() as $courseN) {
                if($courseN->id == $course->id)
                    continue;
                        foreach ($courseN->rooms as $room) {
                            if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
                            || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                        array_push($disabled_rooms,$room->id);
                    }
                }
            }
            $disabled_rooms=array_unique($disabled_rooms);
        //calc common_room
        foreach ($course->rooms as $room)
            if(in_Array($room->id,$disabled_rooms) && in_Array($room->id,$roomsArr))
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
            ->whereHas('users', function($query) use($date){$query->where('date',$date);})->get() as $courseN) {
                //if($courseN->id == $course->id) continue;
                foreach ($courseN->rooms as $room) {
                    if(!in_array($room->id,$common_rooms)) continue;
                    if( (($room->pivot->time >= gmdate('H:i',strtotime($time))) && ($room->pivot->time <= gmdate('H:i',strtotime($time)+strtotime($courseN->duration))))
                    || (($room->pivot->time <= gmdate('H:i',strtotime($time))) && ($room->pivot->time >= gmdate('H:i',strtotime($time)-strtotime($courseN->duration)))) )
                        array_push($all_common_courses,$courseN->course_name);
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

        if(!$request->get('roomheads') && !$request->get('secertaries') && !$request->get('observers')){
            return redirect()->back()->with('detemine-users-in-room',"you already have'nt any selected user , Please select One user at least");

        }else{
        //if(!in_array($specific_room->id, $common_rooms)){

            // for ($i=0; $i < $course->users->count() ; $i++) {
            //     if( !in_array($course->users[$i]->pivot->room_id, $common_rooms))
            //         $course->users[$i]->courses()->detach($course);
            // }
            //dd($disabled_rooms);
          //  foreach (Room::all() as $roomD) {
if($specific_room->id == $specific_room->id && in_array($specific_room->id,$common_rooms)){//edit existing common rooms
                    //dd($roomD->id == $specific_room->id && in_array($roomD->id,$disabled_rooms));
                    //dd(1);
                    foreach (Course::whereIn("course_name",$all_common_courses)->get() as $courseT) {
                        foreach ($courseT->rooms as $roomp) {
                            if($roomp->id == $specific_room->id){
                                $courseF=Course::find($courseT->id);
                                $courseF->rooms()->detach($roomp->id);
                                $courseF->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                                $courseF->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                                $courseF->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                            }
                        }
                        //$ver=User::with('rooms')->whereHas('rooms', function($query) use($date,$time,$specific_room,$courseT){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id)->where('course_id',$courseT->id);})->get();
                        //dd($ver,$common_rooms);
                        }
                }elseif(in_array($specific_room->id,$disabled_rooms)){//edit before it becomes common when the button
                    //dd(2);
                    $target_saved_courses=Course::with('rooms')->whereHas('rooms', function($query) use($date,$time){$query->where('date',$date)->where('time',$time);})->get();
                     foreach ($target_saved_courses as $courseV) {
                            foreach ($courseV->rooms as $roomp) {
                                if($roomp->id == $specific_room->id){
                                    $courseF=Course::find($courseV->id);
                                    $courseF->rooms()->detach($roomp->id);
                                    $courseF->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                                    $courseF->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                                    $courseF->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                                }
                            }
                     }
                    //insert currnt course becouse it does not exist in DB
                    $course->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                    $course->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                    $course->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                    array_push($common_rooms,$specific_room->id);$disabled_rooms=array_diff($disabled_rooms, array($specific_room->id));//dd($common_rooms,$disabled_rooms);
                }else{//new room

                        $exist_rooms_before=Course::with('rooms')->whereHas('rooms', function($query) use($date,$time,$specific_room,$course){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id)->where('course_id',$course->id);})->get();
                        $target_saved_courses=Course::with('rooms')->whereHas('rooms', function($query) use($date,$time){$query->where('date',$date)->where('time',$time);})->get();
                        if(count($exist_rooms_before)!=0){
                            //dd(1);
                            foreach ($target_saved_courses as $courseV) {
                                foreach ($courseV->rooms as $roomp) {//for edit the users in the new room after added
                                    if($roomp->id == $specific_room->id){
                                        $courseF=Course::find($courseV->id);
                                        $courseF->rooms()->detach($roomp->id);
                                        $courseF->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                                        $courseF->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                                        $courseF->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                                    }
                                }
                            }
                        }else{//store for edit the users in the first insertion without editing
                           // dd(0);

                        $course->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                        $course->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                        $course->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                        }
                }
                // }else{
                //     $course->users()->attach($users_in_rooms[$roomD->id]['roomHeads'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                //     $course->users()->attach($users_in_rooms[$roomD->id]['secertaries'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                //     $course->users()->attach($users_in_rooms[$roomD->id]['observers'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                // }
           // }
        }
        // }elseif(in_array($specific_room->id, $common_rooms)){
        //     //dd($all_common_courses);
        //                 foreach (Course::whereIn("course_name",$all_common_courses)->get() as $courseT) {

        //                     $courseF=Course::find($courseT->id);
        //                     $courseF->users()->detach($users_commom_courses['roomHeads']);
        //                     $courseF->users()->detach($users_commom_courses['secertaries']);
        //                     $courseF->users()->detach($users_commom_courses['observers']);
        //                     $courseF->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
        //                     $courseF->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
        //                     $courseF->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
        //                     }
        //                     foreach (Room::all() as $roomD) {
        //                             $course->users()->attach($users_in_rooms[$roomD->id]['roomHeads'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
        //                             $course->users()->attach($users_in_rooms[$roomD->id]['secertaries'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
        //                             $course->users()->attach($users_in_rooms[$roomD->id]['observers'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
        //                     }
        //                 //dd("common");
        //             }
        //elseif(count(Course::with('rooms')->whereHas('rooms', function($query) use($date,$time,$specific_room){$query->where('date',$date)->where('time',$time)->where('room_id',$specific_room->id);})->get())){
        //     $users_will_in_common=User::with('rooms','courses')->whereHas('rooms', function($query) use($date,$time,$specific_room)//all users exists in this room and in this date and time
        //     {$query->where('date',$date)->where('time',$time)
        //      ->where('room_id',$specific_room->id);})->get();
        //     dd($course,Course::with('rooms')->whereHas('rooms', function($query) use($date,$time,$specific_room,$course)
        //     {$query->where('date',$date)->where('room_id',$specific_room->id)->where('course_id','!=',$course->id);})->get() );
        //      foreach (Course::with('rooms')->whereHas('rooms', function($query) use($date,$time,$specific_room)//all course exists in this room and in this date and timeexcept current that will add the users that selected to table
        //      {$query->where('date',$date)->where('time',$time)
        //       ->where('room_id',$specific_room->id);})->get() as $courseT) {
        //          $courseF=Course::find($courseT->id);
        //          foreach ($users_will_in_common as $user) {
        //              $courseF->users()->detach($user->id);
        //          }
        //          $courseF->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
        //          $courseF->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
        //          $courseF->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
        //          }//$request->get('roomheads') ,$request->get('secertaries') ,$request->get('observers')
        //          foreach ((Array)$request->get('roomheads') as $sel) {
        //              $course->users()->detach($sel);
        //          }
        //          foreach ((Array)$request->get('secertaries') as $sel) {
        //              $course->users()->detach($sel);
        //          }
        //          foreach ((Array)$request->get('observers') as $sel) {
        //              $course->users()->detach($sel);
        //          }
        //          $course->users()->attach($request->get('roomheads'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
        //          $course->users()->attach($request->get('secertaries'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
        //          $course->users()->attach($request->get('observers'),['room_id'=>$specific_room->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
        // }
        return redirect()->route('courses.edit',[$course->id,$specific_room->id])->with('update-course-room','Room '.$specific_room->room_name.' in Course '.$course->course_name.' updated successfully')->with(['disabled_rooms'=>$disabled_rooms,'common_rooms'=>$common_rooms]);
    }
    public function index()
    {
        return view('courses.index');
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
         $enterCourse=true;
         $selected_room_id = 0;
          $date=$request->date;
          $time=Carbon::parse($request->time, 'UTC')->isoFormat('h:m');

          //assign Room To the new Course
           foreach (Room::all() as $room) {
                 $is_available_room = true;
                    foreach ($room->users as $user) {
                        if(($user->pivot->date == $date) && (Carbon::parse($user->pivot->time, 'UTC')->isoFormat('h:m') == $time)){
                            $is_available_room = false;
                            break;
                        }
                        if(($user->pivot->date == $date) &&
                         (gmdate('H:i',strtotime($user->pivot->time) - strtotime($time)) > '22:00' ||
                          gmdate('H:i',strtotime($user->pivot->time) - strtotime($time)) < '02:00')){
                            $is_available_room = false;
                        }
                    }
                    if($is_available_room){
                        $selected_room_id = $room->id;
                        break;
                    }
            }
            if($selected_room_id == 0){
                $enterCourse=false;
                 return redirect()->back()
                 ->with('retryEntering',"all Room not available with this Date: ".$date .' and Time '.$time.' change them and Try Again');
            }
          //assign Room-Head To the Room for a new Course
          $selected_room_head_id = 0;
          foreach (User::all() as $user) {
            // if($user->hasRole('Room-Head')){
                $is_available_room_head = true;
                foreach ($user->rooms as $room) {
                    if(($room->pivot->date == $date) && (Carbon::parse($room->pivot->time, 'UTC')->isoFormat('h:m') == $time)){
                        $is_available_room_head = false;
                        break;
                    }
                    if(($room->pivot->date == $date) &&
                        (gmdate('H:i',strtotime($room->pivot->time) - strtotime($time)) > '22:00' ||
                        gmdate('H:i',strtotime($room->pivot->time) - strtotime($time)) < '02:00')){
                        $is_available_room_head = false;
                    }
                }
                if($is_available_room_head){
                    //$last_prev_room_time_taken = $room->rooms->last()->pivot->time;
                    $selected_room_head_id = $user->id;
                    break;
                }
         //   }
          }
          if($selected_room_head_id == 0){
                $enterCourse=false;
                return redirect()->back()
                ->with('retryEntering',"There is no Room-Head available Now: ".$date .' and Time '.$time.' change them and Try Again');
          }
          //assign Secertary To the Room for a new Course
          $selected_secertary_id = 0;
          foreach (User::all() as $user) {
            // if($user->hasRole('Secertary')){
                if($user->id == $selected_room_head_id )
                continue;
                $is_available_secertary = true;
                foreach ($user->rooms as $room) {
                    if(($room->pivot->date == $date) && (Carbon::parse($room->pivot->time, 'UTC')->isoFormat('h:m') == $time)){
                        $is_available_secertary = false;
                        break;
                    }
                    if(($room->pivot->date == $date) &&
                        (gmdate('H:i',strtotime($room->pivot->time) - strtotime($time)) > '22:00' ||
                        gmdate('H:i',strtotime($room->pivot->time) - strtotime($time)) < '02:00')){
                        $is_available_secertary = false;
                    }
                }
                if($is_available_secertary){
                    //$last_prev_room_time_taken = $room->rooms->last()->pivot->time;
                    $selected_secertary_id = $user->id;
                    break;
                }
        //    }
           }
          if($selected_secertary_id == 0){
                $enterCourse=false;
                return redirect()->back()
                ->with('retryEntering',"There is no Secertary available Now: ".$date .' and Time '.$time.' change them and Try Again');
          }
          //assign Observer To the Room for a new Course
          $selected_observer_id = 0;
          foreach (User::all() as $user) {
            // if($user->hasRole('Employee')){
                if($user->id == $selected_room_head_id || $user->id == $selected_secertary_id )
                continue;
                $is_available_observer = true;
                foreach ($user->rooms as $room) {
                    if(($room->pivot->date == $date) && (Carbon::parse($room->pivot->time, 'UTC')->isoFormat('h:m') == $time)){
                        $is_available_observer = false;
                        break;
                    }
                    if(($room->pivot->date == $date) &&
                        (gmdate('H:i',strtotime($room->pivot->time) - strtotime($time)) > '22:00' ||
                        gmdate('H:i',strtotime($room->pivot->time) - strtotime($time)) < '02:00')){
                        $is_available_observer = false;
                    }
                }
                if($is_available_observer){
                    //$last_prev_room_time_taken = $room->rooms->last()->pivot->time;
                    $selected_observer_id = $user->id;
                    break;
                }
            // }
          }
          if($selected_observer_id == 0){
                $enterCourse=false;
                return redirect()->back()
                ->with('retryEntering',"There is no Observer available Now: ".$date .' and Time '.$time.' change them and Try Again');
          }

          if($enterCourse){
                $this->validate($request,[
                    'course_name' => 'required|min:1|max:40|unique:courses,course_name',
                ],[
                    'course_name.unique' => 'the name of course already exist'
                ]);
                $course = Course::create(
                    [
                        'course_name'=> $request->course_name,
                        'studing_year'=> $request->studing_year,
                        'semester' => $request->semester,
                        'students_number' => $request->students_number,
                        'duration' => $request->duration
                    ]
                );
                //enter two courses in the same year , same date
                if(count(Course::with('users')
                ->whereHas('users', function($query) use($date){
                $query->where('date',$date);
                    })->where('studing_year',$course->studing_year)->get())>1 ){
                        $course->delete();
                        return redirect()->back()
                        ->with('retryEntering',"You çan't create Two courses in the smae year ,same date");
                    }
                    $course->users()->attach($selected_room_head_id,['room_id'=>$selected_room_id ,'date'=>$date,'time'=>$time,'roleIn'=>'Room-Head']);
                    $course->users()->attach($selected_secertary_id,['room_id'=>$selected_room_id ,'date'=>$date,'time'=>$time,'roleIn'=>'Secertary']);
                    $course->users()->attach($selected_observer_id,['room_id'=>$selected_room_id ,'date'=>$date,'time'=>$time,'roleIn'=>'Observer']);
                    return redirect()->route('courses.index')
                        ->with('message','You have successfully create a new course to the room Room'.$selected_room_id);
            }
    }

    public function show(Course $course)
    {
        return view('courses.show',compact('course'));
    }

    public function edit(Course $course)
    {
            //calculate disabled_rooms
            $roomsArr=[];
            foreach ($course->rooms as $room) {
                array_push($roomsArr,$room->pivot->room_id);
            }
                //calculate disabled_rooms
                $disabled_rooms=[];
                $common_rooms=[];
                $courses_common_rooms=[];
                $joining_rooms=[];
                if(count($course->users->toArray())){
                    $date = $course->users[0]->pivot->date;
                    $time = $course->users[0]->pivot->time;
                    foreach (Course::with('users')
                    ->whereHas('users', function($query) use($date){
                    $query->where('date',$date);
                        })->get() as $courseN) {
                        if($courseN->id == $course->id)
                            continue;
                        foreach ($courseN->rooms as $room) {
                            if( (($time < $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>$room->pivot->time ))
                            || (($time >  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) > $time)) ){
                                    array_push($disabled_rooms,$room->id);
                                }elseif(($time == $room->pivot->time) && ! in_array($room->id,$roomsArr)){
                                    array_push($joining_rooms,$room->id);
                                    array_push($disabled_rooms,$room->id);
                            }
                        }
                    }
                    //calc common_room
                    foreach ($course->rooms as $room)
                        if(in_Array($room->id,$disabled_rooms) && in_Array($room->id,$roomsArr))
                            array_push($common_rooms,$room->id);

                    //calc courses that causes common room
                    foreach (Course::with('users')->whereHas('users', function($query) use($date){$query->where('date',$date);})->get() as $courseN) {
                        if($courseN->id == $course->id) continue;
                        foreach ($courseN->rooms as $room) {
                            if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
                            || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                                    array_push($courses_common_rooms,$courseN->course_name);
                                }
                        }
                    }
                    $courses_common_rooms=array_unique($courses_common_rooms);

                //calc common_room
                $accual_common_rooms=[];
                $courses_common_with_this_room=Course::with('rooms')->whereHas('rooms', function($query) use($course,$room){$query->where('date',$course->rooms[0]->pivot->date)->where('time',$course->rooms[0]->pivot->time)->where('room_id',$room->id)->where('course_id','!=',$course->id);})->get();
                    foreach ($courses_common_with_this_room as $course_common){
                        foreach ($course_common->rooms as $roomY) {
                            if(!in_array($roomY->id,$disabled_rooms))
                            array_push($accual_common_rooms,$roomY->id);
                        }
                    }
            }
            //dd($disabled_rooms,$accual_common_rooms,$joining_rooms,$common_rooms);
        return view('courses.edit', compact('course','roomsArr','disabled_rooms','common_rooms','courses_common_rooms','joining_rooms','accual_common_rooms'));
    }

    public function update(Request $request, Course $course)
    {//update the following attributes : course_name, studing_year, semester, rooms[], date, time
            //   $course->users[0]->courses()->detach($course); //for selest form
            //   $course->users[1]->courses()->detach($course);
            //   $course->users[2]->courses()->detach($course);
            //   $course->users[0]->courses()->attach($course,['room_id'=>$request->room_id,'user_id'=>$request->observer_id ,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
            //   $course->users[1]->courses()->attach($course,['room_id'=>$request->room_id,'user_id'=>$request->secertary_id ,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
            //   $course->users[2]->courses()->attach($course,['room_id'=>$request->room_id,'user_id'=>$request->roomHead_id ,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
            //   $course->update($request->all());
            //dd(array_keys($request->get('observers')));


            // foreach ($course->users as $user) {
            //     $course->users()->updateExistingPivot($user,['date'=>$request->date,'time'=>$request->time]);
            // }

            //when disabled a checkbox for specific room
            // $users_in_room=[];
            // if(!$request->rooms)
            //     foreach ($course->rooms as $room) {
            //         if(!in_array($room->id,$request->rooms)){
            //             foreach ($room->users as $user) {
            //                 if($user->pivot->course_id==$course->id)
            //                 array_push($users_in_room,$user->id);
            //                 }
            //             $room->users()->detach($users_in_room,['date'=>$request->date,'time'=>$request->time]);
            //         }
            //     }
            $course->update($request->only('course_name','studing_year','semester','duration','students_number'));
            //when enabled a checkbox for specific room
            $roomHeadArr=[];
            $secertaryArr=[];
            $observerArr=[];
            $room_Distinct=[];
            $users_in_rooms=[];
            foreach ($course->rooms as $room) {
                $secertaryArr=[];
                $roomHeadArr=[];
                $observerArr=[];
                array_push($room_Distinct,$room->id);
                foreach ($room->users as $user) {
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
            foreach (Room::all() as $roomN) {
                if(! in_array($roomN->id,$room_Distinct)){
                    $users_in_rooms[$roomN->id]['roomHeads']=[];
                    $users_in_rooms[$roomN->id]['secertaries']=[];
                    $users_in_rooms[$roomN->id]['observers']=[];
                }
            }
            //dd($users_in_rooms);
            //calculate rooms_reservation
            $roomsArr=[];
            foreach ($course->rooms as $room) {
                array_push($roomsArr,$room->pivot->room_id);
            }
            $roomsArr=array_unique($roomsArr);

            $disabled_rooms=[];
            $common_rooms=[];
            $courses_common_rooms=[];
            if(count($course->users->toArray())){
                    //calc disabled_rooms
                    $date = $course->users[0]->pivot->date;
                    $time = $course->users[0]->pivot->time;
                    foreach (Course::with('users')
                    ->whereHas('users', function($query) use($date){
                    $query->where('date',$date);
                        })->get() as $courseN) {
                        if($courseN->id == $course->id)
                            continue;
                        foreach ($courseN->rooms as $room) {
                            if( (($time <= $room->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($course->duration))>=$room->pivot->time ))
                            || (($time >=  $room->pivot->time) && (gmdate('H:i:s',strtotime($room->pivot->time)+strtotime($courseN->duration)) >= $time)) ){
                                array_push($disabled_rooms,$room->id);
                            }
                        }
                    }

                    //calc common_room
                    foreach ($course->rooms as $room)
                        if(in_Array($room->id,$disabled_rooms) && in_Array($room->id,$roomsArr))
                            array_push($common_rooms,$room->id);
                    $common_rooms = array_unique($common_rooms);

                    //calc courses that causes common room
                    foreach (Course::with('users')
                    ->whereHas('users', function($query) use($date){$query->where('date',$date);})->get() as $courseN) {
                        if($courseN->id == $course->id) continue;
                        foreach ($courseN->rooms as $room) {
                            if(!in_array($room->id,$common_rooms)) continue;
                            if( (($room->pivot->time >=  gmdate('H:i',strtotime($time))) && ($room->pivot->time <= gmdate('H:i',strtotime($time)+strtotime($courseN->duration))))
                            || (($room->pivot->time <=  gmdate('H:i',strtotime($time))) && ($room->pivot->time >= gmdate('H:i',strtotime($time)-strtotime($courseN->duration)))) )
                                array_push($courses_common_rooms,$courseN->course_name);
                        }
                    }
                    $courses_common_rooms=array_unique($courses_common_rooms);
                }
//dd($courses_common_rooms,$common_rooms);


             if($request->rooms){
                 //dd(3);
                 $num_rooms_empty=0;
                 foreach ($request->rooms as $roomD) {//verify if the room's selected in not empty
                     if (count($users_in_rooms[$roomD]['roomHeads']) || count($users_in_rooms[$roomD]['secertaries']) || $users_in_rooms[$roomD]['observers'])
                         $num_rooms_empty=++$num_rooms_empty;
                 }
                 //dd($num_rooms_empty);
                 if($num_rooms_empty){
                     for ($i=0; $i < $course->users->count() ; $i++)
                         $course->users[$i]->courses()->detach($course);
                     foreach ($request->rooms as $roomD) {
                         $course->users()->attach($users_in_rooms[$roomD]['roomHeads'],['room_id'=>$roomD,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                         $course->users()->attach($users_in_rooms[$roomD]['secertaries'],['room_id'=>$roomD,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                         $course->users()->attach($users_in_rooms[$roomD]['observers'],['room_id'=>$roomD,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                        }
                     return redirect()->route('courses.index')->with('user-update','Course update successfully');
                 }else
                     return redirect()->back()->with('detemine-rooms',"The rooms that you have already selected have not any user , Please select One user at least in any room");
         }else{
         return redirect()->back()->with('detemine-rooms',"Please select One room at least");


    }
}

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('user-delete','Course deleted successfully.');
    }
}


//use in course.index
// <?php $courses_name=App\Models\Course::where('id',$room->pivot->course_id)->pluck('course_name')?>
