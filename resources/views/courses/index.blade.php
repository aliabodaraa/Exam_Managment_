@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1> المقررات
            <div style="float: right;">
                <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        @if ($messageDelete = Session::get('course-delete'))
        <div class="alert alert-success alert-block">
            <strong>{{ $messageDelete }}</strong>
        </div>
        @endif
        @if(auth()->user()->id==1)
            <div class="lead">
                <a href="{{ route('courses.create') }}" class="btn btn-warning float-right mb-4">إضافة مقرر</a>
            </div>
        @endif
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    @if(count($courses))
        <table class="table table-light">
            <thead>
            <tr>
                <th scope="col" width="25%">course_name</th>
                <th scope="col" width="25%">semester</th>
                <th scope="col" width="50%">faculty</th>
                @if(auth()->user()->id==1)<th scope="col" width="10%">Actions</th>@endif
            </tr>
            </thead>
            <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ $course->semester }}</td>
                            <td>{{ $course->faculty->name }}</td>
                            @if(auth()->user()->id==1)
                                <td style="display:flex;align-items:baseline;">
                                        {{-- <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-info btn-sm me-2 btn-close-white">Edit</a> --}}
                                        {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $course->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
            </tbody>
        </table>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"> </script>

<script type="text/javascript">
    $(document).ready(function(){

        //is active

        isActive=(course_id)=>{
            if(! $('#is_active').is(':checked'))
                $('#is_active').prop('value', false)
            else
                $('#is_active').prop('value', true)
            $('#isActiveForm'+course_id).submit();
        }
        

        //is active
    });

    </script>