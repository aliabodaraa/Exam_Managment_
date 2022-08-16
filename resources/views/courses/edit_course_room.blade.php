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
            @endforeach
        @else
            @foreach ($courseN->rooms as $room)
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
            <h6><a href="/courses/{{ $current_course_belong->id }}/room/{{ $specific_room->id }}" class="badge bg-primary" style="text-decoration: none;">{{$course_belongs}}<span class="badge bg-danger" style="
                padding: 3px;
                border-radius: 62px;
                position: absolute;
                font-size: 8px;
                top: 113px;
            "> take  {{$course_info['common-info'][$course_belongs]['take']}}</span></a></h6>
            @endforeach
    </div>
    {{-- @endif --}}
    <div class="bg-light p-4 rounded">
        <h2>Update the room <mark>{{$specific_room->room_name}}</mark> in Course <mark>{{$course->course_name}}</mark> 
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
                this Common room take <mark>{{$count_taken_student_in_this_room_in_this_course}}</mark>Place, and other rooms take <mark>{{$count_taken_student_not_in_this_room_in_this_course}}</mark> in this course
            @elseif(count($courses_info[$course->course_name]['courses_belongs']) >= 1 && !$count_taken_student_in_this_room_in_this_course)
            {{-- //Joining room --}}
            this Join room now take <mark>{{$count_taken_student_in_this_room_in_this_course}}</mark>, You can Join Maximum <mark>{{$specific_room->capacity - $count_taken_student_in_this_room_in_all_common_courses}}</mark> Empty Place
            @elseif(count($courses_info[$course->course_name]['courses_belongs']) == 0)
            {{-- single_room does not exist --}}
            single_room does not exist this Common room take <mark>{{$count_taken_student_in_this_room_in_this_course}}
            @elseif(count($courses_info[$course->course_name]['courses_belongs']) == 1)
            {{-- single_room exist --}}
            single_room exist this room take <mark>{{$count_taken_student_in_this_room_in_this_course}}
            @endif
            <br>and all rooms in this course now take :<mark>{{$count_taken_student_in_all_rooms_in_this_course}}/{{$course->students_number}}</mark> person
        </div>

        <div class="">
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
            @php $current_num_of_student = App\Models\User::with('rooms')->whereHas('rooms', function($query) use($specific_room,$course){$query->where('date',$course->users[0]->pivot->date)->where('time',$course->users[0]->pivot->time)->where('room_id',$specific_room->id)->where('course_id',$course->id);})->get();
            $sholder=10;
            $message='';//dd(count($courses_info[$course->course_name]['courses_belongs']));
            //dd($count_taken_student_in_this_room_in_this_course);
            if(count($courses_info[$course->course_name]['courses_belongs']) > 1 && $count_taken_student_in_this_room_in_this_course){
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
            <form method="post" action="{{ route('courses.room_for_course', [$course->id,$specific_room->id]) }}">
                @method('patch')
                @csrf
                @if(count($course->users->toArray()))
                    <div class="mb-3">
                        <label for="num_student_in_room" class="form-label">Number Students In Room <mark>{{$specific_room->room_name}}</mark>  :</label>
                        <select class="form-control" name="num_student_in_room" class="form-control" required {{ (!$count_taken_student_in_this_room_in_this_course && $specific_room->capacity == $count_taken_student_in_this_room_in_all_common_courses) ? 'disabled' : '' }}>
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
                <div class="mb-3">
                <label for="members" class="form-label">members :</label>
                <div class="d">
                @foreach(App\Models\User::all() as $user)
                        <?php if($user->id==1) continue; ?>

                        @php
                            $current_observations_for_all_users=App\Models\User::with('courses')->whereHas('courses',function($query) use($user) {
                                $query->where('user_id',$user->id);
                            })->get();
                            $dates_distinct=[];
                            $times_distinct=[];
                            foreach($current_observations_for_all_users as $current_user)
                                foreach($current_user->courses as $course)
                                    if( (!in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                        ( in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                        (!in_array($course->pivot->date,$dates_distinct) &&  in_array($course->pivot->time,$times_distinct) ) ){
                                                array_push($dates_distinct,$course->pivot->date);
                                                array_push($times_distinct,$course->pivot->time); 
                                    }
                        @endphp
                        @if(true)
                        {{-- @once <span>d1</span>@endonce --}}
                            <div class="d1" style="display: block;
                            background-color: rgba(224, 224, 224, 0.499);
                            border-radius: 7px;
                            padding: 20px 20px 20px 0px;margin:5px;height: 71px;">
                                <h4 style="float:right;">Room-Head</h4>
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
                                        <h4 style="float:right;">Secertary</h4>
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
                                            <h4 style="float:right;">Observer</h4>
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
                                                @endforeach>
                                                <h5 style="margin-left: 150px;"><b>{{ $user->username }}</b></h5>
                                                <h4 style="position: relative;top: -60px;display:inline-flex"><a href="{{ route('users.observations', $user->id) }}" class="badge bg-{{(count($dates_distinct)==$user->number_of_observation)?'danger':'secondary'}}">{{count($dates_distinct)}}/{{$user->number_of_observation}}</a></h4>
                            </div>
                         @else
                            {{-- @once <span>d2</span>@endonce --}}
                            <div class="d2">
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
                <button type="submit" class="btn btn-primary" {{ (!$count_taken_student_in_this_room_in_this_course && $specific_room->capacity == $count_taken_student_in_this_room_in_all_common_courses) ? 'disabled' : '' }}>Update Course</button>
                <a href="{{ route('courses.index') }}" class="btn btn-default">Cancel</a>
            </form>
        </div>

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
        //prevent two checkboxes or more clicked in the same row
        $(".roomheads").on( 'click', function () {
            if($(this).is(':checked')){
                //prevent take more than one Room-Head in the same column
                $.each($('.roomheads'), function() {
                    if (!this.disabled)
                        $(this).prop('checked',false);
                });
                //end prevent
                $(this).next().next().next().next().prop('checked',false);
                $(this).next().next().prop('checked',false);
                $(this).prop('checked',true)
            }
        });


        //calc number of secertaries that checked
        let number_of_secertaries_secertaries_that_checked=0;
        let number_of_secertaries_secertaries_that_not_checked=0;
        $(".secertaries").each(function(){
            if($(this).is(':checked'))
                number_of_secertaries_secertaries_that_checked++;
            else
                number_of_secertaries_secertaries_that_not_checked++;
        });
        console.log(number_of_secertaries_secertaries_that_checked,number_of_secertaries_secertaries_that_not_checked);

        //let x=0;
        $(".secertaries").on( 'click', function () {
            // $(this).each(function(){
            //     if($(this).is(':checked'))
            //         x++;
            //     else if(!$(this).is(':checked'))
            //         x+=10;
            // });
            // if(number_of_secertaries_secertaries_that_checked<2){
            //     console.log('err');}
            if($(this).is(':checked') && number_of_secertaries_secertaries_that_checked < 2){
                $(this).prev().prev().prop('checked',false);
                $(this).next().next().prop('checked',false);
                $(this).prop('checked',true);
                number_of_secertaries_secertaries_that_checked++;
                number_of_secertaries_secertaries_that_not_checked--;
                console.log('err1');
            }else if($(this).is(':checked') && number_of_secertaries_secertaries_that_checked >= 2){
                $(this).prev().prev().prop('checked',false);
                $(this).next().next().prop('checked',false);
                $(this).prop('checked',true);
                number_of_secertaries_secertaries_that_checked++;
                number_of_secertaries_secertaries_that_not_checked--;console.log('err2');
            }else if(!$(this).is(':checked') && number_of_secertaries_secertaries_that_checked < 2){
                number_of_secertaries_secertaries_that_checked--;
                number_of_secertaries_secertaries_that_not_checked++;console.log('err3');
            }else{
                //$(this).prop('checked',false);
                number_of_secertaries_secertaries_that_not_checked++;
                number_of_secertaries_secertaries_that_checked--;console.log('err4');
            }
            console.log(number_of_secertaries_secertaries_that_checked,number_of_secertaries_secertaries_that_not_checked);
            if(number_of_secertaries_secertaries_that_checked>=2){
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
        });
        $(".observers").on( 'click', function () {
            if($(this).is(':checked')){
                $(this).prev().prev().prop('checked',false);
                $(this).prev().prev().prev().prev().prop('checked',false);
                $(this).prop('checked',true)
            }
        });
    });
</script>
@endsection
