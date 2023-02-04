@extends('layouts.app-master')

@section('content')
    <div class="bg-light fs-2 fw-bold p-4 rounded">
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @auth
        @php
            $is_find_in_names_list_in_latest_rotation=(bool)count($latest_rotation->initial_members()->where('id',Auth::user()->id)->toBase()->get());
        @endphp
        @if(! auth()->user()->is_active && auth()->user()->number_of_observation == 0)
            @if(!auth()->user()->temporary_role)
                    <p class="mb-0 lead"> انت غير مفعل في الدورة الأخيرة /{{ $latest_rotation->name }} / {{ $latest_rotation->year }}</p>
                @else
                    <p class="mb-0 lead">أنت غير مطالب بالمراقبة لأنك تملك الدور المؤقت <mark>{{ auth()->user()->temporary_role }}</mark></p>
            @endif
        @elseif(auth()->user()->temporary_role)

            {{-- <div class="container alert text-black alert-success your-observations" role="alert" style="margin-top: 20px;">
                <p class="lead">تنويه</p>
                <hr>
                <p class="mb-0 lead">أنت غير مطالب بالمراقبة لأنك تملك الدور المؤقت <mark>{{ auth()->user()->temporary_role }}</mark></p>
            </div> --}}
        {{-- @elseif($is_find_in_names_list_in_latest_rotation) --}}
                @elseif($observations_number_in_latest_rotation == 0)
                        <div class="container alert text-black alert-success your-observations" role="alert" style="margin-top: 20px;">
                            <p class="lead">لم يتم تعيين المراقبات ل {{ $latest_rotation->name }} الى الان يمكنك انشاء اعتراضاتك او تعديلها حتى تاريخ {{ $latest_rotation->end_date }}</p>
                            <hr>
                            <p class="mb-0 lead">بعد تجاوز التاريخ السابق لا يمكنك تعديل اعتراضاتك</p>
                        </div>
                @elseif($observations_number_in_latest_rotation>0)
                        <div class="container alert alert-success alert-dismissible fade show" role="alert">
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
                                                        <td>{{ date('D d-m-Y', strtotime($observation_table['date']))}}</td>
                                                        <td>{{ gmdate('H:i A',strtotime($observation_table['time']))}}</td>
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
                {{-- @endif --}}
        {{-- @elseif(!$is_find_in_names_list_in_latest_rotation)
                <div class="container alert text-black alert-warning your-observations" role="alert" style="margin-top: 20px;">
                    <p class="lead">أنت خارج أختيارات الأعضاء المخصصة للمراقبة في  {{ $latest_rotation->name }}</p>
                    <hr>
                    <p class="mb-0 lead">إذا تم اختيارك من بين الأعضاء المخصصة للمراقبة عندها ستتمكن من تقديم إعتراضاتك</p>
                </div> --}}
        @endif

        @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
            <div class="container">
                <div class="row g-2">
                        <div class="col-6 g-2">
                            <div class="row p-3 border bg-light fs-1 blockquote text-center">
                                <h2>عدد المقررات</h2>
                                <div class="col-12">
                                    <div class="p-4 border bg-light fs-3 fw-bold text-center text-muted">{{ count(App\Models\Course::toBase()->pluck('id')) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 g-2">
                            <div class="row p-3 border bg-light fs-1 blockquote text-center">
                                <h2>عدد القاعات</h2>
                                    @if($count_disabled_rooms=count(App\Models\Room::where('is_active',0)->toBase()->pluck('id')))
                                        <div class="col-6">
                                            <div class="p-4 border bg-light fs-3 fw-bold text-center text-muted">غير مفعلة : {{ $count_disabled_rooms }}/{{ count(App\Models\Room::toBase()->pluck('id')) }}</div>
                                        </div>
                                    @endif
                                    <div class="col-{{ $count_disabled_rooms?'6':'12' }}">
                                        <div class="p-4 border bg-light fs-3 fw-bold text-center text-muted">مفعلة : {{ count(App\Models\Room::where('is_active',1)->toBase()->pluck('id')) }}/{{ count(App\Models\Room::toBase()->pluck('id')) }}</div>
                                    </div>
                            </div>
                        </div>

                        <div class="row p-3 border bg-light fs-1 blockquote text-center">
                            <h2>سعات القاعات بالكلية </h2>
                            <div class="col-6">
                                <div class="p-4 border bg-light fs-2 fw-bold text-center text-muted">السعى الدنيا للقاعات :{{ App\Http\Controllers\MaxMinRoomsCapacity\Stock::getMinDistribution() }}</div>
                            </div>
                            <div class="col-6">
                                <div class="p-4 border bg-light fs-2 fw-bold text-center text-muted"> السعى العظمى للقاعات: {{ App\Http\Controllers\MaxMinRoomsCapacity\Stock::getMaxDistribution() }}</div>
                            </div>
                        </div>


                        <div class="col-{{ ($total_num_observations=count($latest_rotation->users()->toBase()->get()))==0?'12':'6' }} g-2">
                            <div class="row p-3 border bg-light fs-1 blockquote text-center">
                                <h2>عدد المستخدمين</h2>
                                @if($count_disabled_users=count(App\Models\User::where('is_active',0)->toBase()->pluck('id')))
                                    <div class="col-6">
                                        <div class="p-4 border bg-light fs-3 fw-bold text-center text-muted">غير مفعل : {{ $count_disabled_users }}/{{ count(App\Models\User::toBase()->pluck('id')) }}</div>
                                    </div>
                                @endif
                                <div class="col-{{ $count_disabled_users?'6':'12' }}">
                                    <div class="p-4 border bg-light fs-3 fw-bold text-center text-muted"> مفعل : {{ count(App\Models\User::where('is_active',1)->toBase()->pluck('id')) }}/{{ count(App\Models\User::toBase()->pluck('id')) }}</div>
                                </div>
                            </div>
                        </div>
                        @if($total_num_observations)
                            <div class="col-6 g-2">
                                <div class="row p-3 border bg-light fs-1 blockquote text-center">
                                    <h2>عدد المراقبات</h2>
                                    <div class="col-12">
                                        <div class="p-4 border bg-light fs-2 fw-bold text-center text-muted">{{ $total_num_observations }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
            </div>
            {{-- Warning Section lack of Members start --}}
            @if(count($latest_rotation->users()->toBase()->get()))
                @foreach ($courses_rooms_roles as $course_name => $course_rooms_roles)
                        <div class="d-grid gap-2 mb-2">
                                <div class="container alert alert-light alert-dismissible fade show" role="alert" style="direction: rtl">
                                    <a href="{{route('rotations.course.edit',['rotation'=>$latest_rotation->id,'course'=>App\Models\Course::query()->where('course_name',$course_name)->toBase()->first()->id])}}" class="badge bg-warning btn btn-info btn-sm btn-outline-light rounded">{{ $course_name }}</a>
                                        @foreach ($course_rooms_roles as $room_name => $course_room_roles)
                                            <div class="container alert alert-dark alert-dismissible fade show" role="alert" style="direction: rtl">
                                                <h4 class="alert-heading">تحذير !!<h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="goTo col-sm-7">
                                                        <p>يوجد نقص @foreach ($course_room_roles as $course_room_role) @php echo $course_room_role; @endphp @endforeach  من الأعضاء في القاعة <span class="badge bg-secondary">{{ $room_name }}</span></p>
                                                    </div>
                                                    <div class="goTo col-sm-5" style="direction: ltr">
                                                        <a href="{{ route('rotations.get_room_for_course',[$latest_rotation->id, App\Models\Course::query()->where('course_name',$course_name)->toBase()->first()->id,App\Models\Room::query()->where('room_name',$room_name)->toBase()->first()->id]) }}" class="btn btn-warning btn-outline-light">تعديل </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                </div>
                        </div>
                @endforeach
            @endif
            {{-- Warning lack of Members start --}}
        @endif

        @endauth

        @guest
        <div style="direction: rtl">
            <h1>أهلا وسهلا</h1>
            <h2>{{session('success')}}</h2>
            <p class="lead">يمكنك تسجيل الدخول و التفاعل مع الموقع بحسب دورك في كليتك</p>
        </div>
        @endguest
    </div>
@endsection