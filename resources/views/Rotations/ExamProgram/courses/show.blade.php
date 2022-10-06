@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-2 rounded">
        <h1>            
            <b class="text-center" style="margin-left: 381px;">{{ $rotation->faculty->name }} - برنامج امتحان {{ $rotation->name }} - {{ $rotation->year }}</b>
        </h1>
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
                    <h1>{{$course->course_name}}
                        <div class="float-right">
                            <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                        </div>
                    </h1>
                    <div class="lead">
            
                    </div>
                    <h5>Course year : {{ $course->studing_year }}</h5>
                    <h5>Date :  <span class="badge bg-danger">{{$course->rotationsProgram[0]->pivot->date}}</span></h5>
                    <h5>Time :  <span class="badge bg-secondary">{{$course->rotationsProgram[0]->pivot->time}}</span></h5>
 
                    <h5>Rooms Details</h5>
                <div class="rooms">
                    @foreach ($course->rooms as $room)
                        <div class="card" style="max-height: 433px;padding-bottom:5px;
                            overflow: scroll;font-size: 15px;width: 24%; float:right;border: 1px solid #0d6efd73;margin:5px">
                                <img src="{{ asset('images\Exam_Time.png') }}" class="card-img-top" alt="Exam_Time">
                            <div class="card-body" style="max-height: 400px;
                            overflow: scroll;">
                                  <h5 class="card-title h2">{{  $room->room_name }}</h5>
                                  <b>members :</b>
                                    @foreach($room->users as $user)
                                        @if( $user->pivot->rotation_id==$rotation->id && 
                                            $user->pivot->course_id==$course->id )
                                            @if($user->pivot->roleIn=='Room-Head')
                                                <p class="card-text">{{$user->username}}<span class="badge bg-success">Room-Heads</span></p>
                                            @elseif($user->pivot->roleIn=='Secertary')
                                                <p class="card-text">{{$user->username}}<span class="badge bg-secondary">Secertaries</span></p>
                                            @elseif($user->pivot->roleIn=='Observer')
                                                <p class="card-text">{{$user->username}}<span class="badge bg-warning">Observers</span></p>
                                            @endif
                                        @endif
                                    @endforeach
                                  <a href="/courses/{{ $course->id }}/room/{{ $room->id }}" class="btn btn-primary" >Go to {{ $room->room_name  }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                        
        </div>
        @endif
    </div>
@endsection
