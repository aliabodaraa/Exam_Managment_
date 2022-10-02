@extends('layouts.app-master')

@section('content')
    <div class="container" style="margin-top: -50px;">
        <h1>Add course to the Exam Program {{ $rotation->name }}
            <div class="" style="float: right;">
                <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        <div class="lead">
            when you specify the following fields the system dynamically select the available rooms for the course that you have already selected it
        </div>
            @if ($message = Session::get('retryEntering'))
                <div class="alert alert-danger alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <br>
            <form method="POST" action="{{route('rotations.program.store_course_to_the_program',$rotation->id)}}" id="coursesForm">
                @csrf
                <div class="mb-3">
                    <label for="course_id" class="form-label">choose course_name :</label>
                    <select class="form-control" name="course_id" class="form-control" required>
                        @if(count(App\Models\Course::all()))
                            <optgroup label="One Year" class="bg-danger h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',1)->where('semester',1)->get() as $course)
                                    @php
                                        $courses_in_current_rotationOneOne=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',1)->where('semester',1)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationOneOne->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                                
                                @foreach (App\Models\Course::where('studing_year',1)->where('semester',2)->get() as $course)
                                    @php
                                        $courses_in_current_rotationOneTwo=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',1)->where('semester',2)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationOneTwo->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Two Year" class="bg-secondary h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',2)->where('semester',1)->get() as $course)
                                    @php
                                        $courses_in_current_rotationTwoOne=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',2)->where('semester',1)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationTwoOne->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                                
                                @foreach (App\Models\Course::where('studing_year',2)->where('semester',2)->get() as $course)
                                    @php
                                        $courses_in_current_rotationTwoTwo=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',2)->where('semester',2)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationTwoTwo->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Third Year" class="bg-success h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',3)->where('semester',1)->get() as $course)
                                    @php
                                        $courses_in_current_rotationThreeOne=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',3)->where('semester',1)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationThreeOne->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                                
                                @foreach (App\Models\Course::where('studing_year',3)->where('semester',2)->get() as $course)
                                    @php
                                        $courses_in_current_rotationThreeTwo=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',3)->where('semester',2)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationThreeTwo->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Fourth Year" class="bg-dark h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',4)->where('semester',1)->get() as $course)
                                    @php
                                        $courses_in_current_rotationFourthOne=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',4)->where('semester',1)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationFourthOne->toArray()))
                                        @once <option class="h5 font-weight-bold text-light" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach

                                @foreach (App\Models\Course::where('studing_year',4)->where('semester',2)->get() as $course)
                                    @php
                                        $courses_in_current_rotationFourthTwo=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',4)->where('semester',2)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationFourthTwo->toArray()))
                                        @once <option class="h5 font-weight-bold text-light" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Fifth Year" class="bg-warning h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',5)->where('semester',1)->get() as $course)
                                    @php
                                        $courses_in_current_rotationFifthOne=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',5)->where('semester',1)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationFifthOne->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach

                                @foreach (App\Models\Course::where('studing_year',5)->where('semester',2)->get() as $course)
                                    @php
                                        $courses_in_current_rotationFifthTwo=App\Models\Course::with('rotationsProgram')->whereHas('rotationsProgram', function($query) use($rotation){$query->where('rotation_id',$rotation->id);})->where('studing_year',5)->where('semester',2)->get();
                                    @endphp
                                    @if(!count($courses_in_current_rotationFifthTwo->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @else
                            <option value='none'>There are not courses</option>
                        @endif
                    </select>
                    @if ($errors->has('studing_year'))
                        <span class="text-danger text-left">{{ $errors->first('studing_year') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">date</label>
                    <input id="date_picker" value="{{ old('date') }}"
                        type="date"
                        class="form-control"
                        name="date"
                        placeholder="date" onclick="myFunction(JSON.stringify({{ $rotation }}))" required>
                    @if ($errors->has('date'))
                        <span class="text-danger text-left">{{ $errors->first('date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">time</label>
                    <input value="{{ old('time') }}"
                        type="time"
                        class="form-control"
                        name="time"
                        placeholder="time" required>
                    @if ($errors->has('time'))
                        <span class="text-danger text-left">{{ $errors->first('time') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="students_number" class="form-label">students_number :</label>
                    <input value="{{ old('students_number') }}"
                        type="number"
                        class="form-control"
                        name="students_number"
                        placeholder="students_number" required>
                    @if ($errors->has('students_number'))
                        <span class="text-danger text-left">{{ $errors->first('students_number') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">duration</label>
                    <select class="form-control" name="duration" class="form-control" required>
                        <option value='01:00'>1 hours</option>
                        <option value='01:30' selected>1:30 hours</option>
                        <option value='02:00' >2 hours</option>
                        <option value='02:30'>2:30 hours</option>
                        <option value='03:00'>3 hours</option>
                        <option value='03:30'>3:30 hours</option>
                        <option value='04:00'>4 hours</option>
                    </select>
                    @if ($errors->has('duration'))
                        <span class="text-danger text-left">{{ $errors->first('duration') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save course</button>
                {{-- <a href="{{ route('courses.index') }}" class="btn btn-default">Back</a> --}}
            </form>

    </div>

@endsection
@section('scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(document).ready(function () {
        var current_rotation;
        myFunction=(x)=>{
            current_rotation=JSON.parse(x);
            console.log(current_rotation.start_date+"\n"+current_rotation.end_date);  
          $('#date_picker').attr('min',current_rotation.start_date);
          $('#date_picker').attr('max',current_rotation.end_date);
        }

    });
</script>
@endsection