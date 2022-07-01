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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('courses.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = Course::create(
            [
                'course_name'=> $request->course_name,
                'studing_year'=> $request->studing_year
            ]
        );
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
                        //$last_prev_room_time_taken = $room->users->last()->pivot->time;
                        $selected_room_id = $room->id;
                        break;
                    }
            }
            if($selected_room_id == 0){
                 return redirect()->back()
                 ->with('retryEntering',"all Room not available with this Date: ".$date .' and Time '.$time.' change them and Try Again');
            }
          //assign Room-Head To the Room for a new Course
          $selected_room_head_id = 0;
          foreach (User::all() as $user) {
            if($user->hasRole('Room-Head')){
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
            }
          }
          if($selected_room_head_id == 0){
                return redirect()->back()
                ->with('retryEntering',"There is no Room-Head available Now: ".$date .' and Time '.$time.' change them and Try Again');
          }
          //assign Secertary To the Room for a new Course
          $selected_secertary_id = 0;
          foreach (User::all() as $user) {
            if($user->hasRole('Secertary')){
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
            }
          }
          if($selected_secertary_id == 0){
                return redirect()->back()
                ->with('retryEntering',"There is no Secertary available Now: ".$date .' and Time '.$time.' change them and Try Again');
          }
          //assign Observer To the Room for a new Course
          $selected_observer_id = 0;
          foreach (User::all() as $user) {
            if($user->hasRole('Employee')){
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
            }
          }
          if($selected_observer_id == 0){
                return redirect()->back()
                ->with('retryEntering',"There is no Observer available Now: ".$date .' and Time '.$time.' change them and Try Again');
          }

        $course->users()->attach($selected_room_head_id,['room_id'=>$selected_room_id ,'date'=>$date,'time'=>$time]);
        $course->users()->attach($selected_secertary_id,['room_id'=>$selected_room_id ,'date'=>$date,'time'=>$time]);
        $course->users()->attach($selected_observer_id,['room_id'=>$selected_room_id ,'date'=>$date,'time'=>$time]);
         return redirect()->route('courses.index')
             ->with('message','You have successfully create a new course to the room Room'.$selected_room_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('courses.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('courses.edit', ['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $course->update($request->all());


// dd(User::doesntHave('courses')->get());

             //$courseWithUsers=Course::where('id',$course->id)->with('users')->get();
             //dd($courseWithUsers);
                 foreach ($course->users as $user) {
                    if($user->hasRole('Room-Head')){
                            $user->courses()->updateExistingPivot($course,['room_id'=>$request->room_id,'user_id'=>$request->roomHead_id ,'date'=>$request->date,'time'=>$request->time]);
                    }elseif($user->hasRole('Secertary')){
                            $user->courses()->updateExistingPivot($course,['room_id'=>$request->room_id,'user_id'=>$request->secertary_id ,'date'=>$request->date,'time'=>$request->time]);
                    }elseif($user->hasRole('Employee')){
                            $user->courses()->updateExistingPivot($course,['room_id'=>$request->room_id,'user_id'=>$request->observer_id ,'date'=>$request->date,'time'=>$request->time]);
                        }
                 }
                 $course->save();


        return redirect()->route('courses.index')->with('user-update','Course update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('user-delete','Course deleted successfully.');
    }
}


//use in course.index
// <?php $courses_name=App\Models\Course::where('id',$room->pivot->course_id)->pluck('course_name')?>
