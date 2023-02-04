@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>
            تعديل مقرر {{ $course->course_name }}
            @if($occupied_number_of_students_in_this_course === $entered_students_number)
                <span class="badge bg-danger">Course Full</span>
            @endif
            <div class="float-right">
                <a href="{{url()->previous()}}" class="btn btn-dark">رجوع
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg>
                </a>
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
            {{-- What this --}}
                @if ($ss = Session::get('disabled_rooms'))
                    <!-- when you submit -->
                    @foreach ($disabled_common_rooms_send as $itemArr)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{$ss}}Stop trying to submit The<b>@php $room_name=App\Models\Room::where('id',$itemArr)->toBase()->first();echo $room_name->room_name; @endphp</b>reserves now in anothor course it will free after now for this reason either Un-checked the room Or make both courses in the same time</strong>
                            <button type="button" class="btn-close mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif
            {{-- What this --}}
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="post" action="/rotations/{{$rotation->id}}/course/{{$course->id}}/update">
                @method('patch')
                @csrf
                <div class="row">
                <div class="left col-sm-3" style="float:left">   
                    <div class="mb-3">
                        <label for="email" class="form-label">أسم المقرر :</label>
                        <input value="{{ $course->course_name }}"
                            type="text"
                            class="form-control"
                            name="course_name"
                            placeholder="Email address" required disabled>
                        @if ($errors->has('course_name'))
                            <span class="text-danger text-left">{{ $errors->first('course_name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="studing_year" class="form-label">سنة المقرر :</label>
                        <select class="form-control" name="studing_year" class="form-control" required disabled>
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
                        <label for="department" class="form-label">فصل المقرر :</label>
                        <select class="form-control" name="semester" class="form-control" required disabled>
                                <option value='1'  {{ ($course->semester == 1) ? 'selected': '' }}>First Semester</option>
                                <option value='2'  {{ ($course->semester == 2) ? 'selected': '' }}>Secound Semester</option>
                        </select>
                        @if ($errors->has('semester'))
                            <span class="text-danger text-left">{{ $errors->first('semester') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">تاريخ المقرر :</label>
                        <input value="{{$date}}"
                            type="date"
                            class="form-control"
                            name="date"
                            placeholder="date" required disabled>
                        @if ($errors->has('date'))
                            <span class="text-danger text-left">{{ $errors->first('date') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">وقت المقرر :</label>
                        <input value="{{$time}}"
                            type="time"
                            class="form-control"
                            name="time"
                            placeholder="time" required disabled>
                        @if ($errors->has('time'))
                            <span class="text-danger text-left">{{ $errors->first('time') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">مدة المقرر :</label>
                        <select class="form-control" name="duration" class="form-control" required disabled>
                            <option value="01:00" {{ ($duration == "01:00") ? "selected": "" }}>01:00 hours</option>
                            <option value="01:30" {{ ($duration == "01:30") ? "selected": "" }}>01:30 hours</option>
                            <option value="02:00" {{ ($duration == "02:00") ? "selected": "" }}>2:00 hours</option>
                            <option value="02:30" {{ ($duration == "02:30") ? "selected": ""}}>02:30 hours</option>
                            <option value="03:00" {{ ($duration == "03:00") ? "selected": "" }}>03:00 hours</option>
                            <option value="03:30" {{ ($duration == "03:30") ? "selected": "" }}>03:30 hours</option>
                            <option value="04:00" {{ ($duration == "04:00") ? "selected": "" }}>04:00 hours</option>
                        </select>
                        @if ($errors->has('duration'))
                            <span class="text-danger text-left">{{ $errors->first('duration') }}</span>
                        @endif
                    </div>
                    {{-- <div class="mb-3">
                        <label for="faculty_id" class="form-label">كلية المقرر</label>
                        <select class="form-control" name="faculty_id" class="form-control" required>
                            @foreach (App\Models\Faculty::toBase()->get() as $faculty)
                                <option value='{{ $faculty->id }}' {{ ($course->faculty->id == $faculty->id) ? 'selected': '' }}>{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('faculty_id'))
                            <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                        @endif
                    </div> --}}
                    <br>
                    <button type="submit" class="btn btn-dark">تعديل</button>

                </div>
                <div class="right col-sm-9" style="float:right">
                        <label for="rooms" class="form-label">إدارة قاعات المقرر :</label>
                        <div class="mb-3" style="height: 580px;
                        overflow: scroll;">
                            <table class="table table-light">
                                <thead>
                                    <th scope="col" width="1%">
                                        <input type="checkbox" name="all_rooms" class="toggler-wrapper style-4"
                                        {{$occupied_number_of_students_in_this_course === $entered_students_number ? 'disabled': '' }}
                                        >
                                    </th>
                                    <th scope="col" width="10%">القاعات</th>
                                    <th scope="col" width="20%">مشترك مع</th>
                                    <th scope="col" width="15%">السعة/الأماكن المحتلة</th>
                                    <th scope="col" width="15%">الحالة</th>
                                    <th scope="col" width="15%">عدد الطلاب في القاعة</th>
                                    <th scope="col" width="20%">خيارات</th>
                                    {{-- @if($disabled_common_rooms_send)
                                    <th scope="col" width="20%">Warrning Message</th>
                                    @endif --}}
                                </thead>
                                {{-- @dump($common_rooms_ids,$joining_rooms) --}}
                                @php $num_all_courses_occupied_in_all_rooms=0; @endphp
                                @foreach(App\Models\Room::toBase()->get() as $room)
                                    <tr style="position: relative;top:-1px;">
                                        <td>
                                        {{-- <label class="toggler-wrapper style-4"> --}}
                                            @if($room->is_active)
                                                <input type="checkbox"
                                                name="rooms[{{ $room->id }}]"
                                                value="{{ $room->id }}"
                                                class='rooms toggler-wrapper style-4'
                                                {{ in_array($room->id, $rooms_this_course)
                                                    ? 'checked'
                                                    : '' }}
                                                {{ (in_array($room->id, $disabled_rooms) &&
                                                ! in_array($room->id, $common_rooms_ids))
                                                    ? 'disabled'
                                                    : '' }}
                      {{--  {{ count($rotation->rooms()->toBase()->get())? 'disabled': '' }}--}}{{-- added --}}
                                                {{(!in_array($room->id, $rooms_this_course) && ! in_array($room->id, $common_rooms_ids) && $occupied_number_of_students_in_this_course === $entered_students_number)? 'disabled': '' }}
                                                >
                                            @else
                                                <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="danger" style="margin-left:10px; width: 25px;height: 25px;">
                                            @endif
                                        </td>
                                        <td>{{ $room->room_name }}</td>
                                            <td>
                                                @php $num_all_courses_occupied_this_room=0; @endphp
                                                <div class="common-courses">
                                                        @foreach ($courses_common_with_time as $course_belongs)
                                                            @php
                                                                $number_taken_in_this_room_course=0;
                                                                $distributed_rooms_in_this_course_this_rotation=$course_belongs->distributionRoom()->where('rotation_id',$rotation->id)->toBase()->pluck('id')->toarray();
                                                                    if(in_array($room->id,$distributed_rooms_in_this_course_this_rotation)){
                                                                        $number_taken_in_this_room_course=App\Http\Controllers\MaxMinRoomsCapacity\Stock::getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course_belongs, $room->id);
                                                                        $num_all_courses_occupied_this_room+=$number_taken_in_this_room_course;
                                                                    }
                                                            @endphp 
                                                            @if($number_taken_in_this_room_course)
                                                            <a style="text-decoration: none;" href="{{ route("rotations.get_room_for_course",[$rotation->id,$course_belongs->id,$room->id]) }}" class="badge bg-{{($course->id == $course_belongs->id ) ? 'danger': 'secondary'}}">{{$course_belongs->course_name}}</a>
                                                            <span class="badge bg-danger" style="
                                                            right:14px;
                                                            border-radius: 62px;
                                                            position: relative;
                                                            font-size: 11px;
                                                            top: -12px;">{{$number_taken_in_this_room_course;}}</span>
                                                            @endif
                                                        @endforeach
                                                </div>
                                            </td>
                                        <td>
                                            {{-- Capacity / Occupied --}}
                                             @if(in_array($room->id, $rooms_this_course) || in_array($room->id, $joining_rooms) || in_array($room->id, $common_rooms_ids))
                                                <span class="badge bg-{{(($room->capacity+$room->extra_capacity) - $num_all_courses_occupied_this_room)?'primary':'danger'}}">{{($room->capacity+$room->extra_capacity)}}/{{$num_all_courses_occupied_this_room}}</span>
                                             @endif 
                                        </td>
                                        <td>
                                            {{-- status --}}
                                            @if(in_array($room->id, $rooms_this_course) || in_array($room->id, $joining_rooms) || in_array($room->id, $common_rooms_ids))
                                                <span class="badge bg-{{(($room->capacity+$room->extra_capacity) - $num_all_courses_occupied_this_room)?'secondary':'danger'}}">{{(($room->capacity+$room->extra_capacity) - $num_all_courses_occupied_this_room)?($room->capacity+$room->extra_capacity) - $num_all_courses_occupied_this_room.' Free':'Full'}}</span>        
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $num_members_in_room=count($course->users()->wherePivot('rotation_id',$rotation->id)->wherePivot('room_id',$room->id)->toBase()->get());
                                            @endphp
                                            @if(in_array($room->id, $rooms_this_course))
                                            <span class="badge bg-{{($num_members_in_room)? 'success':'warning' }}">
                                                {{ $num_members_in_room }} {{ Str::plural("person",$num_members_in_room)}}
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(in_array($room->id, $joining_rooms)) 
                                            {{-- count_taken_student_in_all_rooms_in_this_course--}}
                                                    <a href="/rotations/{{ $rotation->id }}/course/{{ $course->id }}/room/{{ $room->id }}" class="btn-sm btn btn-warning" style="
                                                    {{  ($occupied_number_of_students_in_this_course === $entered_students_number) ? 'pointer-events: none;background-color: #ffc10773;border-color: #ffc10773;':''}}
                                                    ">
                                                            Joining
                                                    </a>
                                            @endif
                                            <a href="/rotations/{{ $rotation->id }}/course/{{ $course->id }}/room/{{ $room->id }}" class="btn-sm btn @php echo (in_array($room->id,$common_rooms_ids))? 'btn-success':'btn-danger'; @endphp"
                                                {{-- /{{ route('courses.get_room_for_course', ['rotation'=>$rotation->id,'course'=>$course->id,'specific_room'=>$room->id]) }} --}}
                                            style="{{ (!in_array($room->id, $common_rooms_ids)&& in_array($room->id,$disabled_common_rooms_send)) ? 'pointer-events: none;background-color:#999' : '' }} ;display:none;">{{(in_array($room->id,$common_rooms_ids)) ?'Manage':'specify members'}}
                                            </a>
                                        </td>
                                        {{-- @if(in_array($room->id,$disabled_common_rooms_send))
                                            <td>
                                                <span class="badge bg-warning">You Must Un Checked <span class="badge bg-danger">{{$room->room_name}}</span> , Another course use it Now .</span>
                                            </td>
                                        @endif    --}}
                                    </tr>
                                    @php $num_all_courses_occupied_in_all_rooms+=$num_all_courses_occupied_this_room; @endphp
                                @endforeach
                                {{-- fly code to top --}}
                                   {{-- progress --}}
                                   <div class="row rounded-lg mx-2" style="width: fit-content;padding: 8px 0 8px 0px;white-space: nowrap;
                                   position: absolute;
                                   padding: 2px 25px 2px 2px;
                                   z-index: 9;
                                   right: 20%;
                                   height: 90px;
                                   top: 79px;">
                                        {{-- <h2 class="h6 font-weight-bold text-center">{{ $course->course_name }} progress</h2> --}}
                                       <!-- Progress bar 1 -->
                                       <div id="progress_line" class="col-sm-3 progress mx-1 mt-2" data-value='{{number_format((int)(($occupied_number_of_students_in_this_course/$entered_students_number)*100), 0, '.', '')}}'>
                                           <span class="progress-left">
                                               <span class="progress-bar border-<?php if((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<40) echo'danger';elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<60) echo 'warning'; elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<80) echo 'primary';else echo 'success';?>"></span>
                                           </span>
                                           <span class="progress-right">
                                               <span class="progress-bar border-<?php if((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<30) echo'danger';elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<=60) echo 'warning'; elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<=80) echo 'primary';else echo 'success';?>"></span>
                                           </span>
                                           <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                               <div id="progress_value" class="h3 font-weight-bold text-<?php if((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<30) echo'danger';elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<=60) echo 'warning'; elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<=80) echo 'primary';else echo 'success';?>">{{number_format((int)(($occupied_number_of_students_in_this_course/$entered_students_number)*100), 0, '.', '')}}</div><span class="h4 font-weight-bold text-<?php if((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<30) echo'danger';elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<=60) echo 'warning'; elseif((($occupied_number_of_students_in_this_course/$entered_students_number)*100)<=80) echo 'primary';else echo 'success';?>">%</span>
                                           </div>
                                       </div>
                                       <!-- END -->
                                       <!-- Demo info -->
                                       <div class="col-sm-8">
                                           <div class="row text-center mt-3">
                                              <div class="col-5 border-right" style="display:none;">
                                                   <div id="progress_remaining_to_full" class="h6 font-weight-bold my-0">{{100-number_format((int)(($occupied_number_of_students_in_this_course/$entered_students_number)*100), 0, '.', '')}}</div><span class="small text-gray"> still</span>
                                               </div>
                                               <div class="col-4 py-2">
                                                   <div class="h2 font-weight-bold my-0 text-">{{$occupied_number_of_students_in_this_course}}</div><span class="small text-gray">full places</span>
                                               </div>
                                               <div class="col-4 py-2">
                                                   <div class="h2 font-weight-bold my-0">{{$entered_students_number-$occupied_number_of_students_in_this_course}}</div><span class="small text-gray">free places</span>
                                               </div>
                                               <div class="col-4 py-2">
                                                   <div class="h2 font-weight-bold my-0">{{$entered_students_number}}</div><span class="small text-gray">students num</span>
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
            </form>
        </div>

    </div>
@endsection
