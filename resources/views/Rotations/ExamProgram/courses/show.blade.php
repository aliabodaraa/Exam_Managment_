@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-2 rounded">
        <h1>            
            <b class="text-center" style="margin-left: 381px;">{{ $rotation->faculty->name }} - برنامج امتحان {{ $rotation->name }} - {{ $rotation->year }}</b>
            <div class="float-right">
                <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
            </div>
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
        <div class="container mt-4" style="direction:rtl">
                    <h1>{{$course->course_name}}</h1>
                    <h5>سنة المادة : {{ $course->studing_year }}</h5>
                    <h5>التاريخ :  <span class="badge bg-danger">{{$course->rotationsProgram[0]->pivot->date}}</span></h5>
                    <h5>الوقت :  <span class="badge bg-secondary">{{$course->rotationsProgram[0]->pivot->time}}</span></h5>
                    <h5>تفاصيل القاعات في مقرر {{$course->course_name}} : </h5>
                <div class="course_rooms">
                    @php $array_rooms_takes=[]; @endphp
                    @foreach ($course->rooms()->wherePivot('rotation_id',$rotation->id)->get() as $room)
                        @if(!in_array($room->id,$array_rooms_takes))
                            @php array_push($array_rooms_takes,$room->id) @endphp
                            <div class="card" style="font-size: 15px;width: 24%; float:right;border: 1px solid #0d6efd73;margin:5px;">
                                <img src="{{ asset('images\Exam_Time.png') }}" class="card-img-top" alt="Exam_Time">
                                <div class="card-body" style="
                                overflow: scroll;">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h5 class="card-title h2">{{  $room->room_name }}</h5>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ route('rotations.get_room_for_course',[$rotation->id, $course->id,$room->id]) }}" class="btn btn-dark btn-outline-light">تعديل </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="course_rooms_details">
                                    <b>الأعضاء : <span class="badge bg-secondary">{{ count($room_users = $room->users()->wherePivot('rotation_id',$rotation->id)->wherePivot('course_id',$course->id)->get()) }}</span></b>
                                    @foreach($room_users as $user)
                                        @if($user->pivot->roleIn=='RoomHead')
                                            <p class="card-text"><span class="badge bg-success">Room-Heads</span>&nbsp;<span class="user-name">{{$user->username}}</span></p>
                                        @elseif($user->pivot->roleIn=='Secertary')
                                            <p class="card-text"><span class="badge bg-info">Secertaries</span>&nbsp;<span class="user-name">{{$user->username}}</span></p>
                                        @elseif($user->pivot->roleIn=='Observer')
                                            <p class="card-text"><span class="badge bg-warning">Observers</span>&nbsp;<span class="user-name">{{$user->username}}</span></p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection
