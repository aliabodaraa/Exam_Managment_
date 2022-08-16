@extends('layouts.app-master')

@section('content')
{{-- @php
function ret_room_info($room,$course){
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

    foreach (App\Models\Course::all() as $courseN){
        $is_common++;
        $arr1=[];
        $arr2=[];
        $course_info=[];
        if($courseN->id == $course->id){
            foreach ($courseN->rooms as $roomS){
                if(! in_array($roomS->id, $arr1)){
                        array_push($arr1,$roomS->id);
                        $count_taken_student_in_all_rooms_in_this_course+=$roomS->pivot->num_student_in_room;
                    if ($roomS->id == $room->id){
                         $count_taken_student_in_this_room_in_this_course+=$roomS->pivot->num_student_in_room;
                        array_push($courses_belongs,$courseN->course_name);
                    }else{
                         $count_taken_student_not_in_this_room_in_this_course+=$roomS->pivot->num_student_in_room; 
                         }
                }
            }}
        // }else{
        //     foreach ($courseN->rooms as $roomS){
        //         if(! in_array($roomS->id, $arr2)){
        //             if ($roomS->id == $room->id && $roomS->pivot->date==$course->users[0]->pivot->date && $roomS->pivot->time==$course->users[0]->pivot->time){
        //                     array_push($arr2,$roomS->id);
        //                     $count_taken_student_in_this_room_in_all_common_courses+=$roomS->pivot->num_student_in_room;
        //                     $common[$courseN->course_name]['take']=$count_taken_student_in_this_room_in_all_common_courses;
        //                     array_push($courses_belongs,$courseN->course_name);
        //             }
        //         }
        //     }
        // }                           
        $course_info['courses_belongs']=$courses_belongs;
        $course_info['room_number']=$room->id;
        $course_info['capacity']=$room->capacity;
        $course_info['count_taken_student_in_all_rooms_in_this_course']=$count_taken_student_in_all_rooms_in_this_course;
        $course_info['count_taken_student_in_this_room_in_this_course']=$count_taken_student_in_this_room_in_this_course;
        $course_info['count_taken_student_not_in_this_room_in_this_course']=$count_taken_student_not_in_this_room_in_this_course;
        $course_info['common-info']['num']=$count_taken_student_in_this_room_in_all_common_courses;
        $course_info['common-info']=$common;
        // $course_info['rooms']=$arr1;
        $courses_info[$course->course_name]=$course_info;
        $is_common= (count($course_info['courses_belongs']) > 1 ? true : false);
    }
    return $courses_info;
}
@endphp --}}
    <div class="bg-light p-4 rounded">

        <h1>Update Course
            <div class="" style="float: right;">
                <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        <div class="lead">

        </div>
        <div class="mt-4 p-4 rounded">
            {{-- Succeed Update --}}
            @if ($message_update_course_room = Session::get('update-course-room'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message_update_course_room }}</strong>
            </div>
            @endif
            @if ($ss = Session::get('disabled_rooms'))
                <!-- when you submit -->
                @foreach (array_unique($disabled_common_rooms_send) as $itemArr)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{$ss}}Stop trying to submit The<mark>@php $room_name=App\Models\Room::where('id',$itemArr)->first();echo $room_name->room_name; @endphp</mark>reserves now in anothor course it will free after now for this reason either Un-checked the room Or make both courses in the same time</strong>
                        <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @elseif($disabled_common_rooms_send)
                <!-- when you go to edit page -->
                @foreach (array_unique($disabled_common_rooms_send) as $itemArr)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>The<mark>@php $room_name=App\Models\Room::where('id',$itemArr)->first();echo $room_name->room_name; @endphp</mark>reserves now in anothor course it will free after now for this reason either Un-checked the room Or make both courses in the same time</strong>
                        <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
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
                <div class="row">
                <div class="left col-sm-2" style="float:left">   
                    <div class="mb-3">
                        <label for="email" class="form-label">Course Name :</label>
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
                    <div class="mb-3">
                        <label for="date" class="form-label">date :</label>
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
                        <label for="time" class="form-label">time :</label>
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
                        <label for="students_number" class="form-label">students_number :</label>
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
                        <label for="duration" class="form-label">duration :</label>
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
                </div>
                <div class="right col-sm-10" style="float:right">
                        <label for="rooms" class="form-label">rooms :</label>
                        <div class="mb-3" style="height: 580px;
                        overflow: scroll;">
                            <table class="table table-warning table-striped">
                                <thead>
                                    <th scope="col" width="1%"><input type="checkbox" name="all_rooms" class="toggler-wrapper style-4"></th>
                                    <th scope="col" width="9%">Rooms</th>
                                    <th scope="col" width="20%">common with</th>
                                    <th scope="col" width="10%">Capacity/Occupied</th>
                                    <th scope="col" width="10%">status</th>
                                    <th scope="col" width="30%">Action</th>
                                    @if($disabled_common_rooms_send)
                                    <th scope="col" width="20%">Warrning Message</th>
                                    @endif
                                </thead>
                                @php $num_all_courses_occupied_in_all_rooms=0; @endphp
                                @foreach(App\Models\Room::orderBy('capacity','DESC')->get() as $room)
                                    {{-- info rooms --}}

                                    {{-- info rooms --}}
                                    <tr style="position: relative;top:-1px;">
                                        <td>
                                        {{-- <label class="toggler-wrapper style-4"> --}}
                                            <input type="checkbox"
                                            name="rooms[{{ $room->id }}]"
                                            value="{{ $room->id }}"
                                            class='rooms toggler-wrapper style-4'
                                            {{ in_array($room->id, array_unique($roomsArr))
                                                ? 'checked'
                                                : '' }}
                                            {{ (in_array($room->id, array_unique($disabled_rooms)) &&
                                            ! in_array($room->id, array_unique($accual_common_rooms)))
                                                ? 'disabled'
                                                : '' }}
                                                {{-- {{( $course->students_number==ret_room_info($room,$course)[$course->course_name]['count_taken_student_in_all_rooms_in_this_course'] 
                                                    && !in_array($room->id,$disabled_rooms)
                                                    && !in_array($room->id,$accual_common_rooms)
                                                    && !in_array($room->id,$roomsArr) )?'disabled':''}} --}}
                                                    >
                                                    <div class="toggler-slider">
                                                        <div class="toggler-knob"></div>
                                                    </div>
                                            {{-- </label> --}}
        {{-- <!-- Toggle Button Style 4 -->
            <label class="toggler-wrapper style-4">
                <input type="checkbox" >
                <div class="toggler-slider">
                    <div class="toggler-knob"></div>
                </div>
            </label>
        <!-- End Toggle Button Style 4 -->                                                     --}}
                                        </td>
                                        <td>{{ $room->room_name }}</td>
                                        @php if($course->users[0]->toArray()) 
                                        $common_courses=App\Models\Course::with('rooms')->whereHas('rooms',function($query) use($course,$room)
                                        {$query
                                        ->where('room_id',$room->id)
                                        ->where('date',$course->users[0]->pivot->date)
                                        ->where('time',$course->users[0]->pivot->time); })->get();@endphp
                                            <td>
                                                @php $num_all_courses_occupied_this_room=0; @endphp
                                                <div class="common-courses">
                                                        @foreach ($common_courses as $course_belongs)
                                                            @php
                                                                $number_taken_in_this_room_course=0;
                                                                foreach ($course_belongs->rooms as $onecoom)
                                                                    if($onecoom->id==$room->id)
                                                                    $number_taken_in_this_room_course=$onecoom->pivot->num_student_in_room;
                                                                $num_all_courses_occupied_this_room+=$number_taken_in_this_room_course;
                                                            @endphp
                                                            <a style="text-decoration: none;" href="/courses/{{ $course_belongs->id }}/room/{{ $room->id }}" class="badge bg-{{($course->id == $course_belongs->id ) ? 'danger': 'secondary'}}">{{$course_belongs->course_name}}</a>
                                                            <span class="badge bg-danger" style="
                                                            right:14px;
                                                            border-radius: 62px;
                                                            position: relative;
                                                            font-size: 11px;
                                                            top: -12px;">{{$number_taken_in_this_room_course;}}</span>
                                                        @endforeach
                                                </div>
                                            </td>
                                        <td>
                                            {{-- Capacity / Occupied --}}
                                             @if(in_array($room->id, array_unique($roomsArr)) || in_array($room->id, array_unique($joining_rooms)) || in_array($room->id, array_unique($accual_common_rooms)))
                                                <span class="badge bg-{{($room->capacity - $num_all_courses_occupied_this_room)?'primary':'danger'}}">{{$room->capacity}}/{{$num_all_courses_occupied_this_room}}</span>
                                             @endif 
                                        </td>
                                        <td>
                                            {{-- status --}}
                                            
                                            @if(in_array($room->id, array_unique($roomsArr)) || in_array($room->id, array_unique($joining_rooms)) || in_array($room->id, array_unique($accual_common_rooms)))
                                                <span class="badge bg-{{($room->capacity - $num_all_courses_occupied_this_room)?'secondary':'danger'}}">{{($room->capacity - $num_all_courses_occupied_this_room)?$room->capacity - $num_all_courses_occupied_this_room.' Free':'Full'}}</span>        
                                            @endif
                                        </td>
                                        <td>
                                            @if(in_array($room->id, array_unique($joining_rooms)))
                                            {{-- count_taken_student_in_all_rooms_in_this_course--}}
                                                    <a href="{{ route('courses.room_for_course', ['course'=>$course->id,'specific_room'=>$room->id]) }}" class="btn btn-warning" style="{{true ? '':'pointer-events: none;background-color: #ffc10773;border-color: #ffc10773;'}}">
                                                            Joining
                                                    </a>
                                            @endif
                                            <a href="{{ route('courses.room_for_course', ['course'=>$course->id,'specific_room'=>$room->id]) }}" class="btn @php echo (in_array($room->id,array_unique($accual_common_rooms)))? 'btn-success':'btn-danger'; @endphp"
                                            style="{{ (!in_array($room->id, array_unique($accual_common_rooms))&& in_array($room->id,$disabled_common_rooms_send)) ? 'pointer-events: none;background-color:#999' : '' }} ;display:none;">{{(in_array($room->id,array_unique($accual_common_rooms))) ?'Manage':'specify members'}}
                                            </a>
                                        </td>
                                        @if(in_array($room->id,$disabled_common_rooms_send))
                                            <td>
                                                <span class="badge bg-warning">You Must Un Checked <span class="badge bg-danger">{{$room->room_name}}</span> , Another course use it Now .</span>
                                            </td>
                                        @endif   
                                    </tr>
                                    @php $num_all_courses_occupied_in_all_rooms+=$num_all_courses_occupied_this_room; @endphp
                                @endforeach
                                {{-- fly code to top --}}
                                <h2 class="badge bg-danger" style="position: absolute;top: 163px;left: 343px;{{($course->students_number==$num_all_courses_occupied_in_all_rooms)?'':'display:none'}}">Full</h2>
                                <div class="numbers-info" style="position: absolute;    top: 143px;
                                right: 755px;display: inline-flex;">
                                    <h3 style="float: right;"><span class="badge bg-secondary">students number:{{$course->students_number}}</span></h3>
                                    <span class="badge bg-danger" style="
                                                                right: 268px;
                                                                border-radius: 62px;
                                                                position: relative;
                                                                font-size: 15px;
                                                                height: 28px;
                                                                top: -16px;">{{$course->students_number-$num_all_courses_occupied_in_all_rooms}} free</span>
                                    <span class="badge bg-danger" style="
                                                                right: 109px;
                                                                border-radius: 62px;
                                                                position: relative;
                                                                font-size: 15px;
                                                                height: 28px;
                                                                top: -16px;">{{$num_all_courses_occupied_in_all_rooms}} full</span>
                                </div>
                                {{-- fly code to top --}}
                            </table>
                        </div>
                </div>
            </div>
                <button type="submit" class="btn btn-dark">Update Course</button>
                <a href="{{ route('courses.edit',[$course->id]) }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection
@section('scripts')
{{-- <script type="text/javascript">
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
 </script> --}}
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
