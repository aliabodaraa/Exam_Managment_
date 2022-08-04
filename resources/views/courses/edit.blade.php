@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="numbers-info" style="display:inline-flex;float: right;justify-items:end;">
            <h5 style="float: right;"><span class="badge bg-success">students number:{{$course->students_number}}</span></h5>
            <h5 style="float: right;"><span class="{{($all_category_rooms['sum_student']) ? 'badge bg-info':'badge bg-danger'}}">free students:{{$course->students_number-ceil($all_category_rooms['sum_student'])}}</span></h5>
            <h5 style="float: right;"><span class="badge bg-primary">full number:{{ceil($all_category_rooms['sum_student'])}}</span></h5>
        </div>
        <h1>Update Course <span class="badge bg-danger">{{(!$all_category_rooms['sum_student'])?'Full':''}}</span></h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
            @if ($message_update_course_room = Session::get('update-course-room'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message_update_course_room }}</strong>
            </div>
            @endif
            {{-- @if ($ss = Session::get('disabled_rooms'))
            <div class="alert alert-success alert-block">
                <strong> @dd($ss) </strong>
            </div>
            @endif --}}
            @if(!$all_category_rooms['sum_student'])
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><mark>{{$course->course_name}}</mark> is Full You can release some rooms to become able to edit</strong>
                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($disabled_common_rooms_send)
            @foreach ($disabled_common_rooms_send as $itemArr)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>The<mark>@php $room_name=App\Models\Room::where('id',$itemArr)->first();echo $room_name->room_name; @endphp</mark>reserves now in anothor course it will free after now for this reason either Un-checked the room Or make both courses in the same time</strong>
                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                {{-- <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><mark>{{Str::plural('post',count($disabled_common_rooms_send))}}</mark> were added in the <mark></mark> department</strong>
                    <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> --}}
            @endforeach
            @endif
            @if ($message_detemine_rooms = Session::get('detemine-rooms'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message_detemine_rooms }}</strong>
            </div>
            @endif
            <form method="post" action="{{ route('courses.update', $course->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Course Name</label>
                    <input value="{{ $course->course_name }}"
                        type="text"
                        class="form-control"
                        name="course_name"
                        placeholder="Email address" required>
                    @if ($errors->has('course_name'))
                        <span class="text-danger text-left">{{ $errors->first('course_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="studing_year" class="form-label">Studing Year :</label>
                    <select class="form-control" name="studing_year" class="form-control" required>
                            <option value="1" {{ ($course->studing_year == 1) ? 'selected': '' }}>First Year</option>
                            <option value="2" {{ ($course->studing_year == 2) ? 'selected': '' }}>Secound Year</option>
                            <option value="3" {{ ($course->studing_year == 3) ? 'selected': '' }}>Third Year</option>
                            <option value="4" {{ ($course->studing_year == 4) ? 'selected': '' }}>Fourth Year</option>
                            <option value="5" {{ ($course->studing_year == 5) ? 'selected': '' }}>Fifth Year</option>
                    </select>
                    @if ($errors->has('studing_year'))
                        <span class="text-danger text-left">{{ $errors->first('studing_year') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Semester :</label>
                    <select class="form-control" name="semester" class="form-control" required>
                            <option value='1'  {{ ($course->semester == 1) ? 'selected': '' }}>First Semester</option>
                            <option value='2'  {{ ($course->semester == 2) ? 'selected': '' }}>Secound Semester</option>
                    </select>
                    @if ($errors->has('semester'))
                        <span class="text-danger text-left">{{ $errors->first('semester') }}</span>
                    @endif
                </div>
                <label for="rooms" class="form-label">rooms :</label>
                <div class="mb-3" style="height: 450px;
                overflow: scroll;">
                    <table class="table">
                        <thead>
                            <th scope="col" width="1%"><input type="checkbox" name="all_rooms"></th>
                            <th scope="col" width="9%">Rooms</th>
                            @if($accual_common_rooms)<th scope="col" width="20%">common with</th>@endif
                            <th scope="col" width="10%">Capacity/Occupied</th>
                            <th scope="col" width="10%">status</th>
                            <th scope="col" width="30%">Action</th>
                        </thead>
                        @foreach(App\Models\Room::orderBy('capacity','ASC')->get() as $room)
                            <tr style="position: relative;top:-1px;">
                                <td>
                                    <input type="checkbox"
                                    name="rooms[{{ $room->id }}]"
                                    value="{{ $room->id }}"
                                    class='rooms'
                                    {{ in_array($room->id, array_unique($roomsArr))
                                           ? 'checked'
                                           : '' }}
                                    {{ (in_array($room->id, array_unique($disabled_rooms)) && !in_array($room->id, array_unique($accual_common_rooms))) || ( !in_array($room->id, array_unique($accual_common_rooms))&&! in_array($room->id,$all_category_rooms['single_rooms_in_this_course']) && ! $all_category_rooms['sum_student'])
                                           ? 'disabled'
                                           : '' }}>
                                </td>
                                <td>{{ $room->room_name }}</td>
                                @if($accual_common_rooms)
                                    <td>
                                        <div class="common-courses">
                                            @php $courses_common_with_this_room=App\Models\Course::with('rooms')->whereHas('rooms', function($query) use($course,$room){$query->where('date',$course->rooms[0]->pivot->date)->where('time',$course->rooms[0]->pivot->time)->where('room_id',$room->id)->where('course_id','!=',$course->id);})->get(); @endphp
                                            @if(( in_array($room->id, array_unique($accual_common_rooms))))
                                                @foreach ($courses_common_with_this_room as $course_common)
                                                    <span>
                                                        <span class="badge bg-secondary">{{$course_common->course_name}}</span>
                                                    </span>
                                                @endforeach
                                            @else
                                                @foreach ($courses_common_with_this_room as $course_will)
                                                <span class="badge bg-secondary">{{$course_will->course_name}}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                <td>
                                    {{-- Capacity / Occupied --}}
                                    @if(in_array($room->id,$all_category_rooms['single_rooms_in_this_course']))
                                        @foreach ($all_category_rooms['info'] as $info)
                                            @foreach ($info as $sub_info)
                                                @if($sub_info['number_room']==$room->id)
                                                    {{$room->capacity}}/{{floor($sub_info['room_take'])}}
                                                @endif
                                            @endforeach
                                        @endforeach
                                    {{-- @elseif(in_array($room->id,$all_category_rooms['Joining_rooms_in_this_course']) && in_array($room->id, array_unique($accual_common_rooms)))
                                        @foreach ($all_category_rooms['info-joining'][$room->id] as $key_course_name => $join_courses)
                                            @foreach ($join_courses as $join_info_course)
                                                @if($join_info_course['number_room']==$room->id)
                                                    <span class="badge bg-secondary"><span class="badge bg-primary">{{$room->capacity}}/{{floor($join_info_course['room_take'])}}</span>{{$key_course_name}}</span>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <span class="badge bg-secondary"><span class="badge bg-primary">{{$room->capacity}}/{{floor($join_info_course['room_take'])}}</span>{{$course->course_name}}</span>
                                     --}}
                                        @elseif(in_array($room->id,$all_category_rooms['Joining_rooms_in_this_course']))
                                        @foreach ($all_category_rooms['info-joining'][$room->id] as $key_course_name => $join_courses)
                                            @foreach ($join_courses as $join_info_course)
                                                    @if($join_info_course['number_room']==$room->id)
                                                    <span class="badge bg-secondary"><span class="badge bg-primary">{{$room->capacity}}/{{floor($join_info_course['room_take'])}}</span>{{$key_course_name}}</span>
                                                    @endif
                                                @endforeach
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    {{-- status --}}
                                @php
                                    $num_courses_others_taken =0;
                                    $disabled_join_button = false;
                                @endphp
                                @if(in_array($room->id,$all_category_rooms['single_rooms_in_this_course']))
                                    @foreach ($all_category_rooms['info'] as $info)
                                        @foreach ($info as $sub_info)
                                            @if($sub_info['number_room']==$room->id)
                                                @if($sub_info['capacity']-$sub_info['room_take'] == 0)
                                                    <span class="badge bg-success">Full</span>
                                                @else
                                                    <span class="badge bg-warning">{{ceil($sub_info['capacity']-$sub_info['room_take'])}} Free</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                @elseif(in_array($room->id,$all_category_rooms['Joining_rooms_in_this_course']))
                                    @foreach ($all_category_rooms['info-joining'][$room->id] as $key_course_name => $join_courses)
                                        @foreach ($join_courses as $join_info_course)
                                                @if($join_info_course['number_room']==$room->id)
                                                    @php
                                                        $num_courses_others_taken += floor($join_info_course['room_take'])
                                                    @endphp
                                                @endif
                                            @endforeach
                                    @endforeach
                                    @if($room->capacity - $num_courses_others_taken > 0)
                                        <span class="badge {{(ceil($all_category_rooms['sum_student']) > ceil($room->capacity - $num_courses_others_taken)?'bg-warning':'bg-danger')}}">{{ceil($room->capacity - $num_courses_others_taken )}} Free
                                            @if(ceil($all_category_rooms['sum_student']) > ceil($room->capacity - $num_courses_others_taken))
                                                 ,You can Join with {{ceil($room->capacity - $num_courses_others_taken )}}</span>
                                            @else
                                            ,But you can't join
                                            @endif
                                    @else
                                        @php $disabled_join_button = true; @endphp
                                        {{-- <span class="badge bg-warning">{{ceil($sub_info['capacity']-$sub_info['room_take'])}} Full</span> --}}
                                    @endif
                                 @elseif(in_array($room->id, array_unique($accual_common_rooms))) {{-- Manage Already Joined --}}
                                    <span class="badge bg-success">You Already Join with {{ceil(($room->capacity - $num_courses_others_taken) /2)}}</span>
                                @endif
                                </td>
                                <td>
                                    @if(in_array($room->id, array_unique($joining_rooms)))
                                            <a href="{{ route('courses.room_for_course', ['course'=>$course->id,'specific_room'=>$room->id]) }}" class="btn btn-warning" style="{{ ceil($all_category_rooms['sum_student']) >= ceil($room->capacity-$num_courses_others_taken  || ($all_category_rooms['sum_student']) && ! $disabled_join_button ) ? '':'pointer-events: none;background-color: #ffc10773;border-color: #ffc10773;'}}">
                                                    Joining
                                            </a>
                                    @endif
                                    <a href="{{ route('courses.room_for_course', ['course'=>$course->id,'specific_room'=>$room->id]) }}" class="btn @php echo (in_array($room->id,array_unique($accual_common_rooms)))? 'btn-success':'btn-danger'; @endphp"
                                    style="{{ (!in_array($room->id, array_unique($accual_common_rooms)) && in_array($room->id, $disabled_rooms)) ? 'pointer-events: none;background-color:#999' : '' }} ;display:none;">{{(in_array($room->id,array_unique($accual_common_rooms))) ?'Manage':'specify members'}}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">date</label>
                    <input value="{{$course->rooms[0]->pivot->date}}"
                        type="date"
                        class="form-control"
                        name="date"
                        placeholder="date" required>
                    @if ($errors->has('date'))
                        <span class="text-danger text-left">{{ $errors->first('date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">time</label>
                    <input value="{{$course->rooms[0]->pivot->time}}"
                        type="time"
                        class="form-control"
                        name="time"
                        placeholder="time" required>
                    @if ($errors->has('time'))
                        <span class="text-danger text-left">{{ $errors->first('time') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="students_number" class="form-label">students_number</label>
                    <input value="{{ $course->students_number }}"
                        type="number"
                        class="form-control"
                        name="students_number"
                        placeholder="students_number" required>
                    @if ($errors->has('students_number'))
                        <span class="text-danger text-left">{{ $errors->first('students_number') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">duration</label>
                    <select class="form-control" name="duration" class="form-control" required>
                        <option value="01:00" {{ ($course->duration == "01:00") ? "selected": "" }}>01:00 hours</option>
                        <option value="01:30" {{ ($course->duration == "01:30") ? "selected": "" }}>01:30 hours</option>
                        <option value="02:00" {{ ($course->duration == "02:00") ? "selected": "" }}>2 hours</option>
                        <option value="02:30" {{ ($course->duration == "02:30") ? "selected": ""}}>02:30 hours</option>
                        <option value="03:00" {{ ($course->duration == "03:00") ? "selected": "" }}>03:00 hours</option>
                        <option value="03:30" {{ ($course->duration == "03:30") ? "selected": "" }}>03:30 hours</option>
                        <option value="04:00" {{ ($course->duration == "04:00") ? "selected": "" }}>04:00 hours</option>
                    </select>
                    @if ($errors->has('duration'))
                        <span class="text-danger text-left">{{ $errors->first('duration') }}</span>
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
    let request = new XMLHttpRequest();
    console.log(request.readyState);
    request.onreadystatechange=()=>{
        if(request.readyState==4)
            if(request.status==200)
                console.log(request.responseText);
            else if(request.status==404)
                console.log("Not Found");
    }
request.open("GET","/resources/views/courses/edit.blade.php",true);
request.send();
console.log("Ali");
 </script>
    <script type="text/javascript">
           $(document).ready(function() {
            //show button when rendering the page
                $.each($(".rooms"), function() {
                    if($(this).is(':checked'))
                        $(this).parent().siblings().last().children(":last-child").css({'display': 'initial'});
                });

                $('[name="all_rooms"]').on('click', function() {
                if($(this).is(':checked')) {
                    $.each($('.rooms'), function() {
                        if (!this.disabled)
                            $(this).prop('checked',true);
                    });
                } else {
                    $.each($('.rooms'), function() {
                        $(this).prop('checked',false);
                    });
                }
            });
            //show the button when ckick the checkbox
            $(".rooms").on( 'click', function () {
                    //$(this).parent().siblings().last().css('backgroundColor', 'red');
                    if($(this).is(':checked')){
                        $.each($(this), function() {
                            $(this).parent().siblings().last().children(":last-child").css({'display': 'initial'});
                            $(this).parent().siblings().next().children(".common-courses").css({'display': 'initial'});
                            });
                    } else {
                        $.each($(this), function() {
                            $(this).parent().siblings().last().children(":last-child").css({'display': 'none'});
                            $(this).parent().siblings().next().children(".common-courses").css({'display': 'none'});
                        });
                    }
            });
        });
    </script>
@endsection
