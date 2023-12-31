@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 m-4 rounded">
        <h3>إعتراضات <mark>{{ $user->username }}</mark>
            <div style="float: right;"><a href="{{ URL::previous() }}" class="btn btn-dark">Back</a></div>
        </h3>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @if(count($rotation->coursesObjection()->wherePivot('user_id', $user->id)->toBase()->get()))
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <p class="mb-0"><a href="{{ route('objections.user.index', ['user'=>$user->id]) }}" class="text-muted">Show all</a></p>
                    <p class="lead fw-normal mb-0"> : إعتراضاتي في اخر دورة </p>
                </div>
                <div class="card text-dark bg-dark my-2" style="font-size: 16px;">
                    <div class="card-header" style="font-size: 26px;color:white;direction: rtl;">
                        إعتراضات {{ $rotation['name']}}
                        <span class="card-title badge bg-success me-1" style="font-size: 16px;">{{ $rotation['year'] }}</span>
                        <span class="card-title badge bg-secondary me-1" style="font-size: 16px;float: left;">start : {{ $rotation['start_date'] }}</span>
                        <span class="card-title badge bg-danger" style="font-size: 16px;float: left;">end : {{ $rotation['end_date'] }}</span>
                    </div>
                    <div class="card-body" style="font-size: 26px;color:white;text-align:center">
                    </div>
                    <div class="table-observations px-2">
                        <table class="table table-light table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width="18%">اسم المادة</th>
                                    <th scope="col" width="18%">تاريخ المادة</th>
                                    <th scope="col" width="18%">وقت المادة</th>
                                    <th scope="col" width="18%">مدة المادة</th>
                                    <th scope="col" width="28%">تاريخ الإعتراض</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rotation->coursesObjection()->wherePivot('user_id',$user->id)->get() as $course)
                                    @php
                                        $date=$course->rotationsProgram()->where('id',$rotation->id)->first()->pivot->date;
                                        $time=$course->rotationsProgram()->where('id',$rotation->id)->first()->pivot->time;
                                        $duration=$course->rotationsProgram()->where('id',$rotation->id)->first()->pivot->duration;
                                    @endphp
                                    <tr class="table-active">
                                        <td>{{ $course->course_name }}</td>
                                        <td>{{ $date }} </span></td>
                                        <td>{{ $time }}</td>
                                        <td>{{ $duration }}</td>
                                        <td>{{$course->pivot->created_at}} &nbsp;<span class="badge bg-warning" style="
                                            position: relative;top: 0;font-size:10px">{{\Carbon\Carbon::parse($course->pivot->created_at)->diffForHumans()}}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        @else
            <div class="alert alert-dark alert-dismissible fade show mt-4" role="alert">
                <strong>لا يوجد اعتراضات ل  {{$user->username}} في {{ $rotation->name }}</strong>
            </div>
        @endif
</div>

@endsection