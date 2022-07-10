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
    //     $roomHeadArr=[];
    //     $disabled_roomHeadArr=[];
    //     $secertaryArr=[];
    //     $disabled_secertaryArr=[];
    //     $observerArr=[];
    //     $disabled_observerArr=[];
    //     $roomsArr=[];
    //     $disabled_roomsArr=[];
    //     foreach ($course->users as $user) {
    //         if($user->pivot->roleIn=="Secertary"){
    //             array_push($secertaryArr,$user->id);
    //         }elseif($user->pivot->roleIn=="Room-Head"){
    //             array_push($roomHeadArr,$user->id);
    //         }else{
    //             array_push($observerArr,$user->id);
    //         }
    //         //array_push($roomsArr,$user->pivot->room_id);
    //     }
    //    // dd($roomsArr);





       $roomHeadArr=[];
       $disabled_roomHeadArr=[];
       $secertaryArr=[];
       $disabled_secertaryArr=[];
       $observerArr=[];
       $disabled_observerArr=[];
       $roomsArr=[];
       $disabled_roomsArr=[];
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
       //dd($a);
       //dd(array_unique($room_Distinct),$users_in_rooms);






        $date = $course->users[0]->pivot->date;
        $time = $course->users[0]->pivot->time;
        foreach (Course::with('users')
        ->whereHas('users', function($query) use($date){
        $query->where('date',$date);
            })->get() as $courseN) {
            if($courseN->id == $course->id)
                continue;
            foreach ($courseN->users as $user) {
                if( (($user->pivot->time >=  gmdate('H:i',strtotime($time))) && ($user->pivot->time <= gmdate('H:i',strtotime($time)+strtotime("02:00"))))
                || (($user->pivot->time <=  gmdate('H:i',strtotime($time))) && ($user->pivot->time >= gmdate('H:i',strtotime($time)-strtotime("02:00")))) ){
                    if($user->pivot->roleIn=="Room-Head")
                        array_push($disabled_roomHeadArr,$user->id);
                    elseif($user->pivot->roleIn=="Secertary")
                        array_push($disabled_secertaryArr,$user->id);
                    elseif($user->pivot->roleIn=="Observer")
                        array_push($disabled_observerArr,$user->id);
                }
            }
        }
        // print_r($disabled_roomHeadArr);
        // print_r($disabled_secertaryArr);
        // print_r($disabled_observerArr);
        //dd(array_diff($disabled_observerArr,$disabled_secertaryArr));
        return view('courses.edit_course_room',compact('course','specific_room','users_in_rooms','room_Distinct','disabled_secertaryArr','disabled_roomHeadArr','disabled_observerArr'));
    }

    public function customize_room_for_course(Request $request, Course $course, Room $specific_room){
        //the same code privous for store observers and secertaries and roomheads for each room
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
        //remove all rows that owns the course
        //dd($room_Distinct);
        for ($i=0; $i < $course->users->count() ; $i++) {
            $course->users[$i]->courses()->detach($course);
        }
        foreach (Room::all() as $roomD) {
            if($roomD->id == $specific_room->id && (!in_array($specific_room->id,array_unique($room_Distinct)) || in_array($specific_room->id,array_unique($room_Distinct)))){
                $course->users()->attach($request->get('roomheads'),['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                $course->users()->attach($request->get('secertaries'),['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                $course->users()->attach($request->get('observers'),['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
            }else{
                $course->users()->attach($users_in_rooms[$roomD->id]['roomHeads'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                $course->users()->attach($users_in_rooms[$roomD->id]['secertaries'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                $course->users()->attach($users_in_rooms[$roomD->id]['observers'],['room_id'=>$roomD->id,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
            }
        }
        return redirect()->route('courses.edit',[$course->id,$specific_room->id])->with('update-course-room','Room '.$specific_room->room_name.' in Course '.$course->course_name.' updated successfully');
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
                    'course_name' => 'required|min:1|max:20|unique:courses,course_name',
                ],[
                    'course_name.unique' => 'the name of course already exist'
                ]);
                $course = Course::create(
                    [
                        'course_name'=> $request->course_name,
                        'studing_year'=> $request->studing_year,
                        'semester' => $request->semester,
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
        $roomsArr=[];
        $disabled_roomsArr=[];
        foreach ($course->rooms as $room) {
            array_push($roomsArr,$room->pivot->room_id);
        }
       // dd($roomsArr);
      if(count($course->rooms)){
         $date = $course->rooms[0]->pivot->date;
        $time = $course->rooms[0]->pivot->time;
        foreach (Course::with('rooms')
        ->whereHas('rooms', function($query) use($date){
        $query->where('date',$date);
            })->get() as $courseN) {
               if($courseN->id == $course->id)
                        continue;
                    foreach ($courseN->rooms as $room) {
                        if( (($room->pivot->time >=  gmdate('H:i',strtotime($time))) && ($room->pivot->time <= gmdate('H:i',strtotime($time)+strtotime("02:00"))))
                        || (($room->pivot->time <=  gmdate('H:i',strtotime($time))) && ($room->pivot->time >= gmdate('H:i',strtotime($time)-strtotime("02:00")))) ){
                                array_push($disabled_roomsArr,$room->id);
                    }
                }
                // print_r($roomsArr);
                // print_r($disabled_roomsArr);
            }
        }
        return view('courses.edit', compact('course','roomsArr','disabled_roomsArr'));
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

            $course->update($request->only('course_name','studing_year','semester'));

            foreach ($course->users as $user) {
                $course->users()->updateExistingPivot($user,['date'=>$request->date,'time'=>$request->time]);
            }
            //when disabled a checkbox for specific room
            $users_in_room=[];
            foreach ($course->rooms as $room) {
                if($request->rooms && !in_array($room->id,$request->rooms)){
                    foreach ($room->users as $user) {
                        array_push($users_in_room,$user->id);
                        }
                    $room->users()->detach($users_in_room,['date'=>$request->date,'time'=>$request->time]);
                }
            }
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
                if( (($room->pivot->time >=  gmdate('H:i',strtotime($time))) && ($room->pivot->time <= gmdate('H:i',strtotime($time)+strtotime("02:00"))))
                || (($room->pivot->time <=  gmdate('H:i',strtotime($time))) && ($room->pivot->time >= gmdate('H:i',strtotime($time)-strtotime("02:00")))) ){
                        array_push($disabled_rooms,$room->id);
                }
            }
        }
        $rooms_after_reject_disabled_rooms=[];
        if($request->rooms)
        foreach ($request->rooms as $room) {
            if( in_array($room, array_unique($disabled_rooms)) ){
                array_push($rooms_after_reject_disabled_rooms,$room);
            }
        }
        //dd($request->rooms,array_unique($rooms_after_reject_disabled_rooms));













            //remove all rows that owns the course
            //dd($room_Distinct);
            if($request->rooms){
                for ($i=0; $i < $course->users->count() ; $i++) {
                    $course->users[$i]->courses()->detach($course);
                }
                foreach (array_unique($request->rooms) as $roomD) {
                        if(in_array($roomD, array_unique($rooms_after_reject_disabled_rooms)))
                            continue;
                        $course->users()->attach($users_in_rooms[$roomD]['roomHeads'],['room_id'=>$roomD,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Room-Head']);
                        $course->users()->attach($users_in_rooms[$roomD]['secertaries'],['room_id'=>$roomD,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Secertary']);
                        $course->users()->attach($users_in_rooms[$roomD]['observers'],['room_id'=>$roomD,'date'=>$request->date,'time'=>$request->time,'roleIn'=>'Observer']);
                    }
            }else
                return redirect()->back()->with('detemine-rooms',"the Course has'nt belong to any rooms, Please detemine rooms that the course need");



        return redirect()->route('courses.index')->with('user-update','Course update successfully');
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
