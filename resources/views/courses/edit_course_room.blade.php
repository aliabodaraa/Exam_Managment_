@extends('layouts.app-master')

@section('content')
{{-- calc all students not in this room in this course --}}
{{-- calc count_taken_student_in_all_rooms_in_this_course in this course --}}
@php
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
                            $common[$courseN->course_name]['take']=$count_taken_student_in_this_room_in_all_common_courses;
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

    <div class="info" style="display: inline-flex;">
        <h6><span class="badge bg-info">Room Name : {{$specific_room->room_name}}</span></h6>
        <h6><span class="badge bg-secondary">Capacity : {{$specific_room->capacity}}</span></h6>
    </div>
    @if($is_common)
    <div class="info" style="display: inline-flex;float:right">
            <h6><span class="badge bg-info">Common with :</span></h6>
            @foreach ($courses_info[$course->course_name]['courses_belongs'] as $course_belongs)
            @if($course->course_name==$course_belongs) @php continue; @endphp @endif
            <h6><span class="badge bg-primary">{{$course_belongs}}<span class="badge bg-danger" style="
                padding: 3px;
                border-radius: 62px;
                position: absolute;
                font-size: 8px;
                top: 113px;
            "> take  {{$course_info['common-info'][$course_belongs]['take']}}</span></span></h6>
            @endforeach
    </div>
    @endif
    <div class="bg-light p-4 rounded">
        <h2>Update the room <mark>{{$specific_room->room_name}}</mark> in Course <mark>{{$course->course_name}}</mark> </h2>
        <div class="lead">
            @if($is_common)
                this Common room take <mark>{{$count_taken_student_in_this_room_in_this_course}}</mark> and other rooms take <mark>{{$count_taken_student_not_in_this_room_in_this_course}}</mark> in this course
            @else
                this Common room take <mark>{{$count_taken_student_in_this_room_in_this_course}}</mark> and other rooms take <mark>{{$count_taken_student_not_in_this_room_in_this_course}}</mark> in this course
            @endif
            the course now take :<mark>{{$count_taken_student_in_all_rooms_in_this_course}}/{{$course->students_number}}</mark> person
        </div>

        <div class="container mt-4">
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
            @php $current_num_of_student = App\Models\User::with('rooms')->whereHas('rooms', function($query) use($specific_room,$course){$query->where('date',$course->users[0]->pivot->date)->where('time',$course->users[0]->pivot->time)->where('room_id',$specific_room->id)->where('course_id',$course->id);})->get(); @endphp
            @php
            $sholder=10;
            $message='';
            if($count_taken_student_not_in_this_room_in_this_course + $specific_room->capacity/2 > $course->students_number){
                for ($i = 1; $i <= $specific_room->capacity/2; $i++)
                    if( $count_taken_student_not_in_this_room_in_this_course + $i == $course->students_number ){
                        $sholder=$i;
                        $message="You can select number of student between 1 and ".$sholder;
                        break;
                    }
                }else{ 
                    $sholder=$specific_room->capacity/2;}
            @endphp
            @if($message)
                <span class="badge bg-secondary" style="float:right">{{$message}}</span>
            @endif
            <form method="post" action="{{ route('courses.room_for_course', [$course->id,$specific_room->id]) }}">
                @method('patch')
                @csrf
                @if(count($course->users->toArray()))
                    <div class="mb-3">
                        <label for="num_student_in_room" class="form-label">Number Students In Room <mark>{{$specific_room->room_name}}</mark>  :</label>
                        <select class="form-control" name="num_student_in_room" class="form-control" required>
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
                    <table class="table">
                        <thead>
                            <th scope="col" width="1%"><input type="checkbox" name="all_roomheads"></th>
                            <th scope="col" width="30%">Room-Heads</th>
                            <th scope="col" width="1%"><input type="checkbox" name="all_secertaries"></th>
                            <th scope="col" width="30%">Secertaries</th>
                            <th scope="col" width="1%"><input type="checkbox" name="all_observers"></th>
                            <th scope="col" width="30%">Observers</th>
                        </thead>
                        @foreach(App\Models\User::all() as $user)
                        @if(in_array($specific_room->id,$disabled_rooms))
          @once <span>d1</span>@endonce
                        <tr>
                            <td>
                                <input type="checkbox"
                                name="roomheads[{{ $user->id }}]"
                                value="{{ $user->id }}"
                                class='roomheads'

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
                                        || in_array($user->id, $users_in_rooms[$room_D]['observers']))) ? 'disabled' : ''}}
                                    @endforeach>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <input type="checkbox"
                                name="secertaries[{{ $user->id }}]"
                                value="{{ $user->id }}"
                                class='secertaries'

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
                                        || in_array($user->id, $users_in_rooms[$room_D]['observers']))) ? 'disabled' : ''}}
                                    @endforeach>
                            </td>
                            {{-- 'course','secertaryArr','disabled_secertaryArr','roomHeadArr','disabled_roomHeadArr','observerArr','disabled_observerArr' --}}
                            <td>{{ $user->username }}</td>
                            <td>
                                <input type="checkbox"
                                name="observers[{{ $user->id }}]"
                                value="{{ $user->id }}"
                                class='observers'

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
                                        || in_array($user->id, $users_in_rooms[$room_D]['observers']))) ? 'disabled' : ''}}
                                    @endforeach>
                            </td>
                            <td>{{ $user->username }}</td>
                        </tr>
                         @elseif(!in_array($specific_room->id, $common_rooms) && !in_array($specific_room->id,$disabled_rooms))
                         @once <span>d2</span>@endonce
                            <tr>
                                <td>
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
                                            || in_array($user->id, $users_in_rooms[$room_D]['observers']))) ? 'disabled' : ''}}
                                        @endforeach>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>
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
                                            || in_array($user->id, $users_in_rooms[$room_D]['observers']))) ? 'disabled' : ''}}
                                        @endforeach>
                                </td>
                                {{-- 'course','secertaryArr','disabled_secertaryArr','roomHeadArr','disabled_roomHeadArr','observerArr','disabled_observerArr' --}}
                                <td>{{ $user->username }}</td>
                                <td>
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
                                            || in_array($user->id, $users_in_rooms[$room_D]['observers']))) ? 'disabled' : ''}}
                                        @endforeach>
                                </td>
                                <td>{{ $user->username }}</td>
                            </tr>


                       @endif
                       @endforeach
                    </table>
                </div>
                <div class="mb-3">
                    <input value="{{$course->rooms[0]->pivot->date}}"
                        type="date"
                        class="form-control"
                        name="date"
                        placeholder="date" required hidden>
                    @if ($errors->has('date'))
                        <span class="text-danger text-left">{{ $errors->first('date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <input value="{{$course->rooms[0]->pivot->time}}"
                        type="time"
                        class="form-control"
                        name="time"
                        placeholder="time" required hidden>
                    @if ($errors->has('time'))
                        <span class="text-danger text-left">{{ $errors->first('time') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update Course</button>
                <a href="{{ route('courses.index') }}" class="btn btn-default">Cancel</button>
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
                $(this).parent().next().next().siblings().children(":first-child").css({'backgroundColor': 'red'}).prop('checked',false);
                $(this).parent().next().siblings().children(":first-child").prop('checked',false);
                $(this).prop('checked',true)
            }
        });
        $(".secertaries").on( 'click', function () {
            if($(this).is(':checked')){
                $(this).parent().prev().siblings().children(":first-child").css({'backgroundColor': 'red'}).prop('checked',false);
                $(this).parent().next().siblings().children(":first-child").prop('checked',false);
                $(this).prop('checked',true)
            }
        });
        $(".observers").on( 'click', function () {
            if($(this).is(':checked')){
                $(this).parent().next().siblings().children(":first-child").prop('checked',false);
                $(this).parent().next().next().siblings().children(":first-child").css({'backgroundColor': 'red'}).prop('checked',false);
                $(this).prop('checked',true)
            }
        });
    });
</script>
@endsection
