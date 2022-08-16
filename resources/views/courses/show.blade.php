@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Course {{$course->course_name}}</h1>
        <div class="lead">

        </div>
        <?php
        $rooms = [];
        foreach ($course->rooms as $room) {
            array_push($rooms,$room->room_name);
        }
        $rooms = array_unique($rooms);
        ?>
        {{-- @dd($rooms) --}}
@if(count($course->rooms))
        <div class="container mt-4">
                    <h5>Course year : {{ $course->studing_year }}</h5>
                    <h5>Date :  <span class="badge bg-danger">{{$course->rooms[0]->pivot->date}}</span></h5>
                    <h5>Time :  <span class="badge bg-secondary">{{$course->rooms[0]->pivot->time}}</span></h5>
                    <h5>Rooms occupied :  @foreach($rooms as $room)<span class="badge bg-warning">{{$room}}</span> @endforeach</h5>
                    <h5>Room Head :  @foreach($course->users as $user)<span class="badge bg-success">@if($user->pivot->roleIn=='Room-Head'){{$user->username}}@endif</span> @endforeach</h5>
                    <h5>Secertary :  @foreach($course->users as $user)<span class="badge bg-success">@if($user->pivot->roleIn=='Secertary'){{$user->username}}@endif</span> @endforeach</h5>
                    <h5>Observer :  @foreach($course->users as $user)<span class="badge bg-success">@if($user->pivot->roleIn==='Observer'){{$user->username}}@endif</span> @endforeach</h5>
        </div>
        @endif
    </div>
    <div class="mt-4">
        <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
    </div>
@endsection
