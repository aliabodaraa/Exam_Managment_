@extends('layouts.app-master')

@section('content')
    <div class="container">
        <h1 class="text-center">إضافة مادة إلى برنامج {{ $rotation->name }} {{ $rotation->year }}
            <div class="float-right">
                <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @php
            $courses_in_current_rotation=$rotation->coursesProgram()->pluck('id')->toarray();
            $courses_not_taken_in_this_rotation=App\Models\Course::whereNotIn('id',$courses_in_current_rotation)->pluck('course_name');
        @endphp
        @if(count($courses_not_taken_in_this_rotation))
        <form method="POST" action="{{route('rotations.program.store_course_to_the_program',$rotation->id)}}" id="coursesForm">
                @csrf
                <div class="mb-3">
                    <label for="course_name" class="form-label">choose course_name : (take {{ count($courses_in_current_rotation) }} remaining {{ count($courses_not_taken_in_this_rotation) }} course) :</label>
                    <input name="course_name" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                    <datalist id="datalistOptions">
                        @if(count(App\Models\Course::all()))
                            @foreach ($courses_not_taken_in_this_rotation as $course_name)
                                    <option value='{{ $course_name }}'>
                            @endforeach
                        @else
                            <option value='none'>There are not courses</option>
                        @endif
                    </datalist>
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
        @else
        <div class="alert text-black alert-success" role="alert" style="margin-top: 20px;">
            <h4 class="alert-heading text-center">تمت إضافة كل المقررات إلى هذه الدوره<h4>
        </div>
        @endif
    </div>

@endsection
{{-- @section('scripts')
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
@endsection--}}