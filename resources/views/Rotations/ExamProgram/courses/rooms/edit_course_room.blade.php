@extends('layouts.app-master')

@section('content')
@php
$occupied_number_of_students_in_this_course_not_in_this_room = $occupied_number_of_students_in_this_course - $occupied_number_of_students_in_this_course_in_this_room;
$occupied_number_of_students_in_this_room_in_all_common_courses=0;
foreach ($courses_common_with_time as $course_belongs) {
    if($course_belongs->id !=$course->id)
        if(array_key_exists($specific_room->id,$accual_common_rooms_for_specific_course[$course_belongs->id]))
            $occupied_number_of_students_in_this_room_in_all_common_courses+=$accual_common_rooms_for_specific_course[$course_belongs->id][$specific_room->id];
}
//collect all users in all rooms except this room 
$users_in_course_not_in_this_room=[];
foreach (App\Http\Controllers\MaxMinRoomsCapacity\Stock::getUsersInSpecificRotationCourse($rotation,$course) as $room_number => $users_ids) {
    if($room_number != $specific_room->id)
    for ($i=0; $i <3 ; $i++) { 
    if(count($users_ids[$i])>0)
        foreach ($users_ids[$i] as $user_id) {
            array_push($users_in_course_not_in_this_room,$user_id);
        }
    }
}
$total_capacity=$specific_room->capacity+$specific_room->extra_capacity;
$num_places_occupied_in_this_room=$occupied_number_of_students_in_this_course_in_this_room+$occupied_number_of_students_in_this_room_in_all_common_courses;
$remaining_places_in_room=$total_capacity-$num_places_occupied_in_this_room;
@endphp

@php $num_all_courses_occupied_this_room=0; @endphp

<div class="bg-light rounded">
        <button class="scroll_buttom_button" style="position: fixed;
        top: 367px;
        right: 0;
        border-radius: 63px;border: 1px solid #eaeaea;
        width: 63px;
        height: 63px;
        z-index: 999;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path></svg>
        </button>
        <button class="scroll_top_button" style="position: fixed;
        top: 167px;
        right: 0;
        border-radius: 63px;
        border: 1px solid #eaeaea;
        width: 63px;
        height: 63px;
        z-index: 999;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path></svg>
        </button>
        <div class="row">
            <div class="col-sm-6 info-room mt-2" style="display: -webkit-inline-box;">
                <h4><span class="badge bg-secondary">Room Name : {{$specific_room->room_name}}</span></h4>
                <h4><span class="badge bg-secondary">Date : {{date('l d-m-Y', strtotime($date))}}</span></h4>
                <h4><span class="badge bg-secondary">Time : {{gmdate('H:i A',strtotime($time))}}</span></h4>
            </div>
            {{-- fly code to top --}}
            {{-- progress --}}
            <div class="col-sm-4 bg-white rounded-lg mx-2" style="position: relative;
            padding: 3px;
            display: -webkit-inline-box;
            white-space: nowrap;
            height: 100px;
            border: 1px solid #eaeaea;">
            {{-- <h2 class="h6 font-weight-bold text-center">{{ $course->course_name }} progress</h2> --}}
            <!-- Progress bar 1 -->
                    @if($num_places_occupied_in_this_room > 0)
                    <div id="progress_line" class="col-sm-2 progress mx-2 mt-2" data-value='{{number_format((int)((($num_places_occupied_in_this_room)/($total_capacity))*100), 0, '.', '')}}'>
                    <span class="progress-left">
                            <span class="progress-bar border-<?php if(((($num_places_occupied_in_this_room)/($total_capacity))*100)<40) echo'danger';elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<60) echo 'warning'; elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<80) echo 'primary';else echo 'success';?>"></span>
                        </span>
                        <span class="progress-right">
                            <span class="progress-bar border-<?php if(((($num_places_occupied_in_this_room)/($total_capacity))*100)<30) echo'danger';elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<=60) echo 'warning'; elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<=80) echo 'primary';else echo 'success';?>"></span>
                        </span>
                        <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                            <div id="progress_value" class="h3 font-weight-bold text-<?php if(((($num_places_occupied_in_this_room)/($total_capacity))*100)<30) echo'danger';elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<=60) echo 'warning'; elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<=80) echo 'primary';else echo 'success';?>">{{number_format((int)(((($num_places_occupied_in_this_room)/($total_capacity)))*100), 0, '.', '')}}</div><span class="h4 font-weight-bold text-<?php if(((($num_places_occupied_in_this_room)/($total_capacity))*100)<30) echo'danger';elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<=60) echo 'warning'; elseif(((($num_places_occupied_in_this_room)/($total_capacity))*100)<=80) echo 'primary';else echo 'success';?>">%</span>
                        </div>
                    </div>
                    @else
                    <span class="text-warning">Room Is Empty</span>

                    @endif
                    <!-- Demo info -->
                    <div class="col-sm-10">
                        <div class="row text-center mt-3">
                            <div class="col-5 px-4 border-right" style="display:none;">
                                <div id="progress_remaining_to_full" class="h6 font-weight-bold my-0">{{100-number_format((int)(($num_places_occupied_in_this_room/$total_capacity)*100), 0, '.', '')}}</div><span class="small text-gray"> still</span>
                            </div>
                            <div class="col-2 px-4">
                                <div class="h2 font-weight-bold my-0 text-">{{$num_places_occupied_in_this_room}}</div><span class="small text-gray">full places</span>
                            </div>
                            <div class="col-2 px-4">
                                <div class="h2 font-weight-bold my-0">{{$total_capacity-$num_places_occupied_in_this_room}}</div><span class="small text-gray">free places</span>
                            </div>
                            <div class="col-2 px-4">
                                <div class="h2 font-weight-bold my-0">{{$total_capacity}}</div><span class="small text-gray">room capacity</span>
                            </div>
                            <div class="col-1 mx-4 common-courses"  style="display: inline-flex;float:right">
                                        @foreach ($courses_common_with_time as $course_belongs)
                                                @php
                                                    $number_taken_in_this_room_course=0;
                                                    foreach ($course_belongs->distributionRoom()->where('rotation_id',$rotation->id)->get() as $oneroom)
                                                        if($oneroom->id==$specific_room->id){
                                                            $number_taken_in_this_room_course=App\Http\Controllers\MaxMinRoomsCapacity\Stock::getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course_belongs, $oneroom);
                                                            $num_all_courses_occupied_this_room+=$number_taken_in_this_room_course;
                                                        }
                                                @endphp 
                                                @if($number_taken_in_this_room_course)
                                                <h5>
                                                    <a style="text-decoration: none;" href="{{ route("rotations.get_room_for_course",[$rotation->id,$course_belongs->id,$specific_room->id]) }}" class="badge bg-{{($course->id == $course_belongs->id ) ? 'danger': 'secondary'}}">{{$course_belongs->course_name}}</a>
                                                    <span class="badge bg-danger" style="
                                                    right:14px;
                                                    border-radius: 62px;
                                                    position: relative;
                                                    font-size: 11px;
                                                    top: -12px;">{{$number_taken_in_this_room_course;}}
                                                    </span>
                                                </h5>
                                                @endif
                                            @endforeach
                                    </div>
                            </div>
                    </div>
                </div>
                {{-- progress --}}
                {{-- fly code to top --}}
        </div>
            <h2 class="m-4"> تعديل القاعة <b>{{$specific_room->room_name}}</b> في مقرر <b>{{$course->course_name}}</b> 
                <div class="" style="float: right;">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h2>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="post" action="/rotations/{{ $rotation->id }}/course/{{ $course->id }}/room/{{ $specific_room->id }}">
                    @method('patch')
                    @csrf
                    <div class="row m-2">
                            <div class="col-sm-9">
                                <label for="num_student_in_room" class="form-label">Number Students In Room <mark>{{$specific_room->room_name}}</mark>  :</label>
                                <select class="form-control" name="num_student_in_room" class="form-control" required>
                                    @if($entered_students_number - ($occupied_number_of_students_in_this_course_not_in_this_room +$occupied_number_of_students_in_this_course_in_this_room) <= $total_capacity)

                                        @if($occupied_number_of_students_in_this_course_in_this_room)
                                            {{-- <option>11</option> --}}
                                            @for ($i = 1; $i <= $occupied_number_of_students_in_this_course_in_this_room; $i++)
                                                <option value="{{$i}}" {{ $occupied_number_of_students_in_this_course_in_this_room == $i ? 'selected':'' }}>{{$i}}</option>
                                            @endfor
                                        @else
                                           {{-- <option>22</option> --}}
                                            @for ($i = 1; $i <= ($entered_students_number - ($occupied_number_of_students_in_this_course_not_in_this_room +$occupied_number_of_students_in_this_course_in_this_room)); $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        @endif
                                    @else
                                    @if($occupied_number_of_students_in_this_course_in_this_room)
                                        {{-- <option>111</option> --}}
                                        @for ($i = 1; $i <= $total_capacity; $i++)
                                            <option value="{{$i}}" {{ $occupied_number_of_students_in_this_course_in_this_room == $i ? 'selected':'' }}>{{$i}}</option>
                                        @endfor
                                    @else
                                        {{-- <option>222</option> --}}
                                        @for ($i = 1; $i <= ($total_capacity); $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    @endif
                                    @endif
                                </select>
                                @if ($errors->has('num_student_in_room'))
                                    <span class="text-danger text-left">{{ $errors->first('num_student_in_room') }}</span>
                                @endif
                            </div>

                        <div class="col-sm-3">
                            {{-- That is not related with controller - Only for Js --}}
                            <label for="search_user_name" class="form-label">Search for members :</label>
                            <input class="form-control" 
                            type="text" 
                            id="search_user_name" 
                            onkeyup="searchForUserName(JSON.stringify({{ App\Models\User::all() }}))" placeholder="Serarch Users">
                        </div>
                    </div>
  
                    <label for="members" class="form-label" style="margin-left:16px;margin-top:16px">members :</label>
                    <div class="mb-3" style="margin:0 5px;">
                        <div class="row num_of_members" style="flex-flow: nowrap;color: black;padding: 6px;background-color: #eceded;border-radius: 15px;width:99%;margin:0 5px">
                            <div class="col-sm-4" style="width:33%;background-color: #f8f9fa;border-radius: 15px 0 0 15px;height: 60px;text-align: center;margin-right:5px">
                                <h1 id="num_roomHeads" style="margin-top: 9px;"></h1>
                            </div>
                            <div class="col-sm-4" style="width:33%;background-color: #f8f9fa;text-align: center;height: 60px;margin-right:5px">
                                <h1 id="num_secertaries" style="margin-top: 9px;"></h1>
                            </div>
                            <div class="col-sm-4" style="width:33.4%;background-color: #f8f9fa;height: 60px;border-radius: 0 15px 15px 0;text-align: center">
                                <h1 id="num_observers" style="margin-top: 9px;"></h1>
                            </div>
                        </div>
                        @php $counter=0; @endphp
                    @foreach(App\Models\User::all() as $user)
                            <?php if($user->id==1) continue; ?>
                                <div id="{{$user->id}}" class="user {{$user->id}} d1 bg-white"" style="display: block;border: 1px solid #d5d5d5;cursor: disabled;
                                border-radius: 7px;width:32.5%;position:relative;float:right;right:6px;
                                padding: 20px 20px 20px 0px;margin:5px;height: 100px;
                                {{--border:{{(count($dates_distinct)==$user->number_of_observation)?'1px solid #dc35467c':''}}--}}
                                ">
                                    <h5 style="float:right;">Room-Head</h5>
                                        <input type="checkbox" style="float:right;"
                                        name="roomheads[{{ $user->id }}]"
                                        value="{{ $user->id }}"
                                        class="roomheads toggler-wrapper style-4"
                                        @if(!in_array($specific_room->id, $joining_rooms))
                                        {{ in_array($user->id, $room_heads_in_this_rotation_course_room)
                                        ? 'checked'
                                        : '' }}
                                        {{ in_array($user->id, $users_in_course_not_in_this_room) || in_array($user->id, $all_disabled_users_in_joining_room)
                                        ? 'disabled'
                                        : '' }}
                                        @elseif(in_array($specific_room->id, $joining_rooms))
                                        {{ in_array($user->id, $room_heads_in_current_joining_in_this_rotation_course_room)
                                            ? 'checked'
                                            : '' }}
                                        {{ in_array($user->id, $users_in_course_not_in_this_room) || in_array($user->id, $pure_disabled_users_for_joining_room)
                                            ? 'disabled'
                                            : '' }}
                                        @endif
                                            >
                                            

                                            <h5 style="float:right;">Secertary</h5>
                                            <input type="checkbox" style="float:right;"
                                            name="secertaries[{{ $user->id }}]"
                                            value="{{ $user->id }}"
                                            class='secertaries toggler-wrapper style-4'
                                            @if(!in_array($specific_room->id, $joining_rooms))
                                            {{ in_array($user->id, $secertaries_in_this_rotation_course_room)
                                                ? 'checked'
                                                : '' }}
                                            {{ in_array($user->id, $users_in_course_not_in_this_room) || in_array($user->id, $all_disabled_users_in_joining_room)
                                                ? 'disabled'
                                                : '' }}
                                            @elseif(in_array($specific_room->id, $joining_rooms))
                                            {{ in_array($user->id, $secertaries_in_current_joining_in_this_rotation_course_room)
                                                ? 'checked'
                                                : '' }}
                                            {{ in_array($user->id, $users_in_course_not_in_this_room) || in_array($user->id, $pure_disabled_users_for_joining_room)
                                                ? 'disabled'
                                                : '' }}
                                            @else
                                            
                                            @endif                                          
                                                >
                                                <h5 style="float:right;">Observer</h5>
                                                <input type="checkbox" style="float:right;"
                                                name="observers[{{ $user->id }}]"
                                                value="{{ $user->id }}"
                                                class='observers toggler-wrapper style-4'
                                                @if(!in_array($specific_room->id, $joining_rooms))
                                                {{ in_array($user->id, $observers_in_this_rotation_course_room)
                                                    ? 'checked'
                                                    : '' }}
                                                {{ in_array($user->id, $users_in_course_not_in_this_room) || in_array($user->id, $all_disabled_users_in_joining_room)
                                                    ? 'disabled'
                                                    : '' }}
                                                @elseif(in_array($specific_room->id, $joining_rooms))
                                                {{ in_array($user->id, $observers_in_current_joining_in_this_rotation_course_room)
                                                    ? 'checked'
                                                    : '' }}
                                                {{ in_array($user->id, $users_in_course_not_in_this_room) || in_array($user->id, $pure_disabled_users_for_joining_room)
                                                    ? 'disabled'
                                                    : '' }}
                                                @else
                                                
                                                @endif  
                                                    >
                                                    <br>
                                                    <h5 style="float:right;align-items:start"><b>{{ $user->username }}</b></h5>
                                                    <h4 style="position: absolute;top:-10px;display:inline-flex"><a href="{{ route('users.observations', $user->id) }}" class="badge bg-
                                                        {{-- {{(count($dates_distinct)==$user->number_of_observation)?'danger':'success'}} --}}
                                                        ">
                                                        {{-- {{count($dates_distinct)}}/{{$user->number_of_observation}} --}}
                                                    </a></h4>
                                </div>
                        @endforeach
                        </div>
                </div>
                <br>
                <div class="buttons" style="margin-top: 80px;float: left;margin-bottom: 30px;">
                    <button type="submit" class="btn btn-dark" {{ (!$occupied_number_of_students_in_this_course_in_this_room && $specific_room->capacity == $occupied_number_of_students_in_this_room_in_all_common_courses) ? 'disabled' : '' }}>Update Course</button>
                    <a href="{{ URL::previous() }}" class="btn btn-default">Cancel</a>
                </div>
        </form>
        <div class="no-results" style="display:none;">No results!</div>
                                
</div>
@endsection