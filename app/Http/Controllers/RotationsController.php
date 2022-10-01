<?php

namespace App\Http\Controllers;
use App\Models\Rotation;
use App\Models\Room;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class rotationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//objection section start
    public function objections_create(Rotation $rotation){
        // $courses=DB::select('select * from courses');
        // dd($courses);
        $courses_info=[];
        foreach($rotation->courses as $course){
              $courses_info[$course->pivot->date][$course->studing_year][$course->id]=$course->pivot->time;
              ksort($courses_info[$course->pivot->date]);
        }
        ksort($courses_info);
        return view('objections.create',compact('courses_info','rotation'));
    }
    public function objections_store(Request $request, Rotation $rotation){
            //dd($request->get('courses_objections_ids'));

            $rotation->coursesObservation()->attach($request->get('courses_objections_ids'),['user_id'=>Auth::user()->id,'rotation_id'=>$rotation->id]);

            return redirect()->route('rotations.index')
            ->withSuccess(__('objections created successfully.'));
    }
    public function objections_edit(Rotation $rotation){
            $courses_info=[];
            foreach($rotation->courses as $course){
                  $courses_info[$course->pivot->date][$course->studing_year][$course->id]=$course->pivot->time;
                  ksort($courses_info[$course->pivot->date]);
            }
            ksort($courses_info);

            $courses_objections_ids=Course::with('rotationsObservation')->whereHas('rotationsObservation', function($query) use($rotation){
                $query->where('user_id',Auth::user()->id)->where('rotation_id',$rotation->id);})->pluck('id')->toArray();
            //dd($courses_objections_ids);
            return view('objections.edit',compact('courses_info','rotation','courses_objections_ids'));
    }
    public function objections_update(Request $request, Rotation $rotation){

        Auth::user()->rotationsObservation()->detach($rotation->id);
        $rotation->coursesObservation()->attach($request->get('courses_objections_ids'),['user_id'=>Auth::user()->id,'rotation_id'=>$rotation->id]);

        return redirect()->route('rotations.index')
        ->withSuccess(__('objections updated successfully.'));
    }
    //objection section end
    public function index()
    {
        //$has_program=User::with('rooms','rotations')->get();
        //dd($has_program);
        $existing_rotation=Rotation::where('year',date("Y"))->pluck('year','name')->map(function($i){
            return $i;
        })->toArray();
        $count_existing_rotation=count($existing_rotation);
        $rotations = Rotation::orderBy('id','DESC')->get();
        return view('rotations.index', compact('rotations','count_existing_rotation'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $existing_rotation=Rotation::where('year',date("Y"))->pluck('year','name')->map(function($i){
            return $i;
        })->toArray();//dd($existing_rotation);
         foreach ($existing_rotation as $key => $value) {
            // dd($value);
         }
        //dd(count($existing_rotation));
        if(count($existing_rotation)<3)
            return view('rotations.create',compact('existing_rotation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    //dd($request['year']);
        $request['year']=(int)date('Y');
        //dd($request['year']);
        $this->validate($request,[
            'name' => [
                'required', 
                Rule::unique('rotations')//verify that the name with year don't repated (both are unique)
                       ->where('year', $request['year'])
            ],
            //'year' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'faculty_id' => 'required'
        ],[
            'name.unique'=>'اسم الدورة موجود في السنة المحددة'
        ]);
        Rotation::create(
            [
                'name'=> $request->name,
                'year'=> $request->year,
                'start_date'=> $request->start_date,
                'end_date'=> $request->end_date,
                'faculty_id' => $request->faculty_id
            ]
        );
        return redirect()->route('rotations.index')
            ->withSuccess(__('rotation created successfully.'));
    }

    public function show(Rotation $rotation)//Done
    {
        // $courses=DB::select('select * from courses');
        // dd($courses);

        $courses_info=[];
        $courses_info=[];
        foreach($rotation->courses as $course){
              $courses_info[$course->pivot->date][$course->studing_year][$course->id]=$course->pivot->time;
              ksort($courses_info[$course->pivot->date]);
        }
               // ksort($courses_info[$course->users[0]->pivot->date]);
        ksort($courses_info);
        //dd($courses_info);
        //convert from array to json
        //$countries = array("Mark" => "USA", "Raymond" => "UK", "Jeff" => "JPN", "Mike" => "DE");
        //dd (json_encode($countries));
        return view('rotations.show',compact('courses_info','rotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rotation  $rotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Rotation $rotation)
    {
        return view('rotations.edit', ['rotation' => $rotation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rotation  $rotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rotation $rotation)
    {
        $this->validate($request,[
            'name' => [
                'required', 
                Rule::unique("rotations")->where(function ($query) use ($rotation) {
                        return $query->where(
                            [
                                ["year", "=", $rotation->year]
                            ]
                        );
                    })->ignore($rotation->id)//verify that the name with year don't repated (both are unique)(unique for escape comparing this routation)
            ],
            'year' => [
                'required', 
                Rule::unique("rotations")->where(function ($query) use ($rotation) {
                    return $query->where(
                        [
                            ["name", "=", $rotation->name]
                        ]
                    );
                })->ignore($rotation->id)//verify that the name with year don't repated (both are unique)(unique for escape comparing this routation)
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'faculty_id' => $request->faculty_id
        ],[
            'name.unique'=>'هذه السنة موجوده تتضمن الدورة المحددة',
            'year.unique'=>'هذه الدوره موجوده في السنة المحددة'
        ]);
        $rotation->update($request->all());
        return redirect()->route('rotations.index')
            ->withSuccess(__('rotation updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rotation  $rotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rotation $rotation)
    {
        $rotation->delete();

        return redirect()->back()
            ->with('rotations-delete','rotation deleted successfully.');
    }

    //add course to the program
    public function add_course_to_program(Rotation $rotation){
        return view('rotations.add_course_to_program',compact('rotation'));
    }
    
    public function store_add_course_to_program(Request $request,Rotation $rotation){
        //dd($request);
        if($request->course_name=='none')
            return redirect()->back()
            ->with('retryEntering',"Please Detemine which course you need to add .");
        //dd((int)$request['course_id']);
             $enterCourse=true;
             $selected_rooms = [];
              $date=$request->date;
              //$time=Carbon::parse($request->time, 'UTC')->isoFormat('h:m');
              $time=$request->time;//dd($request);
              $courseN=Course::where('id',(int)$request['course_id'])->first();
              $courseN->update($request->only('students_number'));//edit course in course table
              //assign Room To the new Course
              $num_st_in_course_taken=0;
              $disabled_members=[];
              $x=$courseN->students_number;
               foreach (Room::all() as $roomBase) {//assign Rooms for a new Course
                    $is_available_room = true;
                    foreach ($roomBase->users as $user) {
                            $curr_date=$user->pivot->date;
                            $curr_time=$user->pivot->time;
                            if($curr_date && $curr_time){//dd(0);
                                $courseF=Course::with('users')->whereHas('users',function($query) use($curr_date,$curr_time){$query->where('date',$curr_date)->where('time',$curr_time);})->first();
                                if( ( (($time < $user->pivot->time) && (gmdate('H:i:s',strtotime($time)+strtotime($courseN->duration))>$user->pivot->time ))
                                   || (($time >  $user->pivot->time) && (gmdate('H:i:s',strtotime($user->pivot->time)+strtotime($courseF->duration)) > $time)) ) && $date==$user->pivot->date ){
                                    $is_available_room = false;
                                    break;
                                }
                            }else{
                                continue;
                            }
                        }
                    if($is_available_room){
                            if($x >= $roomBase->capacity/2){
                                $x-=$roomBase->capacity/2;
                                //$num_st_in_course_taken+=$roomBase->capacity/2;
                                $selected_rooms[$roomBase->id]['take']=$roomBase->capacity/2;
                            }else{
                                //dd( $num_st_in_course_taken);
                                $selected_rooms[$roomBase->id]['take']=$x;
                                $x=0;
                            }


                            //assign members To the Room for a new Course
                            $selected_room_head_id = 0;$selected_secertary_id = 0;$selected_observer_id = 0;$enter=0;
                            foreach (User::all() as $user) {
                                    $is_available = true;
                                    //start calc_num_observation_for_current_user
                                        $current_observations_for_all_users=User::with('courses')->whereHas('courses',function($query) use($user) {$query->where('user_id',$user->id);})->get();
                                        $dates_distinct=[];
                                        $times_distinct=[];
                                        foreach($current_observations_for_all_users as $current_user){
                                            foreach($current_user->courses as $course){
                                                if( (!in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                                    ( in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                                    (!in_array($course->pivot->date,$dates_distinct) &&  in_array($course->pivot->time,$times_distinct) ) ){
                                                            array_push($dates_distinct,$course->pivot->date);
                                                            array_push($times_distinct,$course->pivot->time); 
                                                }
                                            }
                                        }
                                        if( count($dates_distinct) >= $user->number_of_observation || $user->id ==1 )
                                            continue;
                                    //end calc_num_observation_for_current_user
                                    foreach ($user->rooms as $room) {
                                        $curr_date=$room->pivot->date;
                                        $curr_time=$room->pivot->time;
                                        if($curr_date && $curr_time){
                                            $courseF=Course::with('users')->whereHas('users',function($query) use($curr_date,$curr_time){$query->where('date',$curr_date)->where('time',$curr_time);})->first();
                                            if( $date == $curr_date && ((($time <= $curr_time) && (gmdate('H:i:s',strtotime($time)+strtotime($courseN->duration))>=$curr_time ))
                                            || (($time >=  $curr_time) && (gmdate('H:i:s',strtotime($curr_time)+strtotime($courseF->duration)) >= $time))) ){
                                                $is_available = false;
                                                break;
                                            }
                                        }else{
                                            continue;
                                        }
                                    }
                                    if($is_available && $enter==0 && ! in_array($user->id, $disabled_members) && $user->id>=2 && $user->id<=61){
                                        $selected_room_head_id = $user->id;
                                        $selected_rooms[$roomBase->id]['members'][$selected_room_head_id]=$selected_room_head_id;
                                        array_push($disabled_members,$selected_room_head_id);
                                        $enter++;
                                    }elseif($is_available && $enter==1 && ! in_array($user->id, $disabled_members) && $user->id>=62 && $user->id<=115){
                                        $selected_secertary_id = $user->id;
                                        $selected_rooms[$roomBase->id]['members'][$selected_secertary_id]=$selected_secertary_id;
                                        array_push($disabled_members,$selected_secertary_id);
                                        $enter++;
                                    }elseif($is_available && $enter==2 && ! in_array($user->id, $disabled_members)){
                                        $selected_observer_id = $user->id;
                                        $selected_rooms[$roomBase->id]['members'][$selected_observer_id]=$selected_observer_id;
                                        array_push($disabled_members,$selected_observer_id);
                                        $enter++;
                                        break;
                                    }
                                }//end foreach_users
                            //dd($selected_rooms);
                            if($enter == 0){
                                $enterCourse=false;
                                return redirect()->back()
                                ->with('retryEntering',"There is no one available Now: ".$date .' and Time '.$time.' change them and Try Again');
                            }elseif($enter == 1){
                                $enterCourse=false;
                                return redirect()->back()
                                ->with('retryEntering',"There is no secertiray available Now: ".$date .' and Time '.$time.' change them and Try Again');
                            }elseif($enter == 2){
                                $enterCourse=false;
                                return redirect()->back()
                                ->with('retryEntering',"There is no observers available Now: ".$date .' and Time '.$time.' change them and Try Again');
                            }
  
                            if(!$x) break;
                    }
                }//end foreach room
                //dd($selected_rooms);
                if(!count($selected_rooms)){
                    $enterCourse=false;
                     return redirect()->back()
                     ->with('retryEntering',"all Room not available with this Date: ".$date .' and Time '.$time.' change them and Try Again');
                }
    
                if($enterCourse){
                    foreach ($selected_rooms as $room_id => $room_info) {
                        $i=1;
                        foreach ($room_info['members'] as $member) {
                            if($i==1) {
                                $courseN->users()->attach($member,['room_id'=>$room_id,'num_student_in_room'=> $room_info['take'] ,'date'=>$date,'time'=>$time,'roleIn'=>'Room-Head','rotation_id'=>$rotation->id]);
                                $i++;
                                continue;
                            }elseif($i==2){
                                $courseN->users()->attach($member,['room_id'=>$room_id, 'num_student_in_room'=> $room_info['take'] ,'date'=>$date,'time'=>$time,'roleIn'=>'Secertary','rotation_id'=>$rotation->id]);
                                $i++;
                                continue;
                            }else{
                                $courseN->users()->attach($member,['room_id'=>$room_id, 'num_student_in_room'=> $room_info['take'] ,'date'=>$date,'time'=>$time,'roleIn'=>'Observer','rotation_id'=>$rotation->id]);
                            }
                        }
                    }
                    return redirect("/rotations/$rotation->id/show")
                        ->with('message','You have successfully create a new course to the room Room');
                }else{
                    return redirect()->back()
                    ->with('retryEntering',"There is no rooms available Nowalso there are users : ".$date .' and Time '.$time.' change them and Try Again');
                }
        }
}
