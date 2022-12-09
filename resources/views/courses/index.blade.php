@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="row">
            <div class="col-lg-10 col-sm-10 col-xs-10">
                <h1 class="text-center m-0"> مقررات
                    {{auth()->user()->faculty->name}}
                </h1>
            </div>
            <div class="col-lg-2 col-sm-2 col-xs-2">
                <div class="collect-index-btns gap-1">
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                    <a href="{{ route('courses.create') }}" class="btn btn-primary float-right mb-4">إضافة مقرر</a>
                    @endif
                    <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
                </div>
            </div>
        </div>
        @if ($messageDelete = Session::get('course-delete'))
        <div class="alert alert-success alert-block">
            <strong>{{ $messageDelete }}</strong>
        </div>
        @endif
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    @if(count($courses))
        <div class="col-sm-3 mb-1">
            {{-- That is not related with controller - Only for Js --}}
            <label for="search_course_name" class="form-label">Search :</label>
            <input class="form-control" 
            type="text" 
            id="search_course_name" 
            onkeyup="searchCourses(JSON.stringify({{ App\Models\Course::where('faculty_id',auth()->user()->faculty->id)->get() }}))" placeholder="Serarch Courses">
        </div>
        <div class="table-responsive">
            <table class="table table-light">
                <thead>
                <tr>
                    <th scope="col" width="20%">course_name</th>
                    <th scope="col" width="10%">studing_year</th>
                    <th scope="col" width="10%">semester</th>
                    <th scope="col" width="30%">department</th>
                    <th scope="col" width="20%">faculty</th>
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                        <th scope="col" width="10%">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                        @foreach($courses as $course)
                            <tr class="course" id="{{$course->id}}">
                                <td>{{ $course->course_name }}</td>
                                <td>{{ $course->studing_year }}</td>
                                <td>{{ $course->semester }}</td>
                                <td>
                                    @foreach ($course->departments()->get() as $department)
                                        <span class="badge bg-secondary">{{ $department->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $course->faculty->name }}</td>
                                @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                <td style="display:flex;align-items:baseline;">
                                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-info btn-sm me-2 btn-close-white">Edit</a>
                                            <a href="#exampleModalToggle" data-bs-toggle="modal" class="btn btn-danger btn-sm" >Delete</a> 
                                    </td>
                                    @include('layouts.partials.popUpDelete',['delete_information' => ['courses.destroy', $course->id]])
                                @endif
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert text-black alert-success" role="alert" style="margin-top: 20px;">
            <h4 class="alert-heading">Sorry<h4>
            <p>There are not any course yet .</p>
            <hr>
            <p class="mb-0">Whenever you need to add a new course, click the yellow button .</p>
           <h1><a href="{{url()->previous()}}" class="btn btn-secondary"> Back</a></h1>
           {{-- problem in back --}}
        </div>
      @endif
    </div>
@endsection