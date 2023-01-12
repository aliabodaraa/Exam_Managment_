@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        @auth
        @php
            $is_find_in_names_list_in_latest_rotation=(bool)$latest_rotation->initial_members()->where('id',Auth::user()->id)->toBase()->get();
        @endphp
            <p class="lead"></p>
            @if( ( (! auth()->user()->is_active || auth()->user()->number_of_observation == 0 ) && !auth()->user()->temporary_role))
                <p class="mb-0 lead"> انت غير متاح في الدورة الأخيرة /{{ $latest_rotation->name }} / {{ $latest_rotation->year }}</p>
            @elseif(auth()->user()->temporary_role)
            <h2>مرحبا </h2>
            @elseif($observations_number_in_latest_rotation == 0 && auth()->user()->number_of_observation && $is_find_in_names_list_in_latest_rotation)
                <div class="alert text-black alert-success your-observations" role="alert" style="margin-top: 20px;">
                    <p class="lead">لم يتم تعيين المراقبات الى الان يمكنك انشاء اعتراضات او تعديلها حتى تاريخ {{ $latest_rotation->end_date }}</p>
                    <hr>
                    <p class="mb-0 lead">بعد تجاوز التاريخ السابق لا يمكنك تعديل اعتراضاتك</p>
                </div>
            @elseif($observations_number_in_latest_rotation>0)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>
                        @if(isset($rotations_in_lastet_rotation_table))
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="mb-0"><a href="{{ route('users.observations',[$user->id]) }}" class="text-muted">Show all</a></p>
                                <p class="lead fw-normal mb-0"> : مراقباتك في اخر دورة </p>
                                </div>
                                <div class="card text-dark bg-dark mb-2" style="font-size: 16px;">
                                <div class="card-header" style="font-size: 26px;color:white;direction: rtl;">
                                    {{ $rotations_in_lastet_rotation_table['name']}}
                                    <span class="card-title badge bg-success me-1" style="font-size: 16px;">{{ $rotations_in_lastet_rotation_table['year'] }}</span>
                                    <span class="card-title badge bg-secondary me-1" style="font-size: 16px;float: left;">start : {{ $rotations_in_lastet_rotation_table['start_date'] }}</span>
                                    <span class="card-title badge bg-danger" style="font-size: 16px;float: left;">end : {{ $rotations_in_lastet_rotation_table['end_date'] }}</span>
                                </div>
                                <div class="card-body" style="font-size: 26px;color:white;text-align:center">
                                </div>
                                <div class="table-observations px-2">
                                    <table class="table table-light table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="15%">date</th>
                                                <th scope="col" width="15%">time</th>
                                                <th scope="col" width="15%">roleIn</th>
                                                <th scope="col" width="15%">course_name</th>
                                                <th scope="col" width="15%">current room_name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        @foreach($rotations_in_lastet_rotation_table['observations'] as $observation_table)
                                            <tr class="table-active">
                                                <td>{{ $observation_table['date']}}</td>
                                                <td>{{ $observation_table['time'] }}</td>
                                                <td>{{ $observation_table['roleIn'] }}</td>
                                                <td>{{ $observation_table['course_name'] }}</td>
                                                <td>{{ $observation_table['room_name'] }}</td>
                                            </tr>
                                        @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
                    {{-- 
    
                    @foreach (App\Models\Course::with('rooms')->whereIn('id',$course_ids)->whereHas('rooms',fn($q) =>
                        $q->where('rotation_id',$latest_rotation->id)
                    )->get() as $room)
                    
                    
                    --}}
            {{-- Warning Section lack of Members start --}}
        @if((Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد"))
            @foreach ($courses_rooms_roles as $course_name => $course_rooms_roles)
                    <div class="d-grid gap-2 mb-2">
                            <div class="alert alert-light alert-dismissible fade show" role="alert" style="direction: rtl">
                                <span class="badge bg-warning">{{ $course_name }}</span>
                                    @foreach ($course_rooms_roles as $room_name => $course_room_roles)
                                    <div class="alert alert-dark alert-dismissible fade show" role="alert" style="direction: rtl">
                                        <h4 class="alert-heading">تحذير !!<h4>
                                        <hr>
                                        <div class="row">
                                            <div class="goTo col-sm-7">
                                                <p>يوجد نقص @foreach ($course_room_roles as $course_room_role) @php echo $course_room_role; @endphp @endforeach  من الأعضاء في القاعة <span class="badge bg-secondary">{{ $room_name }}</span></p>
                                            </div>
                                            <div class="goTo col-sm-5" style="direction: ltr">
                                                {{-- <a href="{{ route('rotations.get_room_for_course',[$latest_rotation->id, $course->id,$room->id]) }}" class="btn btn-warning btn-outline-light">تعديل </a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                        </div>
                    </div>
            @endforeach
        @endif
            {{-- Warning lack of Members start --}}


        @endauth

        @guest
        <h1>Hello From My Application</h1>
        <h2>{{session('success')}}</h2>
        <p class="lead">يمكنك تسجيل الدخول و التفاعل مع الموقع بحسب دورك في كليتك</p>
        @endguest
    </div>
@endsection