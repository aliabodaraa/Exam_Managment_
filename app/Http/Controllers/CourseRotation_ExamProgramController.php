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

class CourseRotation_ExamProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_course_to_the_program(Rotation $rotation)
    {
        return view('Rotations.ExamProgram.add_course_to_the_program',compact('rotation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_course_to_the_program(Request $request,Rotation $rotation)
    {
        //dd($request);
        if($request->course_id =='none')
            return redirect()->back()
            ->with('retryEntering',"Please Detemine which course you need to add .");
        $selected_course=Course::where('id',$request['course_id'])->first();
        $selected_course->rotationsProgram()->attach($rotation->id,['students_number'=> $request['students_number'],'duration'=> $request['duration'] ,'date'=>$request['date'],'time'=>$request['time']]);

        return redirect()->route("rotations.program.show",$rotation->id)
        ->with('message','You have successfully create a new course to the room Room');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rotation $rotation)//Done
    {
        // $courses=DB::select('select * from courses');
        // dd($courses);

        $courses_info=[];
        $courses_info=[];
        foreach($rotation->coursesProgram as $course){
              $courses_info[$course->pivot->date][$course->studing_year][$course->id]=$course->pivot->time;
              ksort($courses_info[$course->pivot->date]);
        }
               // ksort($courses_info[$course->users[0]->pivot->date]);
        ksort($courses_info);
        //dd($courses_info);
        //convert from array to json
        //$countries = array("Mark" => "USA", "Raymond" => "UK", "Jeff" => "JPN", "Mike" => "DE");
        //dd (json_encode($countries));
        return view('Rotations.ExamProgram.show',compact('courses_info','rotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_course_from_program(Rotation $rotation, Course $course)
    {
        $rotation->coursesProgram()->detach($course);
        return redirect()->route("rotations.program.show",$rotation->id)
            ->with('user-delete','Course hided successfully.');
    }
}