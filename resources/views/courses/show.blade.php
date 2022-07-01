@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Course {{$course->course_name}}</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
                    <h5>Course year : {{ $course->studing_year }}</h5>
                    <h5>Date :  @foreach($course->rooms as $key => $room)@if($key==1)<span class="badge bg-danger">{{$room->pivot->date}}</span>@endif @endforeach</h5>
                    <h5>Time :  @foreach($course->rooms as $key => $room)@if($key==1)<span class="badge bg-secondary">{{$room->pivot->time}}</span>@endif @endforeach</h5>
                    <h5>Rooms occupied :  @foreach($course->rooms as $key => $room)@if($key==1)<span class="badge bg-warning">{{$room->name}}</span>@endif @endforeach</h5>
                    <h5>Room Head :  @foreach($course->users as $user)<span class="badge bg-success">@if($user->hasRole('Room-Head')){{$user->username}}@endif</span> @endforeach</h5>
                    <h5>Secertary :  @foreach($course->users as $user)<span class="badge bg-success">@if($user->hasRole('Secertary')){{$user->username}}@endif</span> @endforeach</h5>
                    <h5>Observer :  @foreach($course->users as $user)<span class="badge bg-success">@if($user->hasRole('Employee')){{$user->username}}@endif</span> @endforeach</h5>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('courses.index') }}" class="btn btn-dark">Back</a>
    </div>
@endsection
