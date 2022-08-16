@extends('layouts.app-master')
@section('content')
    <div class="bg-light p-2 rounded">
        <h1>Exam Program</h1>
        <div class="lead">
            TIME TABLE .
            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm float-right">Add Course</a>
            {{-- <a href="{{ route('courses.misboard') }}" class="btn btn-warning btn-sm">misboard courses</a> --}}
        </div>
        {{-- class="container mt-2" --}}
        <div class="container-fluid px-2 mt-2">
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
                                    <td class="course" align="center" height="100" style="display:{{($year_number==4) ?'inline-block':'float-root';}};{{($courseQ->semester=='2')?'border-radius: 17px;background-color: #6c757d0d;':''}}"><h5 class='course-name'>
                                    @php
                                        echo $courseQ->course_name;
                                    @endphp
                                    </h5>
                                        <div class="controll">
                                                <a href="{{ route('courses.show', $id_course) }}" class="btn btn-warning btn-sm">Show</a>
                                                <a href="{{ route('courses.edit', $id_course) }}" class="btn btn-info btn-sm">Edit</a>
                                              {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $id_course],'style'=>'display:inline']) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                              {!! Form::close() !!}
                                            <span class="badge bg-secondary">{{gmdate('H:i A',strtotime($time))}}</span>
                                          </div>
                                    </td>
                                    @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      {{-- <div class="d-flex">
        {!! $courses->links() !!}
    </div> --}}
    </div>
@endsection