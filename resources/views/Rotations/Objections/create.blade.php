@extends('layouts.app-master')
@section('content')
    <div class="bg-light p-2 rounded">
        <h1 class="text-center"> إنشاء إعتراضات <mark>{{ $user->username }}</mark> في {{ $rotation->name }}  - {{ $rotation->year }} </h1>
        <div class="container-fluid p-2 rounded">
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            @if(count($courses_info))
            <form method="POST" action="{{route('rotations.objections.store',[$rotation,$user])}}">
                @csrf
                <table class="table" class='exam-program'>
                    <thead>
                        <tr>
                            <td align="center" height="100" width="5%"><br>
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
                            <td align="center" height="100" width="19%" style="position: absolute;padding-top: 43px;">
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
                                    <input type="checkbox" id="day{{++$counter}}" class="toggler-wrapper style-4" style="float:right;display: block;
                                    width: 200px;
                                    height: 40px;
                                    cursor: pointer;
                                    left:-55px;
                                    position: absolute;" onclick="select_all_courses_in_day({{ $counter }})">
                                    <b style="margin:0 0 0 35px">{{ date('l d-m-Y', strtotime($date)) }}</b>
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
                                                @if(!in_array(2,$years))
                                                    @if(!in_array(1,$years))
                                                        <td></td><td></td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @endif
                                                @php $counter_three++; @endphp
                                            @elseif($year_number==4 && ! $counter_four)
                                                @if(!in_array(3,$years))
                                                    @if(!in_array(2,$years))
                                                        @if(!in_array(1,$years))
                                                            <td></td><td></td><td></td>
                                                        @else
                                                            <td></td><td></td>
                                                        @endif
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @else
                                                    {{-- @if(in_array(5,$years))
                                                    <td></td>
                                                    @endif --}}
                                                @endif
                                                @php $counter_four++; @endphp
                                            @elseif($year_number==5 && ! $counter_five)
                                                @if(!in_array(4,$years))
                                                    @if(!in_array(3,$years))
                                                        @if(!in_array(2,$years))
                                                            @if(!in_array(1,$years))
                                                                <td></td><td></td><td></td><td></td>
                                                            @else
                                                                <td></td><td></td><td></td>
                                                            @endif
                                                        @else
                                                            <td></td><td></td>
                                                        @endif
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @else
                                                    {{-- @if(in_array(5,$years))
                                                    <td></td>
                                                    @endif --}}
                                                @endif
                                                @php $counter_five++; @endphp
                                            @endif
                                            @php
                                                $courseQ= App\Models\Course::where('id',$id_course)->toBase()->first();
                                                $dateTime=$date."_".$time
                                            @endphp
                                            @if($courseQ)
                                                <td class="course" align="center" height="100">
                                                    <div class="course-name-checkbox-wrapper" style="
                                                    position: relative;
                                                    width: 180px;
                                                    height: 40px;">
                                                        <input type="checkbox" style="
                                                            width: 40px;
                                                            height: 40px;
                                                            cursor: pointer;
                                                            position: absolute;
                                                            left: 10px;"
                                                        name="courses_objections_ids[{{ $courseQ->id }}]"
                                                        value="{{ $courseQ->id }}"
                                                        class='course_in_day{{$counter}} toggler-wrapper style-3 course_{{ $dateTime }}' onclick="selectCourseFunction(JSON.parse(JSON.stringify({{ json_encode($dateTime) }})),event)">
                                                        <h5 class='course-name' style="white-space: pre-wrap;">
                                                            @php
                                                                if($courseQ)
                                                                    echo $courseQ->course_name;
                                                            @endphp
                                                        </h5>
                                                    </div>
                                                    <div class="controll" style="margin-top: -41px;">
                                                        <span class="badge bg-warning">{{gmdate('H:i A',strtotime($time))}}</span>
                                                        {{-- <span class="badge bg-dark">{{gmdate('H:i A',strtotime($time)+strtotime($rotation->coursesProgram()->where('id',$courseQ->id)->get()[0]->pivot->duration))}}</span> --}}
                                                    </div>
                                                </td>
                                            @endif
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-dark">Create Objections</button>
                
            </form>
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
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"> </script>

<script type="text/javascript">
    $(document).ready(function(){
        select_all_courses_in_day=(counter)=>{
            console.log("------------"+'#day'+counter);
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
    let selectCourseFunction=(dateTime,e)=>{
        let collectionOfInputsSameDateTimeCourses = document.getElementsByClassName("course_"+dateTime);

        //console.log(e.target);
        if(e.target.checked){
            for (let item of collectionOfInputsSameDateTimeCourses){
                if(e.target===item) continue;
                    item.checked=true;
            }
        }else{
            for (let item of collectionOfInputsSameDateTimeCourses){
                if(e.target===item) continue;
                item.checked=false;
            }
        }
    }
    </script>