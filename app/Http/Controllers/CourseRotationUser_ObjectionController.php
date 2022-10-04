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
    public function index()
    {
        //
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
        //dd($request->get('courses_objections_ids'));

        $rotation->coursesObservation()->attach($request->get('courses_objections_ids'),['user_id'=>Auth::user()->id,'rotation_id'=>$rotation->id]);

        return redirect()->route('rotations.index',$rotation->id)
        ->withSuccess(__('objections created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rotation $rotation){        
        //dd($rotation->coursesObservation()->get());
        $courses_info=[];
        foreach($rotation->coursesProgram as $course){
              $courses_info[$course->pivot->date][$course->studing_year][$course->id]=$course->pivot->time;
              ksort($courses_info[$course->pivot->date]);
        }
        ksort($courses_info);

        $courses_objections_ids=Course::with('rotationsObservation')->whereHas('rotationsObservation', function($query) use($rotation){
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

        Auth::user()->rotationsObservation()->detach($rotation->id);
        $rotation->coursesObservation()->attach($request->get('courses_objections_ids'),['user_id'=>Auth::user()->id,'rotation_id'=>$rotation->id]);

        return redirect()->route('rotations.index')->withSuccess(__('objections updated successfully.'));
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
