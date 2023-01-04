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

class CourseRotationUser_ObjectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return view('Rotations.Objections.User.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Rotation $rotation){
        // $courses=DB::select('select * from courses');
        // dd($courses);
        $courses_info=[];
        foreach($rotation->coursesProgram as $course){
              $courses_info[$course->pivot->date][$course->studing_year][$course->id]=$course->pivot->time;
              ksort($courses_info[$course->pivot->date]);
        }
        ksort($courses_info);
        return view('Rotations.Objections.create',compact('courses_info','rotation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Rotation $rotation){
        $get_all_course_in_same_time=[];
        if(isset($request->courses_objections_ids)){
            foreach ((array)$request->courses_objections_ids as $key => $course_id) {
                $date=$rotation->coursesProgram()->where('id',$course_id)->first()->pivot->date;
                $time=$rotation->coursesProgram()->where('id',$course_id)->first()->pivot->time;
                foreach ($rotation->coursesProgram()->wherePivot('date',$date)->wherePivot('time',$time)->get()->pluck('id') as $key => $id) {
                    array_push($get_all_course_in_same_time,$id);
                }
            }
            $rotation->coursesObjection()->attach(array_unique($get_all_course_in_same_time),['user_id'=>Auth::user()->id,'rotation_id'=>$rotation->id]);

            return redirect()->route('rotations.program.show',$rotation->id)
            ->withSuccess(__('your objections created successfully.'));
        }else{
            return redirect()->back()
            ->withWarning(__('Please Select One Course At Least.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rotation $rotation, User $user)
    {
        return view('Rotations.Objections.User.show',compact('user','rotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rotation $rotation){        
        //dd($rotation->coursesObjection()->get());
        $courses_info=[];
        foreach($rotation->coursesProgram as $course){
              $courses_info[$course->pivot->date][$course->studing_year][$course->id]=$course->pivot->time;
              ksort($courses_info[$course->pivot->date]);
        }
        ksort($courses_info);

        $courses_objections_ids=Course::with('rotationsObjection')->whereHas('rotationsObjection', function($query) use($rotation){
            $query->where('user_id',Auth::user()->id)->where('rotation_id',$rotation->id);})->pluck('id')->toArray();
        //dd($courses_objections_ids);
        return view('Rotations.Objections.edit',compact('courses_info','rotation','courses_objections_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rotation $rotation){

        Auth::user()->rotationsObjection()->detach($rotation->id);

        $get_all_course_in_same_time=[];
        if(isset($request->courses_objections_ids)){
            foreach ((array)$request->courses_objections_ids as $key => $course_id) {
                $date=$rotation->coursesProgram()->where('id',$course_id)->first()->pivot->date;
                $time=$rotation->coursesProgram()->where('id',$course_id)->first()->pivot->time;
                foreach ($rotation->coursesProgram()->wherePivot('date',$date)->wherePivot('time',$time)->get()->pluck('id') as $key => $id) {
                    array_push($get_all_course_in_same_time,$id);
                }
            }
            $rotation->coursesObjection()->attach(array_unique($get_all_course_in_same_time),['user_id'=>Auth::user()->id,'rotation_id'=>$rotation->id]);

            return redirect()->route('rotations.program.show',$rotation->id)
            ->withSuccess(__('your objections updated successfully.'));
        }else{
            return redirect()->route('rotations.program.show',$rotation->id)
            ->withWarning(__('You Discard All your Objections.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
