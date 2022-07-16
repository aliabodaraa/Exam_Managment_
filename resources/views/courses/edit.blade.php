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
                <div class="mb-3" style="height: 300px;
                overflow: scroll;">
                    <table class="table">
                        <thead>
                            <th scope="col" width="1%"><input type="checkbox" name="all_rooms"></th>
                            <th scope="col" width="2%">Rooms</th>
                            @if($courses_common_rooms)<th scope="col" width="20%">common with</th>@endif
                            <th scope="col" width="30%">Action</th>
                        </thead>
                        @foreach(App\Models\Room::all() as $room)
                            <tr>
                                <td>
                                    <input type="checkbox"
                                    name="rooms[{{ $room->id }}]"
                                    value="{{ $room->id }}"
                                    class='rooms'
                                    {{ in_array($room->id, array_unique($roomsArr))
                                           ? 'checked'
                                           : '' }}
                                    {{ (in_array($room->id, array_unique($disabled_rooms)) && !in_array($room->id, array_unique($common_rooms)))
                                           ? 'disabled'
                                           : '' }}>
                                </td>
                                <td>{{ $room->room_name }}</td>
                                @if($courses_common_rooms)
                                <td>
                                    <div class="common-courses">
                                        @if(( in_array($room->id, array_unique($common_rooms))))
                                        @foreach ($courses_common_rooms as $course_common)
                                        <span>
                                            <span class="badge bg-secondary">{{$course_common}}</span>
                                        </span>
                                        @endforeach
                                        @endif
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <a href="{{ route('courses.room_for_course', ['course'=>$course->id,'specific_room'=>$room->id]) }}" class="btn1 btn btn-danger btn-sm"
                                    style="{{ (!in_array($room->id, array_unique($common_rooms)) && in_array($room->id, $disabled_rooms)) ? 'pointer-events: none;background-color:#999' : '' }} ;display:none;">{{(( !in_array($room->id, array_unique($common_rooms))))?'specify members':'Manage members in common room'}}
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
                <button type="submit" class="btn btn-primary">Update Course</button>
                <a href="{{ route('courses.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection
@section('scripts')
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
