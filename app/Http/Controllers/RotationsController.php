<?php

namespace App\Http\Controllers;
use App\Models\Rotation;
use App\Models\Room;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;
use App\Http\Controllers\MaxFlow\Graph;
use App\Http\Controllers\MaxFlow\EnumPersonType;
class rotationsController extends Controller
{

//distribute students into rooms
    public function isAvailableRoom($rotation, $course, $room){

        $curr_date=Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($course,$rotation){$query->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->first()->rotationsProgram[0]->pivot->date;
        $curr_time=Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($course,$rotation){$query->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->first()->rotationsProgram[0]->pivot->time;
        $curr_duration=Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($course,$rotation){$query->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->first()->rotationsProgram[0]->pivot->duration;
        
        foreach (Course::with('distributionRoom')->whereHas('distributionRoom', function($query) use($room,$rotation){
        $query->where('room_id',$room->id)->where('rotation_id',$rotation->id);})->get() as $courseM)
                if((count($rotation->coursesProgram()->wherePivot('date',$curr_date)->wherePivot('time','>=',$curr_time)->wherePivot('time','<=',gmdate('H:i:s',strtotime($curr_time)+strtotime($curr_duration)))->where('id',$courseM->id)->get()->toArray())
                ||  count($rotation->coursesProgram()->wherePivot('date',$curr_date)->wherePivot('time','<=',$curr_time)->wherePivot('time','>=',gmdate('H:i:s',strtotime($curr_time)-strtotime($curr_duration)))->where('id',$courseM->id)->get()->toArray())))
                        return false;

                return true;
    }

    public function distribute($rotation,$course,$roomBase,$temporory_counter,$temp){
            if($temporory_counter >= $temp){
                $temporory_counter-=$temp;
                $course->distributionRoom()->attach($roomBase->id,['rotation_id'=>$rotation->id,'course_id'=>$course->id,'num_student_in_room'=> $temp]);
            }else{
                $course->distributionRoom()->attach($roomBase->id,['rotation_id'=>$rotation->id,'course_id'=>$course->id,'num_student_in_room'=> $temporory_counter]);
                $temporory_counter=0;
            }
        return $temporory_counter;
    }

    public function distributeStudents(Rotation $rotation){
        foreach ($rotation->coursesProgram as $course) {
            $course->distributionRoom()->wherePivot('rotation_id',$rotation->id)->detach();//clear the previous distribution
            $curr_students_number=$course->rotationsProgram()->wherePivot('rotation_id',$rotation->id)->first()->pivot->students_number;
            $temporory_counter=$curr_students_number;
            $rotation = Rotation::find($rotation->id);//high level we reget it because we modified it in the function isAvailableRoom line 23 24
            foreach (Room::all() as $roomBase)
                if($this->isAvailableRoom($rotation, $course, $roomBase) && $roomBase->is_active){
                    if($curr_students_number <= Stock::getMinDistribution())//it is garantee that the curr_students_number is less than $this->getMaxDistribution() that is done in the method in controller CourseRotation_ExamProgram/store_course_to_the_program
                        if(in_array($course->studing_year, [4,5]))
                            $temporory_counter=$this->distribute($rotation,$course,$roomBase,$temporory_counter,(int)(($roomBase->capacity+$roomBase->extra_capacity)/2));//problem without (int) add one student !!!!!
                        else
                            $temporory_counter=$this->distribute($rotation,$course,$roomBase,$temporory_counter,$roomBase->capacity);
                    else
                        $temporory_counter=$this->distribute($rotation,$course,$roomBase,$temporory_counter,$roomBase->capacity+$roomBase->extra_capacity);
                        //dd($temporory_counter);
                    if(!$temporory_counter) break;
                }
        }
        return redirect("/rotations/$rotation->id/show")
        ->withSuccess(__('You have successfully distribute all students to the sutable rooms'));
    }
//distribute students into rooms 
//distributeMembersOfFaculty
public function current_user_observations($user){
    return $user->id;
}
public function distributeMembersOfFaculty(Rotation $rotation){
    //old work start
                    // $distict_arr=[];
                    // foreach ($rotation->distributionRoom as $room) {
                    //     $room->users()->wherePivot('rotation_id',$rotation->id)->detach();//clear the previous distribution
                    //     $take_three=1;
                    //     foreach (User::all() as $user){
                    //         if($take_three == 4) break;
                    //         if($take_three==1)$cur_roleIn='Room-Head';
                    //         elseif($take_three==2)$cur_roleIn='Secertary';
                    //         else $cur_roleIn='Observer';
                    //         if(!in_array($user->id, $distict_arr) &&( ($user->role!='Doctor' && $take_three != 1) || $user->role=='Doctor' && $take_three == 1 ) ){
                    //             array_push($distict_arr,$user->id);
                    //             if( $user->is_active && !$user->temporary_role &&
                    //             $user->faculty_id == auth()->user()->faculty->id /*&&
                    //             $user->number_of_observation <= $this->current_user_observations($user)*/ ){
                    //                             $take_three++;
                    //                             array_push($distict_arr,$user->id);
                    //                             $room->users()->attach($user->id,['rotation_id'=>$rotation->id,'course_id'=>$room->pivot->course_id,'roleIn'=>$cur_roleIn]);
                    //                 } 
                    //         }
                    //     }
                    // }
    //old work end

    $graph_room_heads=new Graph(EnumPersonType::RoomHead);
    list($paths_room_heads,$paths_info_room_heads)=$graph_room_heads->applyMaxFlowAlgorithm();
    foreach ($paths_info_room_heads['users_observations'] as $room_head_id => $room_heads_observations){
        $s=User::where('id',$room_head_id)->first();
        foreach ($room_heads_observations as $room_head_observation)
            $s->courses()->attach($room_head_observation['course'],['rotation_id'=>$room_head_observation['rotation'],'room_id'=>$room_head_observation['room'],'roleIn'=>$room_head_observation['roleIn']]);
    }
    //dump($paths_room_heads,$paths_info_room_heads);
    $graph_secertaries=new Graph(EnumPersonType::Secertary,$paths_info_room_heads);
    list($paths_secertaries,$paths_info_secertaries)=$graph_secertaries->applyMaxFlowAlgorithm();
    foreach ($paths_info_secertaries['users_observations'] as $secertary_id => $secertarys_observations){
        $s=User::where('id',$secertary_id)->first();
        foreach ($secertarys_observations as $secertary_observation)
            $s->courses()->attach($secertary_observation['course'],['rotation_id'=>$secertary_observation['rotation'],'room_id'=>$secertary_observation['room'],'roleIn'=>$secertary_observation['roleIn']]);
    }
    //dump($paths_secertaries,$paths_info_secertaries);
    $graph_observers=new Graph(EnumPersonType::Observer,$paths_info_secertaries);
    list($paths_observers,$paths_info_observers)=$graph_observers->applyMaxFlowAlgorithm();
    foreach ($paths_info_observers['users_observations'] as $observer_id => $observers_observations){
        $s=User::where('id',$observer_id)->first();
        foreach ($observers_observations as $observer_observation)
            $s->courses()->attach($observer_observation['course'],['rotation_id'=>$observer_observation['rotation'],'room_id'=>$observer_observation['room'],'roleIn'=>$observer_observation['roleIn']]);
    }
    //dd($paths_observers,$paths_info_observers);
    return redirect("/rotations/$rotation->id/show")
    ->withSuccess(__('You have successfully distribute all Members to the sutable rooms'));
}



//distributeMembersOfFaculty
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {//$x=NULL;$x='2000'-'1997';dd($x);

        //$has_program=User::with('rooms','rotations')->get();
        //dd($has_program);
        $existing_rotation=Rotation::where('year',date("Y"))->pluck('year','name')->map(function($i){
            return $i;
        })->toArray();
        $count_existing_rotation=count($existing_rotation);
        $rotations = Rotation::orderBy('id','DESC')->get();
        list($all_rotations_table, $observations_number_in_latest_rotation)=Stock::calcInfoForEachRotationForSpecificuser(auth()->user());
        return view('rotations.index', compact('rotations','count_existing_rotation','observations_number_in_latest_rotation'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $existing_rotation=Rotation::where('year',date("Y"))->pluck(/*'year',*/'name')->map(function($i){
            return $i;
        })->toArray();
        $general_rotations=['الدورة الفصلية الأولى','الدورة الفصلية الثانية','الدورة الفصلية الثالثة'];
        $insertion_enabled_rotation = array_diff($general_rotations, $existing_rotation);

        return view('rotations.create',compact('insertion_enabled_rotation'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rotation  $rotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Rotation $rotation)
    {
        // dd($rotation->coursesProgram()->wherePivot('course_id','>',1)->where('semester',1)
        // ->get()
        // ->toArray());
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
            ->withDanger(__('rotation deleted successfully.'));
    }

    public function create_initial_members(Rotation $rotation)
    {
        $room_heads=User::where('role','دكتور')->where('temporary_role')->get()->pluck('username','id')->toarray();
        $users= User::where('temporary_role','<>','رئيس شعبة الامتحانات')->where('role','!=','دكتور')->
                      orWhere('temporary_role')->where('role','!=','دكتور')->get()->pluck('username','id')->
                      toarray();
        $users_and_roomHeads=$room_heads+$users;
        $disabled_users=User::where('is_active',0)->pluck('id')->toarray();
        return view('Rotations.create_initial_members',compact('rotation','users','users_and_roomHeads','disabled_users'));
    }

    public function store_initial_members(Request $request, Rotation $rotation)
    {
        if(isset($request->users)){
            foreach ($request->users as $user_id => $options)
                $rotation->initial_members()->attach($user_id,['options'=> json_encode($options)]);
        }else{
            return redirect()->back()
            ->withWarning(__('please select at least on user'));   
        }
        return redirect()->route('rotations.program.show',$rotation->id)
            ->withSuccess(__('store members successfully.'));
    }
    public function edit_initial_members(Rotation $rotation)
    {
        $room_heads=User::where('role','دكتور')->where('temporary_role')->get()->pluck('username','id')->toarray();
        $users= User::where('temporary_role','<>','رئيس شعبة الامتحانات')->where('role','!=','دكتور')->
                      orWhere('temporary_role')->where('role','!=','دكتور')->get()->pluck('username','id')->
                      toarray();
        $users_and_roomHeads=$room_heads+$users;
        $disabled_users=User::where('is_active',0)->pluck('id')->toarray();
        foreach ($rotation->initial_members()->get() as $user){
            $users_with_options[$user->id]=(array)json_decode($user->pivot->options);
        }
        return view('Rotations.edit_initial_members',compact('rotation','users','users_and_roomHeads','users_with_options','disabled_users'));
    }
    public function update_initial_members(Request $request, Rotation $rotation)
    {
        if(isset($request->users)){
            $rotation->initial_members()->detach();
            foreach ($request->users as $user_id => $options)
                $rotation->initial_members()->attach($user_id,['options'=> json_encode($options)]);
        }else{
            return redirect()->back()
            ->withWarning(__('please select at least on user'));   
        }
        return redirect()->route('rotations.program.show',$rotation->id)
            ->withSuccess(__('update members successfully.'));
    }
}
