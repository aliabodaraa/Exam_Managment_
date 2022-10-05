<?php

namespace App\Http\Controllers;
use App\Models\Rotation;
use App\Models\Room;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;
class rotationsController extends Controller
{


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
            $curr_students_number=Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($course,$rotation){$query->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->first()->rotationsProgram[0]->pivot->students_number;
            $temporory_counter=$curr_students_number;
            $rotation = Rotation::find($rotation->id);
            foreach (Room::all() as $roomBase)
                if($this->isAvailableRoom($rotation, $course, $roomBase) && $roomBase->is_active){
                    if($curr_students_number <= Stock::getMinDistribution())//it is garantee that the curr_students_number is less than $this->getMaxDistribution() that is done in the method in controller CourseRotation_ExamProgram/store_course_to_the_program
                        if(in_array($course->studing_year, [4,5]))
                            $temporory_counter=$this->distribute($rotation,$course,$roomBase,$temporory_counter,($roomBase->capacity+$roomBase->extra_capacity)/2);
                        else
                            $temporory_counter=$this->distribute($rotation,$course,$roomBase,$temporory_counter,$roomBase->capacity);
                    else
                        $temporory_counter=$this->distribute($rotation,$course,$roomBase,$temporory_counter,$roomBase->capacity+$roomBase->extra_capacity);
                        
                    if(!$temporory_counter) break;
                }
        }
        return redirect("/rotations/$rotation->id/show")
        ->with('message','You have successfully distribute all students to the sutable rooms');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
            ->with('rotations-delete','rotation deleted successfully.');
    }

}
