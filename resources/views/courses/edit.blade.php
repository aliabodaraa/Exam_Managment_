@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">

        <h1>Update Course</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
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
                            @if($disabled_common_rooms_send)
                            <th scope="col" width="20%">Warrning Message</th>
                            @endif
                        </thead>
                        @foreach(App\Models\Room::orderBy('capacity','ASC')->get() as $room)
                            {{-- info rooms --}}

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
                                            @foreach ($courseN->rooms as $roomS)
                                                @if(! in_array($roomS->id, $arr1))
                                                    @php
                                                        array_push($arr1,$roomS->id);
                                                        $count_taken_student_in_all_rooms_in_this_course+=$roomS->pivot->num_student_in_room;
                                                    @endphp
                                                    @if ($roomS->id == $room->id)
                                                        @php $count_taken_student_in_this_room_in_this_course+=$roomS->pivot->num_student_in_room;
                                                        array_push($courses_belongs,$courseN->course_name);@endphp
                                                    @else
                                                        @php $count_taken_student_not_in_this_room_in_this_course+=$roomS->pivot->num_student_in_room; @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($courseN->rooms as $roomS)
                                                @if(! in_array($roomS->id, $arr2))
                                                    @if ($roomS->id == $room->id && $roomS->pivot->date==$course->users[0]->pivot->date && $roomS->pivot->time==$course->users[0]->pivot->time)
                                                        @php
                                                            array_push($arr2,$roomS->id);
                                                            $count_taken_student_in_this_room_in_all_common_courses+=$roomS->pivot->num_student_in_room;
                                                            $common[$courseN->course_name]['take']=$count_taken_student_in_this_room_in_all_common_courses;
                                                            array_push($courses_belongs,$courseN->course_name);
                                                        @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                        @php
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
                                            $is_common= (count($course_info['courses_belongs']) > 1 ? true : false)
                                        @endphp
                                    @endforeach

                                    {{-- fly code to top --}}
                                        @once
                                        <h2 class="badge bg-danger" style="position: absolute;top: 163px;left: 343px;{{($course->students_number==$count_taken_student_in_all_rooms_in_this_course)?'':'display:none'}}">Full</h2>
                                        <div class="numbers-info" style="position: absolute;top: 155px;right: 74px;
                                        display: inline-flex;">
                                            <h5 style="float: right;"><span class="badge bg-success">students number:{{$course->students_number}}</span></h5>
                                            <h5 style="float: right;"><span class="{{(true) ? 'badge bg-info':'badge bg-danger'}}">free students:{{$course->students_number-$count_taken_student_in_all_rooms_in_this_course}}</span></h5>
                                            <h5 style="float: right;"><span class="badge bg-primary">full number:{{$count_taken_student_in_all_rooms_in_this_course}}</span></h5>
                                        </div>
                                        @endonce

                                     {{-- fly code to top --}}
                            {{-- info rooms --}}
                            <tr style="position: relative;top:-1px;">
                                <td>
                                    <input type="checkbox"
                                    name="rooms[{{ $room->id }}]"
                                    value="{{ $room->id }}"
                                    class='rooms'
                                    {{ in_array($room->id, array_unique($roomsArr))
                                           ? 'checked'
                                           : '' }}
                                    {{ (in_array($room->id, array_unique($disabled_rooms)) &&
                                      ! in_array($room->id, array_unique($accual_common_rooms)))
                                           ? 'disabled'
                                           : '' }}
                                           {{( $course->students_number==$count_taken_student_in_all_rooms_in_this_course 
                                             && !in_array($room->id,$disabled_rooms)
                                             && !in_array($room->id,$accual_common_rooms)
                                             && !in_array($room->id,$roomsArr) )?'disabled':''}}
                                             >
                                </td>
                                <td>{{ $room->room_name }}</td>
                                @if($accual_common_rooms)
                                    <td>
                                        <div class="common-courses">
                                                @foreach ($courses_info[$course->course_name]['courses_belongs'] as $course_belongs)
                                                    @if($course->course_name==$course_belongs) @php continue; @endphp @endif
                                                        <span class="badge bg-secondary">{{$course_belongs}}</span>
                                                @endforeach
                                        </div>
                                    </td>
                                @endif
                                <td>
                                    {{-- Capacity / Occupied --}}
                                    @if(in_array($room->id, array_unique($joining_rooms)) || in_array($room->id, array_unique($accual_common_rooms)))
                                        <span class="badge bg-info">{{$room->capacity}}/{{$courses_info[$course->course_name]['count_taken_student_in_this_room_in_this_course']+$count_taken_student_in_this_room_in_all_common_courses}}</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- status --}}
                                    @if(in_array($room->id, array_unique($joining_rooms)) || in_array($room->id, array_unique($accual_common_rooms)))
                                        <span class="badge bg-primary">{{($room->capacity - ($courses_info[$course->course_name]['count_taken_student_in_this_room_in_this_course']+$count_taken_student_in_this_room_in_all_common_courses) ==0 ) ? 'Full' : $room->capacity - ($courses_info[$course->course_name]['count_taken_student_in_this_room_in_this_course']+$count_taken_student_in_this_room_in_all_common_courses).' Free'}} <span>
                                    @endif
                                </td>
                                <td>
                                     @if(in_array($room->id, array_unique($joining_rooms)))
                                     {{-- count_taken_student_in_all_rooms_in_this_course--}}
                                            <a href="{{ route('courses.room_for_course', ['course'=>$course->id,'specific_room'=>$room->id]) }}" class="btn btn-warning" style="{{!($courses_info[$course->course_name]['count_taken_student_in_this_room_in_this_course']>=$room->capacity) ? '':'pointer-events: none;background-color: #ffc10773;border-color: #ffc10773;'}}">
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
                        @endforeach
                    </table>
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
