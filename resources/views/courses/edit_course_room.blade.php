@extends('layouts.app-master')

@section('content')

{{-- calc all students not in this room in this course --}}
{{-- calc count_taken_student_in_all_rooms_in_this_course in this course --}}
@php
$course_id=$course->id;
    $courses_info=[];
    $common=[];
    $is_common=0;
    $current_room_num_taken_in_all_course=0;
            $count_taken_student_in_all_rooms_in_this_course=0;
            $count_taken_student_in_this_room_in_this_course=0;
            $count_taken_student_not_in_this_room_in_this_course=0;
            $count_taken_student_in_this_room_in_all_common_courses=0;
            $count_taken_student_in_this_room_for_each_common_course=0;
            $courses_belongs=[];
 @endphp

    @foreach (App\Models\Course::all() as $courseN)
        @php
            $is_common++;
            $arr1=[];
            $arr2=[];
            $course_info=[];
        @endphp
        @if($courseN->id == $course->id)
            @foreach ($courseN->rooms as $room)
                @if($room->pivot->rotation_id== $rotation->id)
                    @if(! in_array($room->id, $arr1))
                        @php
                            array_push($arr1,$room->id);
                            $count_taken_student_in_all_rooms_in_this_course+=$room->pivot->num_student_in_room;
                        @endphp
                        @if ($room->id == $specific_room->id)
                            @php $count_taken_student_in_this_room_in_this_course+=$room->pivot->num_student_in_room;
                            array_push($courses_belongs,$courseN->course_name);@endphp
                        @else
                            @php $count_taken_student_not_in_this_room_in_this_course+=$room->pivot->num_student_in_room; @endphp
                        @endif
                    @endif
                @endif
            @endforeach
        @else
            @foreach ($courseN->rooms as $room)
                @if($room->pivot->rotation_id == $rotation->id)
                    @if(! in_array($room->id, $arr2))
                        @if ($room->id == $specific_room->id && $room->pivot->date==$course->users[0]->pivot->date && $room->pivot->time==$course->users[0]->pivot->time)
                            @php
                                array_push($arr2,$room->id);
                                $count_taken_student_in_this_room_in_all_common_courses+=$room->pivot->num_student_in_room;
                                $common[$courseN->course_name]['take']=$room->pivot->num_student_in_room;
                                array_push($courses_belongs,$courseN->course_name);
                            @endphp
                        @endif
                    @endif
                @endif
            @endforeach
        @endif
        @php
            $course_info['courses_belongs']=$courses_belongs;
            $course_info['room_number']=$specific_room->id;
            $course_info['capacity']=$specific_room->capacity;
            $course_info['count_taken_student_in_all_rooms_in_this_course']=$count_taken_student_in_all_rooms_in_this_course;
            $course_info['count_taken_student_in_this_room_in_this_course']=$count_taken_student_in_this_room_in_this_course;
            $course_info['count_taken_student_not_in_this_room_in_this_course']=$count_taken_student_not_in_this_room_in_this_course;
            $course_info['common-info']['num']=$count_taken_student_in_this_room_in_all_common_courses;
            $course_info['common-info']=$common;
            // $course_info['rooms']=$arr1;
            $courses_info[$course->course_name]=$course_info;
            $is_common= (count($course_info['courses_belongs']) > 1 ? true : false)
        @endphp
    @endforeach
@php
$count_taken_student_in_this_room_in_all_common_courses+=$count_taken_student_in_this_room_in_this_course
@endphp
    <div class="info-room" style="display: inline-flex;">
        <h6><span class="badge bg-primary">Room Name : {{$specific_room->room_name}}</span></h6>
        <h6><span class="badge bg-{{(!$count_taken_student_in_this_room_in_this_course && $specific_room->capacity == $count_taken_student_in_this_room_in_all_common_courses) || ($count_taken_student_in_this_room_in_this_course && $specific_room->capacity == $count_taken_student_in_this_room_in_all_common_courses) ? 'danger':'secondary'}}">Capacity : {{$specific_room->capacity}}@if($is_common || count($courses_info[$course->course_name]['courses_belongs']) == 1)/{{$count_taken_student_in_this_room_in_all_common_courses}}@endif</span></h6>
    </div>
    <div class="info-date-time-for-course" style="display: inline-flex;">
        @php $current_course=App\Models\Course::where('id',$course_id)->first();@endphp
        <h6><span class="badge bg-success">Date : {{date('l d-m-Y', strtotime($current_course->rooms[0]->pivot->date))}}</span></h6>
        <h6><span class="badge bg-warning">Time : {{gmdate('H:i A',strtotime($current_course->rooms[0]->pivot->time))}}</span></h6>
    </div>

    {{-- @if($is_common ) considered by joining and manage rooms --}}
    <div class="info" style="display: inline-flex;float:right">
        @if($is_common)<h6><span class="badge bg-dark">Common with :</span></h6>@endif
            @foreach ($courses_info[$course->course_name]['courses_belongs'] as $course_belongs)
            @if($course->course_name==$course_belongs) @php continue; @endphp @endif
            @php $current_course_belong=App\Models\Course::where('course_name',$course_belongs)->first(); @endphp
            <h6><a href="/rotations/{{$rotation->id}}/course/{{$current_course_belong->id}}/room/{{ $specific_room->id }}" class="badge bg-primary" style="text-decoration: none;">{{$course_belongs}}<span class="badge bg-danger" style="
                padding: 3px;
                border-radius: 62px;
                position: absolute;
                font-size: 8px;
                top: 66px;
            "> take  {{$course_info['common-info'][$course_belongs]['take']}}</span></a></h6>
            @endforeach
    </div>
    {{-- @endif --}}
    <div class="bg-light p-4 rounded" id="y">
        <h2>Update the room <b>{{$specific_room->room_name}}</b> in Course <b>{{$course->course_name}}</b> 
            @if((!$count_taken_student_in_this_room_in_this_course && $specific_room->capacity == $count_taken_student_in_this_room_in_all_common_courses))
                <span class="badge bg-danger">The Room Is Full , You Can't Join</span>
                @elseif(($count_taken_student_in_this_room_in_this_course && $specific_room->capacity == $count_taken_student_in_this_room_in_all_common_courses))
                <span class="badge bg-danger">The Room Is Full</span>
            @endif
            <div class="" style="float: right;">
                <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
            </div>
        </h2>
        <div class="lead">
            @if($is_common && $count_taken_student_in_this_room_in_this_course)
                this Common room take <b>{{$count_taken_student_in_this_room_in_this_course}}</b>Place, and other rooms take <b>{{$count_taken_student_not_in_this_room_in_this_course}}</b> in this course
            @elseif(count($courses_info[$course->course_name]['courses_belongs']) >= 1 && !$count_taken_student_in_this_room_in_this_course)
            {{-- //Joining room --}}
            this Join room now take <b>{{$count_taken_student_in_this_room_in_this_course}}</b>, You can Join Maximum <b>{{$specific_room->capacity - $count_taken_student_in_this_room_in_all_common_courses}}</b> Empty Place
            @elseif(count($courses_info[$course->course_name]['courses_belongs']) == 0)
            {{-- single_room does not exist --}}
            single_room does not exist this Common room take <b>{{$count_taken_student_in_this_room_in_this_course}} students</b>
            @elseif(count($courses_info[$course->course_name]['courses_belongs']) == 1)
            {{-- single_room exist --}}
            single_room exist this room take <b>{{$count_taken_student_in_this_room_in_this_course}} students</b>
            @endif
            <br>and all rooms in this course now take :<b>{{$count_taken_student_in_all_rooms_in_this_course}}/{{$course->students_number}}</b> students
        </div>

            @if(in_array($specific_room->id, $common_rooms)) <h5>notes These rooms are common with
                @foreach ($all_common_courses as $course_common)
                    {{$course_common}} ,
                @endforeach 
                ,{{$course->course_name}} any user you choose withh assign in this room for all previous courses</h5>
            @endif
            @if ($message_detemine_rooms = Session::get('detemine-users-in-room'))
                <div class="alert alert-success alert-block">
                    <strong>{{ $message_detemine_rooms }}</strong>
                </div>
            @endif
            @php $current_num_of_student = App\Models\User::with('rooms')->whereHas('rooms', function($query) use($specific_room,$course,$rotation){$query->where('date',$course->users[0]->pivot->date)->where('time',$course->users[0]->pivot->time)->where('room_id',$specific_room->id)->where('course_id',$course->id)->where('rotation_id',$rotation->id);})->get();
            $sholder=10;
            $message='';//dd(count($courses_info[$course->course_name]['courses_belongs']));
            //dd($count_taken_student_in_this_room_in_this_course);
            if($course->students_number-$count_taken_student_in_all_rooms_in_this_course<$specific_room->capacity/2 && count($courses_info[$course->course_name]['courses_belongs']) == 0){
                $sholder=$course->students_number-$count_taken_student_in_all_rooms_in_this_course;
            }elseif(count($courses_info[$course->course_name]['courses_belongs']) > 1 && $count_taken_student_in_this_room_in_this_course){
                //for ($i = 1; $i <= $specific_room->capacity/count($courses_info[$course->course_name]['courses_belongs']); $i++)
                    // if( $count_taken_student_not_in_this_room_in_this_course + $i == $course->students_number ){
                    //     $sholder=$i;
                    //     $message="You can select number of student between 1 and ".$sholder;
                    //     break;
                    // }else{ 
                        $sholder=$specific_room->capacity/count($courses_info[$course->course_name]['courses_belongs']);
                    //}
            }else{ 
                if(count($courses_info[$course->course_name]['courses_belongs']) == 0)//single_room does not exist
                    $sholder=$specific_room->capacity/2;
                elseif(count($courses_info[$course->course_name]['courses_belongs']) >= 1 && !$count_taken_student_in_this_room_in_this_course)//Joining room
                    $sholder=$specific_room->capacity-$count_taken_student_in_this_room_in_all_common_courses;
                elseif(count($courses_info[$course->course_name]['courses_belongs']) == 1)//single_room exist
                    $sholder=$specific_room->capacity/2;
            }
            @endphp
            
            @if($message)
                <span class="badge bg-secondary">{{$message}}</span>
            @endif
            @if(!$sholder)
            <div class="alert alert-warning alert-block">
                <strong>You can't take this room because the course is full</strong>
            </div>
            @endif
            @if($sholder)
                <input class="form-control" 
                type="text" 
                id="search_user_name" 
                name="search_user_name" 
                style="float: right;
                width: 400px;
                right: 72px;
                top: 333px;
                position: absolute;"
                onkeyup="myFunction(JSON.stringify({{ App\Models\User::all() }}))" placeholder="Serarch Users">
            <form method="post" action="/rotations/{{ $rotation->id }}/course/{{ $course->id }}/room/{{ $specific_room->id }}">
                @method('patch')
                @csrf
                @if(count($course->users->toArray()))
                    <div class="mb-3">
                        <label for="num_student_in_room" class="form-label">Number Students In Room <mark>{{$specific_room->room_name}}</mark>  :</label>
                        <select class="form-control" name="num_student_in_room" class="form-control" required {{ ($sholder) ? '' : 'disabled' }}>
                            <!-- $courses_info[$course->course_name]['count_taken_student_in_this_room_in_this_course']) -->
                                    @for ($i = 1; $i <= $sholder; $i++)
                                        <option value="{{$i}}" {{ ($courses_info[$course->course_name]['count_taken_student_in_this_room_in_this_course'] == $i) ? 'selected': '' }}>{{$i}}</option>
                                    @endfor
                            <!-- endif -->
                        </select>
                        @if ($errors->has('num_student_in_room'))
                            <span class="text-danger text-left">{{ $errors->first('num_student_in_room') }}</span>
                        @endif
                    </div>
                @endif
                <label for="members" class="form-label">members :</label>
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

                        @php
                            $current_observations_for_all_users=App\Models\User::with('courses')->whereHas('courses',function($query) use($user,$rotation) {
                                $query->where('user_id',$user->id)->where('rotation_id',$rotation->id);
                            })->get();
                            $dates_distinct=[];
                            $times_distinct=[];
                            foreach($current_observations_for_all_users as $current_user)
                                foreach($current_user->courses as $course)
                                    if($course->pivot->rotation_id == $rotation->id)
                                        if( (!in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                            ( in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                            (!in_array($course->pivot->date,$dates_distinct) &&  in_array($course->pivot->time,$times_distinct) ) ){
                                                    array_push($dates_distinct,$course->pivot->date);
                                                    array_push($times_distinct,$course->pivot->time); 
                                        }
                        @endphp
                        @if(true)
                        {{-- @once <span>d1</span>@endonce --}}
                            <div id="{{$user->id}}" class="user {{$user->id}} d1 bg-white"" style="display: block;border: 1px solid #d5d5d5;cursor: disabled;
                            border-radius: 7px;width:32.5%;position:relative;float:right;right:6px;
                            padding: 20px 20px 20px 0px;margin:5px;height: 100px;border:{{(count($dates_distinct)==$user->number_of_observation)?'1px solid #dc35467c':''}}">
                                <h5 style="float:right;">Room-Head</h5>
                                    <input type="checkbox" style="float:right;"
                                    name="roomheads[{{ $user->id }}]"
                                    value="{{ $user->id }}"
                                    class='roomheads toggler-wrapper style-4'

                                    {{ in_array($user->id, $users_will_in_common_ids["Room_Head"])
                                        ? 'checked'
                                        : '' }}
                                    {{ (!in_array($user->id, $users_will_in_common_ids["Room_Head"])&&!in_array($user->id, $users_will_in_common_ids["Secertary"])&&!in_array($user->id, $users_will_in_common_ids["Observer"]))&&(in_array($user->id, $users_will_in_common_ids["Secertary"])||in_array($user->id, $users_will_in_common_ids["Observer"])||in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
                                        ? 'disabled'
                                        : '' }}
                                        @foreach ( $room_Distinct as  $room_D )
                                            {{($room_D != $specific_room->id &&
                                            (in_array($user->id, $users_in_rooms[$room_D]['roomHeads'])
                                            || in_array($user->id, $users_in_rooms[$room_D]['secertaries'])
                                            || in_array($user->id, $users_in_rooms[$room_D]['observers']))) || (count($dates_distinct)>=$user->number_of_observation && !in_array($user->id, $users_will_in_common_ids["Room_Head"]) && !in_array($user->id, $users_will_in_common_ids["Secertary"]) && !in_array($user->id, $users_will_in_common_ids["Observer"]))  ? 'disabled' : ''}}
                                        @endforeach>
                                        <h5 style="float:right;">Secertary</h5>
                                        <input type="checkbox" style="float:right;"
                                        name="secertaries[{{ $user->id }}]"
                                        value="{{ $user->id }}"
                                        class='secertaries toggler-wrapper style-4'
    
                                        {{ in_array($user->id, $users_will_in_common_ids["Secertary"])
                                            ? 'checked'
                                            : '' }}
                                            {{ (!in_array($user->id, $users_will_in_common_ids["Room_Head"])&&!in_array($user->id, $users_will_in_common_ids["Secertary"])&&!in_array($user->id, $users_will_in_common_ids["Observer"]))&&!in_array($user->id, $users_will_in_common_ids["Secertary"])&&(in_array($user->id, $users_will_in_common_ids["Secertary"])||in_array($user->id, $users_will_in_common_ids["Observer"])||in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
                                            ? 'disabled'
                                            : '' }}
                                            @foreach ( $room_Distinct as  $room_D )
                                                {{($room_D != $specific_room->id &&
                                                (in_array($user->id, $users_in_rooms[$room_D]['roomHeads'])
                                                || in_array($user->id, $users_in_rooms[$room_D]['secertaries'])
                                                || in_array($user->id, $users_in_rooms[$room_D]['observers']))) || (count($dates_distinct)>=$user->number_of_observation && !in_array($user->id, $users_will_in_common_ids["Room_Head"]) && !in_array($user->id, $users_will_in_common_ids["Secertary"]) && !in_array($user->id, $users_will_in_common_ids["Observer"])) ? 'disabled' : ''}}
                                            @endforeach>
                                            <h5 style="float:right;">Observer</h5>
                                            <input type="checkbox" style="float:right;"
                                            name="observers[{{ $user->id }}]"
                                            value="{{ $user->id }}"
                                            class='observers toggler-wrapper style-4'
            
                                            {{ in_array($user->id, $users_will_in_common_ids["Observer"])
                                                ? 'checked'
                                                : '' }}
                                                {{ (!in_array($user->id, $users_will_in_common_ids["Room_Head"])&&!in_array($user->id, $users_will_in_common_ids["Secertary"])&&!in_array($user->id, $users_will_in_common_ids["Observer"]))&&(in_array($user->id, $users_will_in_common_ids["Secertary"])||in_array($user->id, $users_will_in_common_ids["Observer"])||in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
                                                ? 'disabled'
                                                : '' }}
                                                @foreach ( $room_Distinct as  $room_D )
                                                    {{($room_D != $specific_room->id &&
                                                    (in_array($user->id, $users_in_rooms[$room_D]['roomHeads'])
                                                    || in_array($user->id, $users_in_rooms[$room_D]['secertaries'])
                                                    || in_array($user->id, $users_in_rooms[$room_D]['observers']))) || (count($dates_distinct)>=$user->number_of_observation && !in_array($user->id, $users_will_in_common_ids["Room_Head"]) && !in_array($user->id, $users_will_in_common_ids["Secertary"]) && !in_array($user->id, $users_will_in_common_ids["Observer"])) ? 'disabled' : ''}}
                                                @endforeach><br>
                                                <h5 style="float:right;align-items:start"><b>{{ $user->username }}</b></h5>
                                                <h4 style="position: absolute;top:-10px;display:inline-flex"><a href="{{ route('users.observations', $user->id) }}" class="badge bg-{{(count($dates_distinct)==$user->number_of_observation)?'danger':'success'}}">{{count($dates_distinct)}}/{{$user->number_of_observation}}</a></h4>
                            </div>
                         @else
                            {{-- @once <span>d2</span>@endonce --}}
                            <div id="{{$user->id}}" class="user {{$user->id}} d2">
                                    <input type="checkbox"
                                    name="roomheads[{{ $user->id }}]"
                                    value="{{ $user->id }}"
                                    class='roomheads'
                                    {{ (in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads']))
                                        ? 'checked'
                                        : '' }}
                                {{ (in_array($user->id, $users_will_in_common_ids["Room_Head"])||in_array($user->id, $users_will_in_common_ids["Secertary"])||in_array($user->id, $users_will_in_common_ids["Observer"])|| in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr) )&& (!in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries'])&&!in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads'])&&!in_array($user->id, $users_in_rooms[$specific_room->id]['observers']))
                                    ? 'disabled'
                                    : '' }}
                                        @foreach ( $room_Distinct as  $room_D )
                                            {{($room_D != $specific_room->id &&
                                            (in_array($user->id, $users_in_rooms[$room_D]['roomHeads'])
                                            || in_array($user->id, $users_in_rooms[$room_D]['secertaries'])
                                            || in_array($user->id, $users_in_rooms[$room_D]['observers']))) || (count($dates_distinct)>=$user->number_of_observation && !in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads'])&& !in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries'])&& !in_array($user->id, $users_in_rooms[$specific_room->id]['observers'])) ? 'disabled' : ''}}
                                        @endforeach>
                                        <input type="checkbox"
                                        name="secertaries[{{ $user->id }}]"
                                        value="{{ $user->id }}"
                                        class='secertaries'
    
                                        {{ (in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries']))
                                               ? 'checked'
                                               : '' }}
                                               {{ (in_array($user->id, $users_will_in_common_ids["Room_Head"])||in_array($user->id, $users_will_in_common_ids["Secertary"])||in_array($user->id, $users_will_in_common_ids["Observer"])|| in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr) )&& (!in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries'])&&!in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads'])&&!in_array($user->id, $users_in_rooms[$specific_room->id]['observers']))
                                        ? 'disabled'
                                        : '' }}
                                            @foreach ( $room_Distinct as  $room_D )
                                                {{($room_D != $specific_room->id &&
                                                (in_array($user->id, $users_in_rooms[$room_D]['roomHeads'])
                                                || in_array($user->id, $users_in_rooms[$room_D]['secertaries'])
                                                || in_array($user->id, $users_in_rooms[$room_D]['observers']))) || (count($dates_distinct)>=$user->number_of_observation && !in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads'])&& !in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries'])&& !in_array($user->id, $users_in_rooms[$specific_room->id]['observers'])) ? 'disabled' : ''}}
                                            @endforeach>
                                            <input type="checkbox"
                                            name="observers[{{ $user->id }}]"
                                            value="{{ $user->id }}"
                                            class='observers'
        
                                            {{ in_array($user->id, $users_in_rooms[$specific_room->id]['observers'])
                                                   ? 'checked'
                                                   : '' }}
                                                   {{ (in_array($user->id, $users_will_in_common_ids["Room_Head"])||in_array($user->id, $users_will_in_common_ids["Secertary"])||in_array($user->id, $users_will_in_common_ids["Observer"])|| in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr) )&& (!in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries'])&&!in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads'])&&!in_array($user->id, $users_in_rooms[$specific_room->id]['observers']))
                                                ? 'disabled'
                                                : '' }}
                                                @foreach ( $room_Distinct as  $room_D )
                                                    {{($room_D != $specific_room->id &&
                                                    (in_array($user->id, $users_in_rooms[$room_D]['roomHeads'])
                                                    || in_array($user->id, $users_in_rooms[$room_D]['secertaries'])
                                                    || in_array($user->id, $users_in_rooms[$room_D]['observers']))) || (count($dates_distinct)>=$user->number_of_observation && !in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads'])&& !in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries'])&& !in_array($user->id, $users_in_rooms[$specific_room->id]['observers'])) ? 'disabled' : ''}}
                                                @endforeach>
                                                {{ $user->username }}
                                                <td><h4><a href="{{ route('users.observations', $user->id) }}" class="badge bg-{{(count($dates_distinct)==$user->number_of_observation)?'danger':'secondary'}}">{{count($dates_distinct)}}/{{$user->number_of_observation}}</a></h4></td>
                                </div>
                            @endif
                       @endforeach
                    </div>
                </div>
                 @php $current_course=App\Models\Course::where('id',$course_id)->first();@endphp
                {{-- @dd($current_course,$current_course->rooms[0]->pivot->date)  --}}
                <div class="mb-3">
                    <input value="{{$current_course->rooms[0]->pivot->date}}"
                        type="date"
                        class="form-control"
                        name="date"
                        placeholder="date" required hidden>
                    @if ($errors->has('date'))
                        <span class="text-danger text-left">{{ $errors->first('date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <input value="{{$current_course->rooms[0]->pivot->time}}"
                        type="time"
                        class="form-control"
                        name="time"
                        placeholder="time" required hidden>
                    @if ($errors->has('time'))
                        <span class="text-danger text-left">{{ $errors->first('time') }}</span>
                    @endif
                </div>
                <br>
                <div class="buttons" style="margin-top: 80px;float: left;margin-bottom: 30px;">
                    <button type="submit" class="btn btn-dark" {{ (!$count_taken_student_in_this_room_in_this_course && $specific_room->capacity == $count_taken_student_in_this_room_in_all_common_courses) ? 'disabled' : '' }} style="    position: fixed;
                        top: 367px;
                        right: 0;
                        border-radius: 63px;
                        width: 85px;
                        height: 85px;">Update Course</button>
                    <a href="{{ URL::previous() }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
            @endif
            <div class="no-results" style="display:none;">No results!</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('[name="all_roomheads"]').on('click', function() {

            if($(this).is(':checked')) {
                $.each($('.roomheads'), function() {
                    if (!this.disabled)
                        $(this).prop('checked',true);
                });
            } else {
                $.each($('.roomheads'), function() {
                    $(this).prop('checked',false);
                });
            }

        });
        $('[name="all_secertaries"]').on('click', function() {
            if($(this).is(':checked')) {
                $.each($('.secertaries'), function() {
                    if (!this.disabled)
                            $(this).prop('checked',true);
                });
            } else {
                $.each($('.secertaries'), function() {
                    $(this).prop('checked',false);
                });
            }
            });
            $('[name="all_observers"]').on('click', function() {

            if($(this).is(':checked')) {
                $.each($('.observers'), function() {
                    if (!this.disabled)
                            $(this).prop('checked',true);
                });
            } else {
                $.each($('.observers'), function() {
                    $(this).prop('checked',false);
                });
            }
        });

        //calc number of secertaries that checked
        let number_of_secertaries_that_checked=0;
        let number_of_secertaries_that_not_checked=0;

        let number_of_observers_that_checked=0;
        let number_of_roomheads_that_checked=0;
        $(".secertaries").each(function(){
            if($(this).is(':checked'))
                number_of_secertaries_that_checked++;
            else
                number_of_secertaries_that_not_checked++;
        });

        if(number_of_secertaries_that_checked>=2){
                $(".secertaries").each(function(){
                    if(!$(this).is(':checked'))
                        $(this).prop('disabled',true);
                });
            }else{
                $(".secertaries").each(function(){
                    if(!$(this).is(':checked')&& !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                        $(this).prop('disabled',false);
                });
            }


        console.log(number_of_secertaries_that_checked,number_of_secertaries_that_not_checked);  
        $(".observers").each(function(){
            if($(this).is(':checked'))
            number_of_observers_that_checked++;
        });
        $(".roomheads").each(function(){
            if($(this).is(':checked'))
            number_of_roomheads_that_checked++;
        });

                
            $('#num_roomHeads').text(`${number_of_roomheads_that_checked} roomHeads`);
            $('#num_secertaries').text(`${number_of_secertaries_that_checked} secertaries`);
            $('#num_observers').text(`${number_of_observers_that_checked} observers`)
        
        //prevent two checkboxes or more clicked in the same row
        $(".roomheads").on( 'click', function () {
            if($(this).is(':checked')){
                number_of_roomheads_that_checked=1;
                //prevent take more than one Room-Head in the same column
                $.each($('.roomheads'), function() {
                    if (!this.disabled)
                        $(this).prop('checked',false);
                });
                //end prevent
                if($(this).next().next().next().next().prop('checked')){
                    number_of_observers_that_checked--;
                    $(this).next().next().next().next().prop('checked',false);
                }
                //$(this).next().next().prop('checked',false);
                $(this).prop('checked',true);
                if($(this).next().next().prop('checked')){
                    $(this).next().next().prop('checked',false);
                    number_of_secertaries_that_not_checked++;
                    number_of_secertaries_that_checked--;
                    //when you swich betwen secertary to observer in the same person
                    if(number_of_secertaries_that_checked>=2){
                        $(".secertaries").each(function(){
                            if(!$(this).is(':checked'))
                                $(this).prop('disabled',true);
                        });
                    }else{
                        $(".secertaries").each(function(){
                            if(!$(this).is(':checked')&& !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                                $(this).prop('disabled',false);
                        });
                    }
                }
            }else{
                number_of_roomheads_that_checked--;
            }
            //number_of_roomheads_that_checked++;
            if(number_of_roomheads_that_checked ==1){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_roomheads_that_checked ==0){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }
            if(number_of_secertaries_that_checked ==2){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_secertaries_that_checked ==0){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
            if(number_of_observers_that_checked >=2){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_observers_that_checked ==0){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
        });



        //let x=0;
        $(".secertaries").on( 'click', function () {
            if($(this).is(':checked') && $(this).next().next().prop('checked')){
                number_of_observers_that_checked--;
            }
            if($(this).is(':checked') && $(this).prev().prev().prop('checked')){
                number_of_roomheads_that_checked--;
            }
            if($(this).is(':checked') && number_of_secertaries_that_checked < 2){
                // if($(this).next().next().prop('checked')){
                //     number_of_observers_that_checked--;
                // }else if($(this).prev().prev().prop('checked')){
                //     number_of_roomheads_that_checked--;
                // }
                $(this).prev().prev().prop('checked',false);
                $(this).next().next().prop('checked',false);
                $(this).prop('checked',true);
                number_of_secertaries_that_checked++;
                number_of_secertaries_that_not_checked--;
                console.log('err1');
            }else if($(this).is(':checked') && number_of_secertaries_that_checked >= 2){
                $(this).prev().prev().prop('checked',false);
                $(this).next().next().prop('checked',false);
                $(this).prop('checked',true);
                number_of_secertaries_that_checked++;
                number_of_secertaries_that_not_checked--;console.log('err2');
            }else if(!$(this).is(':checked') && number_of_secertaries_that_checked < 2){
                number_of_secertaries_that_checked--;
                number_of_secertaries_that_not_checked++;console.log('err3');
            }else{
                //$(this).prop('checked',false);
                number_of_secertaries_that_not_checked++;
                number_of_secertaries_that_checked--;console.log('err4');
            }
            console.log(number_of_secertaries_that_checked,number_of_secertaries_that_not_checked);
            if(number_of_secertaries_that_checked>=2){
                $(".secertaries").each(function(){
                    if(!$(this).is(':checked'))
                        $(this).prop('disabled',true);
                });
            }else{
                $(".secertaries").each(function(){
                    if(!$(this).is(':checked')&& !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                        $(this).prop('disabled',false);
                });
            }
            if(number_of_roomheads_that_checked ==1){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_roomheads_that_checked ==0){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }
            if(number_of_secertaries_that_checked ==2){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_secertaries_that_checked ==0){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
            if(number_of_observers_that_checked >=2){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_observers_that_checked ==0){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
        });
        $(".observers").on( 'click', function () {
            if($(this).is(':checked')){
                number_of_observers_that_checked++;
                if($(this).prev().prev().prop('checked')){
                    $(this).prev().prev().prop('checked',false);
                    number_of_secertaries_that_not_checked++;
                    number_of_secertaries_that_checked--;
                    //when you swich betwen secertary to observer in the same person
                    if(number_of_secertaries_that_checked>=2){
                    $(".secertaries").each(function(){
                        if(!$(this).is(':checked'))
                            $(this).prop('disabled',true);
                    });
                    }else{
                        $(".secertaries").each(function(){
                            if(!$(this).is(':checked')&& !$(this).prev().prev().prop('disabled') && !$(this).next().next().prop('disabled'))
                                $(this).prop('disabled',false);
                        });
                    }
                }else if($(this).prev().prev().prev().prev().prop('checked')){
                    $(this).prev().prev().prev().prev().prop('checked',false);
                        number_of_roomheads_that_checked--;
                }
            }else if(!$(this).is(':checked')){
                number_of_observers_that_checked--;
            }
            if(number_of_roomheads_that_checked ==1){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_roomheads_that_checked ==0){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }
            if(number_of_secertaries_that_checked ==2){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_secertaries_that_checked ==0){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
            if(number_of_observers_that_checked >=2){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_observers_that_checked ==0){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
        });
         let num_observers=`<h6><span class="badge bg-dark">${number_of_observers_that_checked}</span></h6>`;
         let num_secertaries=`<h6><span class="badge bg-dark">${number_of_secertaries_that_checked}</span></h6>`;
        // var $newdiv1 = $( `<div id='yy'>${num-observers}</div>` );
        // $( "span" ).append($newdiv1);
        // $('.rounded').prepend(`<span> I have been appended ${num_observers}</span>`);
        // $('.rounded').prepend(`<span> I have been appended ${num_secertaries}</span>`);
        // let i=0;
        // const timer=setInterval(()=>{
        // ++i;
        // if(i === 1000){
        // clearInterval(timer);
        // }
        // $('.rounded').prepend(`<span>${num_observers}</span>`);
        // $('.rounded').prepend(`<span>${num_secertaries}</span>`);
        // },200);
        if(number_of_roomheads_that_checked ==1){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_roomheads_that_checked ==0){
                $('#num_roomHeads').html(`${number_of_roomheads_that_checked} roomHeads <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }
            if(number_of_secertaries_that_checked ==2){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_secertaries_that_checked ==0){
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_secertaries').html(`${number_of_secertaries_that_checked} secertaries <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
            if(number_of_observers_that_checked >=2){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_success" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }else if(number_of_observers_that_checked ==0){
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_danger" src="{{ asset('images/danger2.png') }}" alt="danger" style="width: 30px;height: 30px;">`);
            }else{
                $('#num_observers').html(`${number_of_observers_that_checked} observers <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="success" style="width: 30px;height: 30px;">`);
            }
            





    //Filtering Start
            myFunction=(x)=>{
                let users=JSON.parse(x);
                $(".user").hide();
                jQuery.each(users, function(id) {
                    if (users[id]["username"].indexOf($('#search_user_name').val()) > -1 )
                        $("#"+users[id]["id"]).show();
                });
            }
    //Filtering End

    });




    
</script>
@endsection
