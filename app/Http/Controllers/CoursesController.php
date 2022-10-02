<?php

namespace App\Http\Controllers;
use App\Models\Rotation;
use App\Models\Course;
use App\Models\Department;
use App\Models\Room;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Facades\DB;
class CoursesController extends Controller
{

    public function index()
    {
        $courses = Course::orderBy('course_name')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'course_name' => 'required|min:1|max:40|unique:courses,course_name',
            'faculty_id' => 'required'
        ],[
            'course_name.unique' => 'the name of course already exist'
        ]);
        $course = Course::create(
            [
                'course_name'=> $request->course_name,
                'studing_year'=> $request->studing_year,
                'semester' => $request->semester,
                'faculty_id' =>  $request->faculty_id,
            ]
        );
        return redirect("/")->with('user-update','course '.$request->course_name.' created successfully');
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
