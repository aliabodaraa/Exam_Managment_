@extends('layouts.app-master')

@section('content')
    <div class="container" style="margin-top: -50px;">
        <h1>Add course to the Exam Program
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
            <form method="POST" action="{{route('courses.store_add_course_to_program')}}" id="coursesForm">
                @csrf
                <div class="mb-3">
                    <label for="course_name" class="form-label">choose course_name :</label>
                    <select class="form-control" name="course_id" class="form-control" required>
                        @if(count(App\Models\Course::all()))
                            <optgroup label="One Year" class="bg-danger h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',1)->where('semester',1)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                                
                                @foreach (App\Models\Course::where('studing_year',1)->where('semester',2)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Two Year" class="bg-secondary h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',2)->where('semester',1)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                                
                                @foreach (App\Models\Course::where('studing_year',2)->where('semester',2)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Third Year" class="bg-success h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',3)->where('semester',1)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                                
                                @foreach (App\Models\Course::where('studing_year',3)->where('semester',2)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Fourth Year" class="bg-dark h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',4)->where('semester',1)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-light" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach

                                @foreach (App\Models\Course::where('studing_year',4)->where('semester',2)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-light" label="second semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                            <optgroup label="Fifth Year" class="bg-warning h5 font-weight-bold text-light">
                                @foreach (App\Models\Course::where('studing_year',5)->where('semester',1)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
                                        @once <option class="h5 font-weight-bold text-dark" label="first semester" disabled>&nbsp;&nbsp;</option> @endonce
                                        <option value='{{ $course->id }}'>&nbsp;&nbsp;&nbsp;&nbsp;{{ $course->course_name }}</option>
                                    @endif
                                @endforeach

                                @foreach (App\Models\Course::where('studing_year',5)->where('semester',2)->get() as $course)
                                    @if(!count($course->rooms->toArray()))
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
                    <input value="{{ old('date') }}"
                        type="date"
                        class="form-control"
                        name="date"
                        placeholder="date" required>
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
                    <input value="{{ $course->students_number }}"
                        type="number"
                        class="form-control"
                        name="students_number"
                        placeholder="students_number" required>
                    @if ($errors->has('students_number'))
                        <span class="text-danger text-left">{{ $errors->first('students_number') }}</span>
                    @endif
                </div>
                    {{-- <label for="rooms" class="form-label">rooms :</label>
                    <div class="mb-3" style="height: 580px;
                    overflow: scroll;">
                        <table class="table table-light">
                            @foreach(App\Models\Room::all() as $room)
                                <tr style="position: relative;top:-1px;">
                                    <td>
                                        <input type="checkbox"
                                        name="rooms[{{ $room->id }}]"
                                        value="{{ $room->id }}"
                                        class='rooms toggler-wrapper style-4'>
                                    </td>
                                    <td>{{ $room->room_name }}</td>  
                                </tr>
                            @endforeach
                        </table>
                    </div> --}}
                <button type="submit" class="btn btn-primary">Save course</button>
                {{-- <a href="{{ route('courses.index') }}" class="btn btn-default">Back</a> --}}
            </form>

    </div>

@endsection
