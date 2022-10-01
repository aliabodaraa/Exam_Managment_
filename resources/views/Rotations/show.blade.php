@extends('layouts.app-master')
@section('content')
    <div class="bg-light p-2 rounded">
        <h1>
            @php
            $num_of_my_courses_objections=App\Models\Course::with('rotationsObservation')->whereHas('rotationsObservation', function($query) use($rotation){
                $query->where('user_id',Auth::user()->id)->where('rotation_id',$rotation->id);})->pluck('id')->toArray();
            @endphp
            @if(!count($num_of_my_courses_objections))
                <a href="{{ route('rotations.objections_create',$rotation->id) }}"  class="btn btn-danger float-left me-2 m4-2">إنشاء إعتراضات</a>
            @else
                <a href="{{ route('rotations.objections_edit',$rotation->id) }}"  class="btn btn-danger float-left me-2 m4-2">تعديل إعتراضاتي</a>
            @endif
            <b class="text-center" style="margin-left: 381px;">{{ $rotation->faculty->name }} - برنامج امتحان {{ $rotation->name }} - {{ $rotation->year }}</b>
            @if(auth()->user()->id==1)
                <a href="{{ route('rotations.add_course_to_program',$rotation->id) }}" class="btn btn-success float-right me-2 m4-2">Add Course</a>
            @endif
        </h1>
        
        {{-- <div class="lead">
            TIME TABLE . 
                @if(auth()->user()->id==1)
                    <a href="{{ route('rotations.add_course_to_program',$rotation->id) }}" class="btn btn-success float-right me-2 m4-2">Add Course</a>
                @endif
        </div>--}}
        <div class="container-fluid p-2 rounded">
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
            @if(count($courses_info))
            <table class="table" class='exam-program'>
            <thead>
                <tr>
                    <td align="center" height="100" width="4%"><br>
                        <b>Day/Period</b></br>
                    </td>
                    <td align="center" height="100" width="15%">
                        <b>I<br>One Year</b>
                    </td>
                    <td align="center" height="100" width="15%">
                        <b>II<br>Two Year</b>
                    </td>
                    <td align="center" height="100" width="15%">
                        <b>III<br>Three Year</b>
                    </td>
                    <td align="center" height="100" width="15%">
                        <b>IV<br>Fourth Year</b>
                    </td>
                    <td align="center" height="100" width="15%">
                        <b>IIV<br>Fifth Year</b>
                    </td>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($courses_info) --}}
                @foreach($courses_info as $date => $all_years)
                    <tr>
                        <td class="date" align="center" height="100">
                            <b>{{ date('l d-m-Y', strtotime($date)) }}</b>
                        </td>
                        @php 
                            $counter_one=0;
                            $counter_two=0;
                            $counter_three=0;
                            $counter_four=0;
                            $counter_five=0;
                            $years=[];
                            foreach($all_years as $year_number => $courses_arrs)
                                array_push($years, $year_number);
                        @endphp
                        @foreach($all_years as $year_number => $courses_numbers_arrs)
                                @foreach ($courses_numbers_arrs as $id_course => $time)
                                    @if($year_number==2 && ! $counter_two)
                                        @if(!in_array(1,$years))
                                            <td></td>
                                        @endif
                                        @php $counter_one++; @endphp
                                    @elseif($year_number==3 && ! $counter_three)
                                        @if(!in_array(2,$years) && !in_array(1,$years))
                                            <td></td><td></td>
                                        @endif
                                        @if(!in_array(2,$years) && in_array(1,$years))
                                            <td></td>
                                        @endif
                                        @php $counter_three++; @endphp
                                    @elseif($year_number==4 && ! $counter_four)
                                        @if(!in_array(3,$years) && !in_array(2,$years) && !in_array(1,$years))
                                            <td></td><td></td><td></td>
                                        @elseif(!in_array(3,$years) && !in_array(2,$years) && in_array(1,$years))
                                            <td></td><td></td>
                                        @elseif(!in_array(3,$years) && in_array(2,$years))
                                            <td></td>
                                        @endif
                                        @php $counter_four++; @endphp
                                    @elseif($year_number==5 && ! $counter_five)
                                        @if(!in_array(4,$years) && !in_array(3,$years) && !in_array(2,$years) && !in_array(1,$years))
                                            <td></td><td></td><td></td><td></td>
                                        @elseif(!in_array(4,$years) && !in_array(3,$years) && !in_array(2,$years) && in_array(1,$years))
                                            <td></td><td></td><td></td>
                                        @elseif(!in_array(4,$years) && !in_array(3,$years) && in_array(2,$years))
                                            <td></td><td></td>
                                        @elseif(!in_array(4,$years) && in_array(3,$years))
                                            <td></td>
                                        @endif
                                        @php $counter_five++; @endphp
                                        {{-- @if( count($courses_numbers_arrs['courses']) > 1 && !in_array(4,$years) && !in_array(3,$years) && !in_array(2,$years) && in_array(1,$years) )
                                            @once<td></td><td></td><td></td>@endonce
                                        @endif--}}
                                    @endif
                                    @php
                                    $courseQ= App\Models\Course::where('id',$id_course)->first();
                                    @endphp
                                    @if($courseQ)
                                        <td class="course" align="center" height="100" style="display:{{($year_number==4) ?'inline-block':'float-root';}};{{($courseQ->semester=='2')?'border-radius: 17px;background-color: #6c757d0d;':''}}">
                                            <h5 class='course-name'>
                                                @php
                                                    if($courseQ)
                                                        echo $courseQ->course_name;
                                                @endphp
                                            </h5>
                                            <div class="controll">
                                                    <a href="/rotations/{{$rotation->id}}/course/{{$id_course}}/show" class="btn btn-warning btn-sm btn-outline-light rounded">Show</a>
                                                    @if(auth()->user()->id==1)
                                                        <a href="/rotations/{{$rotation->id}}/course/{{$id_course}}/edit" class="btn btn-info btn-sm btn-outline-light rounded">Edit</a>
                                                        <a href="/rotations/{{$rotation->id}}/course/{{$id_course}}/delete_course_from_program" class="btn btn-danger btn-sm btn-outline-light rounded">Delete</a>
                                                    @endif
                                                {{-- {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $id_course],'style'=>'display:inline']) !!}
                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!} --}}
                                                <span class="badge bg-secondary">{{gmdate('H:i A',strtotime($time))}}</span>
                                            </div>
                                        </td>
                                    @endif
                                @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert text-black alert-success" role="alert" style="margin-top: 20px;">
            <h4 class="alert-heading">Sorry<h4>
            <p>The Program has not any course yet .</p>
            <hr>
            <p class="mb-0">Whenever you need to add a new course, click the green button .</p>
           <h1><a href="{{url()->previous()}}" class="btn btn-secondary"> Back</a></h1>
           {{-- problem in back --}}
        </div>
      @endif
      </div>
      {{-- <div class="d-flex">
        {!! $courses->links() !!}
    </div> --}}
    </div>
@endsection