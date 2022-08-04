@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update {{$specific_room->room_name}} Course {{$course->course_name}}</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
            @if(in_array($specific_room->id, $common_rooms)) <h5>notes These rooms are common with
                @foreach ($all_common_courses as $course_common)
                {{$course_common}} ,
                @endforeach ,{{$course->course_name}} any user you choose withh assign in this room for all previous courses</h5>
            @endif
            @if ($message_detemine_rooms = Session::get('detemine-users-in-room'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message_detemine_rooms }}</strong>
            </div>
            @endif
            <form method="post" action="{{ route('courses.room_for_course', [$course->id,$specific_room->id]) }}">
                @method('patch')
                @csrf
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
<h1>d1</h1>
                        <tr>
                            <td>
                                <input type="checkbox"
                                name="roomheads[{{ $user->id }}]"
                                value="{{ $user->id }}"
                                class='roomheads'

                                {{ in_array($user->id, $users_will_in_common_ids)
                                    ? 'checked'
                                    : '' }}
                                {{ !in_array($user->id, $users_will_in_common_ids)&&(in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
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
                                {{ !in_array($user->id, $users_will_in_common_ids)&&(in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
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
                                {{ !in_array($user->id, $users_will_in_common_ids)&&(in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
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
                         <h1>d2</h1>
                            <tr>
                                <td>
                                    <input type="checkbox"
                                    name="roomheads[{{ $user->id }}]"
                                    value="{{ $user->id }}"
                                    class='roomheads'
                                    {{ (in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads']))
                                        ? 'checked'
                                        : '' }}
                                    {{ !in_array($user->id, $users_in_rooms[$specific_room->id]['roomHeads'])&&(in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
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
                                    {{ !in_array($user->id, $users_in_rooms[$specific_room->id]['secertaries'])&&(in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
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
                                    {{ !in_array($user->id, $users_in_rooms[$specific_room->id]['observers'])&&(in_array($user->id, $disabled_secertaryArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_observerArr))
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
                       @elseif(!in_array($specific_room->id, $common_rooms))
                       <h1>d3</h1>
                       <?php
                       //code 1 falsy
                    //    $users_common=[];
                    //    $coos=User::whereIn('íd',$users_commom_courses['roomHeads'])->where('id',$user->id)->get();
                    //    foreach (App\Models\User::whereIn('íd',$users_commom_courses['roomHeads'])->where('id',$user->id)->get() as $user_common) {
                    //     array_push($users_common,$user_common->id);//Why??????????
                    //    }
                    //code 2 truely
                        // $users_common=[];
                        // foreach (App\Models\User::all() as $user) {
                        //  if(in_array($user->id, $users_commom_courses['roomHeads']) ||in_array($user->id, $users_commom_courses['secertaries'])||in_array($user->id, $users_commom_courses['observers']) )
                        //  array_push($users_common,$user->id);//True :)
                        // }
                       ?>
                            <tr>
                                <td>
                                    <input type="checkbox"
                                    name="roomheads[{{ $user->id }}]"
                                    value="{{ $user->id }}"
                                    class='roomheads'
                                    {{ in_array($user->id, $users_commom_courses['roomHeads'])
                                    ? 'checked'
                                    : '' }}
                                    {{-- {{ !in_array($user->id, $users_commom_courses['roomHeads'])&&(in_array($user->id, $disabled_observerArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_secertaryArr))
                                        ? 'disabled'
                                        : '' }} --}}
                                        {{
                                            (!in_array($user->id, $users_commom_courses['roomHeads'])&& !in_array($user->id, $users_commom_courses['secertaries'])&&!in_array($user->id, $users_commom_courses['observers']))&&(in_array($user->id, $disabled_roomHeadArr)
                                            || in_array($user->id, $disabled_secertaryArr)
                                            || in_array($user->id, $disabled_observerArr)) ? 'disabled' : ''
                                        }}
                                    @foreach ( App\Models\Room::all() as  $room_D )
                                        {{($room_D->id != $specific_room->id &&
                                        (in_array($user->id, $users_in_rooms[$room_D->id]['roomHeads'])
                                        || in_array($user->id, $users_in_rooms[$room_D->id]['secertaries'])
                                        || in_array($user->id, $users_in_rooms[$room_D->id]['observers']))) ? 'disabled' : ''}}
                                    @endforeach>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <input type="checkbox"
                                    name="secertaries[{{ $user->id }}]"
                                    value="{{ $user->id }}"
                                    class='secertaries'
                                    {{ in_array($user->id, $users_commom_courses['secertaries'])
                                    ? 'checked'
                                    : '' }}
                                    {{-- {{ !in_array($user->id, $users_commom_courses['secertaries'])&&(in_array($user->id, $disabled_observerArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_secertaryArr))
                                    ? 'disabled'
                                    : '' }} --}}
                                    {{
                                        (!in_array($user->id, $users_commom_courses['roomHeads'])&& !in_array($user->id, $users_commom_courses['secertaries'])&&!in_array($user->id, $users_commom_courses['observers']))&&(in_array($user->id, $disabled_roomHeadArr)
                                        || in_array($user->id, $disabled_secertaryArr)
                                        || in_array($user->id, $disabled_observerArr)) ? 'disabled' : ''
                                    }}
                                    @foreach ( App\Models\Room::all() as  $room_D )
                                        {{($room_D->id != $specific_room->id &&
                                        (in_array($user->id, $users_in_rooms[$room_D->id]['roomHeads'])
                                        || in_array($user->id, $users_in_rooms[$room_D->id]['secertaries'])
                                        || in_array($user->id, $users_in_rooms[$room_D->id]['observers']))) ? 'disabled' : ''}}
                                    @endforeach>
                                </td>
                                {{-- 'course','secertaryArr','disabled_secertaryArr','roomHeadArr','disabled_roomHeadArr','observerArr','disabled_observerArr' --}}
                                <td>{{ $user->username }}</td>
                                <td>
                                    <input type="checkbox"
                                    name="observers[{{ $user->id }}]"
                                    value="{{ $user->id }}"
                                    class='observers'
                                    {{ in_array($user->id, $users_commom_courses['observers'])
                                    ? 'checked'
                                    : '' }}
                                    {{-- {{ !in_array($user->id, $users_commom_courses['observers'])&&(in_array($user->id, $disabled_observerArr) || in_array($user->id, $disabled_roomHeadArr) || in_array($user->id, $disabled_secertaryArr))
                                        ? 'disabled'
                                        : '' }} --}}
                                        {{
                                            (!in_array($user->id, $users_commom_courses['roomHeads'])&& !in_array($user->id, $users_commom_courses['secertaries'])&&!in_array($user->id, $users_commom_courses['observers']))&&(in_array($user->id, $disabled_roomHeadArr)
                                            || in_array($user->id, $disabled_secertaryArr)
                                            || in_array($user->id, $disabled_observerArr)) ? 'disabled' : ''
                                        }}
                                    @foreach (App\Models\Room::all() as  $room_D )
                                        {{($room_D->id != $specific_room->id &&
                                        (in_array($user->id, $users_in_rooms[$room_D->id]['roomHeads'])
                                        || in_array($user->id, $users_in_rooms[$room_D->id]['secertaries'])
                                        || in_array($user->id, $users_in_rooms[$room_D->id]['observers']))) ? 'disabled' : ''}}
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
