<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Rotation;
use App\Models\Course;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;
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
        if(!in_array($request->course_name,Course::get()->pluck('course_name')->toarray()))
            return redirect()->back()->withDanger(__("!! أسم المقرر الذي أدخلته غير معروف"));

        // if($request->course_name =='none')
        //     return redirect()->back()
        //     ->with('retryEntering',"Please Detemine which course you need to add .");
        if((int)$request->students_number > Stock::getMaxDistribution())
                 return redirect()->back()->withDanger(__(Stock::getMaxDistribution()." لا يمكنك تجاوز السعة العظمى للتخزين في القاعات"));
        $selected_course=Course::where('course_name',$request['course_name'])->first();
        if(in_array($selected_course->id,$rotation->coursesProgram()->pluck('id')->toarray()))
            return redirect()->back()->withDanger(__(" تمت إضافة هذا المقرر مسبقا إلى هذه الدورة الإمتحانية"));

        $selected_course->rotationsProgram()->attach($rotation->id,['students_number'=> $request['students_number'],'duration'=> $request['duration'] ,'date'=>$request['date'],'time'=>$request['time']]);

        return redirect()->route("rotations.program.show",$rotation->id)
        ->withSuccess(__('تم إضافة '.$request->course_name.' إلى البرنامج '));
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

        //disabled some of things when the rotation is expired
        $today_date = date("Y-m-d");
        $rotation_end_date = $rotation->end_date; //from database
        $today_time = strtotime($today_date);
        $rotation_end_time = strtotime($rotation_end_date);
        $expire_rotation_date=false;
        if ($rotation_end_time <= $today_time)
            $expire_rotation_date=true;

        return view('Rotations.ExamProgram.show',compact('courses_info','rotation','expire_rotation_date'));
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
    {   //dd($rotation->coursesProgram,$rotation->distributionCourse);
        //$course->rotationsProgram()->detach($rotation->id);
        $rotation->coursesProgram()->detach($course->id);//delete the row from coursesProgram and all rows in distributionCourse ??!!
        //$rotation->distributionCourse()->detach($course->id);//delete the row from distributionCourse
        return redirect()->route("rotations.program.show",$rotation->id)
            ->withSuccess(__('Course hided successfully.'));
    }
    public function initExamProgram(Rotation $rotation)
    {
        $rotation->coursesProgram()->detach();
        return redirect()->route("rotations.program.show",$rotation->id)
            ->withSuccess(__('تمت تهيئة البرنامج الامتحاني  بنجاح'));
    }
    public function initRoomsInAllCourses(Rotation $rotation)
    {
        $rotation->distributionCourse()->detach();
        return redirect()->route("rotations.program.show",$rotation->id)
            ->withSuccess(__('تمت تهيئة القاعات بنجاح'));
    }
    public function initUsersObservationsInAllCourses(Rotation $rotation)
    {
        $rotation->users()->detach();
        return redirect()->route("rotations.program.show",$rotation->id)
            ->withSuccess(__('تمت تهيئة المراقبات بنجاح'));
    }
}
