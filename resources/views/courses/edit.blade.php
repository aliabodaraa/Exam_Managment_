@extends('layouts.app-master')

@section('content')
{{-- @php $foo = "105";
dd( number_format((float)$foo, 2, '.', '')); @endphp --}}
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

        <h1>
            Update Course
            <div class="float-right">
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
                        <strong>{{$ss}}Stop trying to submit The<b>@php $room_name=App\Models\Room::where('id',$itemArr)->first();echo $room_name->room_name; @endphp</b>reserves now in anothor course it will free after now for this reason either Un-checked the room Or make both courses in the same time</strong>
                        <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @elseif($disabled_common_rooms_send)
                <!-- when you go to edit page -->
                @foreach (array_unique($disabled_common_rooms_send) as $itemArr)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>The<b>@php $room_name=App\Models\Room::where('id',$itemArr)->first();echo $room_name->room_name; @endphp</b>reserves now in anothor course it will free after now for this reason either Un-checked the room Or make both courses in the same time</strong>
                        <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif
            @if ($message_detemine_rooms = Session::get('detemine-rooms'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message_detemine_rooms }}</strong>
            </div>
            @endif
            <form method="post" action="/rotations/{{$rotation->id}}/course/{{$course->id}}/update">
                @method('patch')
                @csrf
                <div class="row">
                <div class="left col-sm-3" style="float:left">   
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
                    {{-- <div class="mb-3">
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
                    </div> --}}
                    <div class="mb-3">
                        <label for="faculty_id" class="form-label">faculty_id</label>
                        <select class="form-control" name="faculty_id" class="form-control" required>
                            @foreach (App\Models\Faculty::all() as $faculty)
                                <option value='{{ $faculty->id }}' {{ ($course->faculty->id == $faculty->id) ? 'selected': '' }}>{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('faculty_id'))
                            <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="right col-sm-9" style="float:right">
                        <label for="rooms" class="form-label">rooms :</label>
                        <div class="mb-3" style="height: 580px;
                        overflow: scroll;">
                            <table class="table table-light">
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
                                @foreach(App\Models\Room::all() as $room)
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
                                            <!-- End Toggle Button Style 4 -->--}}
                                        </td>
                                        <td>{{ $room->room_name }}</td>
                                        @php if($course->users[0]->toArray()) 
                                        $common_courses=App\Models\Course::with('rooms')->whereHas('rooms',function($query) use($course,$room,$rotation){$query
                                        ->where('room_id',$room->id)
                                        ->where('date',$course->users[0]->pivot->date)
                                        ->where('time',$course->users[0]->pivot->time)
                                        ->where('rotation_id',$rotation->id); })->get();@endphp
                                            <td>
                                                @php $num_all_courses_occupied_this_room=0; @endphp
                                                <div class="common-courses">
                                                        @foreach ($common_courses as $course_belongs)
                                                            @php
                                                                $number_taken_in_this_room_course=0;
                                                                foreach ($course_belongs->rooms as $onecoom)
                                                                    if($onecoom->id==$room->id && $onecoom->pivot->rotation_id==$rotation->id)
                                                                        $number_taken_in_this_room_course=$onecoom->pivot->num_student_in_room;
                                                                $num_all_courses_occupied_this_room+=$number_taken_in_this_room_course;
                                                            @endphp
                                                            <a style="text-decoration: none;" href="/rotations/{{ $rotation->id }}/courses/{{ $course_belongs->id }}/edit" class="badge bg-{{($course->id == $course_belongs->id ) ? 'danger': 'secondary'}}">{{$course_belongs->course_name}}</a>
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
                                                    <a href="/rotations/{{ $rotation->id }}/course/{{ $course->id }}/room/{{ $room->id }}" class="btn btn-warning" style="{{$course->students_number>$number_students_in_this_course ? '':'pointer-events: none;background-color: #ffc10773;border-color: #ffc10773;'}}">
                                                            Joining
                                                    </a>
                                            @endif
                                            <a href="/rotations/{{ $rotation->id }}/course/{{ $course->id }}/room/{{ $room->id }}" class="btn @php echo (in_array($room->id,array_unique($accual_common_rooms)))? 'btn-success':'btn-danger'; @endphp"
                                                {{-- /{{ route('courses.get_room_for_course', ['rotation'=>$rotation->id,'course'=>$course->id,'specific_room'=>$room->id]) }} --}}
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
                                {{-- <h2 class="badge bg-danger" style="position: absolute;top: 163px;left: 343px;{{($course->students_number==$num_all_courses_occupied_in_all_rooms)?'':'display:none'}}">Full</h2>
                                <div class="numbers-info-full-free" style="position: absolute;
                                top: 200px;
                                right: 23px;
                                display: inline-flex;">
                                    <h4 style="float: right;"><span class="badge bg-secondary">students number:{{$course->students_number}}</span></h4>
                                    <span class="badge bg-danger" style="right: 226px;
                                                                        border-radius: 5px;
                                                                        position: relative;
                                                                        font-size: 15px;
                                                                        height: 28px;
                                                                        top: -21px;">{{$course->students_number-$num_all_courses_occupied_in_all_rooms}} free</span>
                                    <span class="badge bg-danger" style="right: 111px;
                                                                        border-radius: 5px;
                                                                        position: relative;
                                                                        font-size: 15px;
                                                                        height: 28px;
                                                                        top: -21px;">{{$num_all_courses_occupied_in_all_rooms}} full</span>
                                </div> --}}
                                        {{-- progress --}}
                                                <div class="row rounded-lg mx-2" style="width: fit-content;padding: 8px 0 8px 0px;white-space: nowrap;
                                                position: absolute;
                                                padding: 2px 25px 2px 2px;
                                                z-index: 9;
                                                right: 40%;
                                                height: 90px;
                                                top: 100px;">
                                                     {{-- <h2 class="h6 font-weight-bold text-center">{{ $course->course_name }} progress</h2> --}}
                                                    <!-- Progress bar 1 -->
                                                    <div id="progress_line" class="col-sm-3 progress mx-1 mt-2" data-value='{{number_format((int)(($number_students_in_this_course/$course->students_number)*100), 0, '.', '')}}'>
                                                        <span class="progress-left">
                                                            <span class="progress-bar border-<?php if((($number_students_in_this_course/$course->students_number)*100)<40) echo'danger';elseif((($number_students_in_this_course/$course->students_number)*100)<60) echo 'warning'; elseif((($number_students_in_this_course/$course->students_number)*100)<80) echo 'primary';else echo 'success';?>"></span>
                                                        </span>
                                                        <span class="progress-right">
                                                            <span class="progress-bar border-<?php if((($number_students_in_this_course/$course->students_number)*100)<30) echo'danger';elseif((($number_students_in_this_course/$course->students_number)*100)<=60) echo 'warning'; elseif((($number_students_in_this_course/$course->students_number)*100)<=80) echo 'primary';else echo 'success';?>"></span>
                                                        </span>
                                                        <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                            <div id="progress_value" class="h3 font-weight-bold text-<?php if((($number_students_in_this_course/$course->students_number)*100)<30) echo'danger';elseif((($number_students_in_this_course/$course->students_number)*100)<=60) echo 'warning'; elseif((($number_students_in_this_course/$course->students_number)*100)<=80) echo 'primary';else echo 'success';?>">{{number_format((int)(($number_students_in_this_course/$course->students_number)*100), 0, '.', '')}}</div><span class="h4 font-weight-bold text-<?php if((($number_students_in_this_course/$course->students_number)*100)<30) echo'danger';elseif((($number_students_in_this_course/$course->students_number)*100)<=60) echo 'warning'; elseif((($number_students_in_this_course/$course->students_number)*100)<=80) echo 'primary';else echo 'success';?>">%</span>
                                                        </div>
                                                    </div>
                                                    <!-- END -->
                                            
                                                    <!-- Demo info -->
                                                    <div class="col-sm-8">
                                                        <div class="row text-center mt-3">
                                                           <div class="col-5 border-right" style="display:none;">
                                                                <div id="progress_remaining_to_full" class="h6 font-weight-bold my-0">{{100-number_format((int)(($number_students_in_this_course/$course->students_number)*100), 0, '.', '')}}</div><span class="small text-gray"> still</span>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="h2 font-weight-bold my-0 text-">{{$number_students_in_this_course}}</div><span class="small text-gray">full places</span>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="h2 font-weight-bold my-0">{{$course->students_number-$number_students_in_this_course}}</div><span class="small text-gray">free places</span>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="h2 font-weight-bold my-0">{{$course->students_number}}</div><span class="small text-gray">students num</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END -->
                                        {{-- progress --}}
                                {{-- fly code to top --}}
                            </table>
                        </div>
                </div>
            </div>
                <button type="submit" class="btn btn-dark">Update Course</button>
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


{{-- progress js --}}
<script type="text/javascript">
    $(function() {
    
    $(".progress").each(function() {
    
      var value = $(this).attr('data-value');
      var left = $(this).find('.progress-left .progress-bar');
      var right = $(this).find('.progress-right .progress-bar');
    
      if (value > 0) {
        if (value <= 50) {
          right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
        } else {
          right.css('transform', 'rotate(180deg)')
          left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
        }
      }
    
    })
    
    function percentageToDegrees(percentage) {
    
      return percentage / 100 * 360
    
    }
         //increase slowly
         progress_remaining_to_full = parseInt($("#progress_remaining_to_full").text());
         //console.log(typeof(progress_remaining_to_full))
         var i=0;
         const timer1=setInterval(()=>{
            i+=1;
            $("#progress_value").text(i);
            if(i == 100-progress_remaining_to_full){
            clearInterval(timer1);
            }
         },30);

                  //increase slowly
                  progress_remaining_to_full = parseInt($("#progress_remaining_to_full").text());
         //console.log(typeof(progress_remaining_to_full))
         var k=0;
         const timer3=setInterval(()=>{
            var value = $("#progress_line").attr('data-value');console.log(value)
            var left = $("#progress_line").find('.progress-left .progress-bar');
            var right = $("#progress_line").find('.progress-right .progress-bar');
            left.css('transform', 'rotate(0deg)')
            k+=1;
            if (k > 0) {
                if (k <= 50) {
                right.css('transform', 'rotate(' + percentageToDegrees(k) + 'deg)')
                } else {
                //right.css('transform', `rotate(180deg)`)
                left.css('transform', 'rotate(' + percentageToDegrees(k+50) + 'deg)')
                }
            }
            if(k == value){
                clearInterval(timer3);
            }
         },30);
        //  var j=0;
        //  const timer2=setInterval(()=>{
        //     j+=1;
        //     $("#progress_remaining_to_full").html(j);
        //     if(j == progress_remaining_to_full){
        //     clearInterval(timer2);
        //     }
        //  },20);
        //  $(`<sup class=" h5 font-weight-bold">%</sub>`).appendTo("#progress_remaining_to_full");
    });
    
    
    </script>
@endsection
