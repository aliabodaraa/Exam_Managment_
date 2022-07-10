@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Exam Program</h1>
        <div class="lead">
            TIME TABLE .
            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm float-right">Add Course</a>
        </div>
        <div class="container mt-4">
            @if ($message = Session::get('message'))
                <div class="alert alert-success alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('user-update'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif
            @if ($messageDelete = Session::get('user-delete'))
            <div class="alert alert-success alert-block">
                <strong>{{ $messageDelete }}</strong>
            </div>
            @endif
            <table class="table" class='exam-program'>
            <thead>
                <tr>
                    <td align="center" height="100" width="4%"><br>
                        <b>Day/Period</b></br>
                    </td>
                    <td align="center" height="100" width="19%">
                        <b>I<br>One Year</b>
                    </td>
                    <td align="center" height="100" width="19%">
                        <b>II<br>Two Year</b>
                    </td>
                    <td align="center" height="100" width="19%">
                        <b>III<br>Three Year</b>
                    </td>
                    <td align="center" height="100" width="19%">
                        <b>IV<br>Fourth Year</b>
                    </td>
                    <td align="center" height="100" width="19%">
                        <b>IIV<br>Fifth Year</b>
                    </td>
                </tr>
            </thead>
            <tbody>
                <?php $dates=[""]; $datesAfter=[""];?>
                @foreach(App\Models\Course::all() as $course)
                    @foreach($course->rooms as $room)
                        <?php array_push($dates, $room->pivot->date);?>
                    @endforeach
                @endforeach
                <?php $datesAfter = array_unique($dates);sort($datesAfter)?>
                {{-- @dd($dates,$datesAfter) --}}

                @foreach($datesAfter as $date)
                    <?php if(!$date) continue; ?>
                    <tr>
                        <td class="date" align="center" height="100">
                            <b>{{$date}}</b>
                        </td>
                        @foreach(App\Models\Course::orderBy('studing_year')->get() as $course)
                            @foreach(App\Models\Course::with('rooms')
                            ->whereHas('rooms', function($query) use($date, $course){
                            $query->where('date',$date)->where('course_id',$course->id);
                            })->get() as $courseN)
                                @if($courseN->studing_year==1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                        <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif($courseN->studing_year==2)
                                 {{-- @dd(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                })->where('studing_year',4)->get())) --}}
                                    @if(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get()) >=1 )
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                   @else
                                    <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                    @endif
                                @elseif($courseN->studing_year==3)
                                    @if(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                        <td></td>
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                    @endif
                                @elseif($courseN->studing_year==4)
                                    @if(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                        <td></td>
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                    @endif
                                @elseif($courseN->studing_year==5)
                                    @if(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif((count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1) || (count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1) ||(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1))
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())>=1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                        <td></td>
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())>=1)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                @elseif(count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',4)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',3)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',2)->get())<1 && count(App\Models\Course::with('rooms')
                                ->whereHas('rooms', function($query) use($date){
                                $query->where('date',$date);
                                    })->where('studing_year',1)->get())<1)
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    <td class="course" align="center" height="100"><h5 class='course-name'>{{$courseN->course_name}}</h5>
                                          <div class="controll">
                                                <a href="{{ route('courses.show', $courseN->id) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $courseN->id) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $courseN->id],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">
                                                @foreach($courseN->rooms as $key => $room)
                                                    @if($key==0)
                                                        {{$room->pivot->time}}
                                                    @endif
                                                @endforeach
                                            </span>
                                          </div>
                                    </td>
                                    @endif
                                @endif
                        @endforeach
                    @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
@endsection
