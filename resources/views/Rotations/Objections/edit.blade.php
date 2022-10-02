@extends('layouts.app-master')
@section('content')
    <div class="bg-light p-2 rounded">
        <h1 class="text-center"> إعتراضات {{ $rotation->name }} - {{ $rotation->year }}
            {{-- @if(auth()->user()->id==1)
                <a href="{{ route('rotations.add_course_to_program',$rotation->id) }}" class="btn btn-success float-right me-2 m4-2">Add Course</a>
            @endif --}}
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
            <form method="POST" action="{{route('rotations.objections.update',$rotation->id)}}">
                @method('patch')
                @csrf
                <table class="table" class='exam-program'>
                <thead>
                    <tr>
                        <td align="center" height="100" width="5%"><br>
                            <b>Day/Period</b></br>
                        </td>
                        <td align="center" height="100" width="18%">
                            <b>I<br>One Year</b>
                        </td>
                        <td align="center" height="100" width="18%">
                            <b>II<br>Two Year</b>
                        </td>
                        <td align="center" height="100" width="18%">
                            <b>III<br>Three Year</b>
                        </td>
                        <td align="center" height="100" width="18%">
                            <b>IV<br>Fourth Year</b>
                        </td>
                        <td align="center" height="100" width="18%">
                            <b>IIV<br>Fifth Year</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($courses_info) --}}
                    @php $counter=0; @endphp
                    @foreach($courses_info as $date => $all_years)
                        <tr>
                            <td class="date" align="center" height="100">
                                <input type="checkbox" id="day{{++$counter}}" class="toggler-wrapper style-4"  style="float:right;display: block;
                                width: 200px;
                                height: 55px;
                                cursor: pointer;
                                left:-60px;
                                position: absolute;" onclick="select_all_courses_in_day({{ $counter }})">
                                <b style="margin-top:5px">{{ date('l d-m-Y', strtotime($date)) }}</b>
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
                                            <td id="course{{ $courseQ->id }}" class="course" align="center" height="100">
                                                    <input type="checkbox" style="float:right;display: block;
                                                    width: 200px;
                                                    height: 55px;
                                                    cursor: pointer;
                                                    position: absolute;"
                                                    name="courses_objections_ids[{{ $courseQ->id }}]"
                                                    value="{{ $courseQ->id }}"
                                                    class="course_in_day{{$counter}} toggler-wrapper style-3" {{(in_array($courseQ->id,$courses_objections_ids)?'checked':'')}}>
                                                    
                                                <h5 class='course-name' onclick="selectCourseFunction({{ $courseQ->id }})">
                                                    @php
                                                        if($courseQ)
                                                            echo $courseQ->course_name;
                                                    @endphp
                                                </h5>
                                            
                                                <div class="controll">
                                                    <span class="badge bg-warning">{{gmdate('H:i A',strtotime($time))}}</span>
                                                </div>
                                            </td>
                                        @endif
                                @endforeach
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-dark">Update Objections</button>
        </form>
        @else
        <div class="alert text-black alert-success" role="alert" style="margin-top: 20px;">
            <h4 class="alert-heading">Sorry<h4>
            <p>The Program has not any course yet .</p>
            <hr>
            <p class="mb-0">When there are courses you can object .</p>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"> </script>

<script type="text/javascript">
    $(document).ready(function(){

        //is active
        selectCourseFunction=(x)=>{
            console.log(x);
            $('#course'+x).css({'border-radius':'17px','background-color':'#6c757d0d'});
        }
        select_all_courses_in_day=(counter)=>{console.log('#day'+counter);
                if($('#day'+counter).is(':checked')) {
                    $.each($('.course_in_day'+counter), function() {
                        if (!$('#day'+counter).disabled)
                            $('.course_in_day'+counter).prop('checked',true);
                    });
                } else {
                    $.each($('.course_in_day'+counter), function() {
                        $('.course_in_day'+counter).prop('checked',false);
                    });
                }
                
        }
        //is active

    });

    </script>