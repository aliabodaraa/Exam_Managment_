@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="row">
            <div class="col-lg-10 col-sm-10 col-xs-10">
                <h1 class="text-center m-0">المستخدمين
                    في {{auth()->user()->faculty->name}}
                </h1>
            </div>
            <div class="col-lg-2 col-sm-2 col-xs-2">
                <div class="collect-index-btns gap-1">
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-right mb-4">إضافة مستخدم</a>
                    @endif
                    <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
                </div>
            </div>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        {{-- @livewire('search') --}}
        @if(count($users))
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                {{-- That is not related with controller - Only for Js --}}
                <label for="search_user" class="form-label">Search :</label>
                <input class="form-control" 
                type="text" 
                id="search_user" 
                onkeyup="searchUsers(
                    JSON.stringify({{ App\Models\User::where('faculty_id',auth()->user()->faculty->id)->get() }}),
                    '{{ auth()->user()->faculty->name }}'
                    )" placeholder="Serarch Users"/>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <div class="d-flex" style="margin-top: 30px;">
                    {!! $users->links() !!}
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-light">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    {{-- <th scope="col">Email</th> --}}
                    <th scope="col">Username</th>
                    <th scope="col">property</th>
                    <th scope="col">Role</th>
                    <th scope="col">Temporary Role</th>
                    <th scope="col">Active</th>
                    <th scope="col">City</th>
                    <th scope="col">Courses</th>
                    <th scope="col">num obs</th>
                    <th scope="col">faculty</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="user-list" name="users-list">
                        @foreach($users as $user)
                            <tr class="{{Auth::user()->id==$user->id? 'text-primary':''}} user" id="{{$user->id}}">
                                <th scope="row">{{ $user->id }}</th>
                                {{-- <td>{{ $user->email }}</td> --}}
                                <td>{{ $user->username }}</td>
                                <td><span class="badge bg-{{($user->property==='عضو هيئة تدريسية')?'primary':'info' }}">{{ $user->property }}</span></td>
                                <td><span class="badge bg-danger">{{$user->role}}</span></td>
                                <td><span class="badge bg-secondary">{{ $user->temporary_role }}</span></td>
                                <td style="display: flex;">
                                    <form id="isActiveForm{{ $user->id }}" method="post" action="{{ route('users.isActive', $user->id) }}">
                                        @method('patch')
                                        @csrf
                                        <input type="checkbox" name="is_active" id="is_active_user{{ $user->id }}" onclick="isActiveUser({{ $user->id }})" class='toggler-wrapper style-4' {{($user->is_active == 1)? 'checked':'' }}>
                                    </form>
                                    @if($user->is_active==1)
                                        <img id="img_warning" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 20px;height: 20px;">
                                        @endif
                                    @if($user->is_active==0)
                                        <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="danger" style="width: 20px;height: 20px;">
                                    @endif
                                </td>
                                <td>{{ $user->city }}</td>
                                <td>
                                    @foreach ($user->teaches()->get() as $course)
                                        <span class="badge bg-dark">{{ $course->course_name }}</span>
                                    @endforeach    
                                </td>
                                @if((Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد"))
                                    <td>
                                        <span class="badge bg-secondary">{{$user->number_of_observation}}</span>
                                    </td>
                                    {{-- <td>
                                        @php
                                            $current_observations_for_all_users=App\Models\User::with('courses')->whereHas('courses',function($query) use($user) {
                                                $query->where('user_id',$user->id);
                                            })->get();
                                            //dd($current_observations_for_all_users);

                                            $dates_distinct=[];
                                            $times_distinct=[];
                                        @endphp
                                        @foreach($current_observations_for_all_users as $current_user)
                                            @foreach($current_user->courses as $course)
                                                @if( (!in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                                    ( in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                                    (!in_array($course->pivot->date,$dates_distinct) &&  in_array($course->pivot->time,$times_distinct) ) )
                                                        @php 
                                                            array_push($dates_distinct,$course->pivot->date);
                                                            array_push($times_distinct,$course->pivot->time); 
                                                        @endphp
                                                @endif
                                            @endforeach
                                        @endforeach

                                        <span class="badge bg-secondary">{{count($dates_distinct)}}</span>
                                    </td> --}}
                                @endif
                                <td><span class="badge bg-{{ ($user->faculty->name===Auth::user()->faculty->name)?'success':'dark' }}">{{ $user->faculty->name }}</span></td>
                                <td>
                                    <div class="btn-group-vertical" class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="font-size: 1px;">
                                        {{-- <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm me-2">Show</a> --}}

                                        @if((Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد") && count($user->rotationsObjection))
                                                <a href="{{ route('objections.user.index', ['user'=>$user->id]) }}" class="btn btn-sm me-2 btn-warning">الإعتراضات</a>
                                        @endif
                                        @if((Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد") && count($user->rooms))
                                                <a href="{{ route('users.observations', $user->id) }}" class="btn btn-secondary btn-sm me-2">المراقبات</a>
                                        @endif

                                            <a href="{{ route('users.profile', $user->id) }}" class="btn btn-primary btn-sm me-2">الصفحة الشخصية</a>
                                        @if(Auth::user()->id == $user->id || Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm me-2">تعديل</a>
                                        @endif

                                        @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                            <a href="#exampleModalToggle" data-bs-toggle="modal" class="btn btn-danger btn-sm" >حذف</a> 
                                        @endif
                                      </div>
                                </td>
                                @include('layouts.partials.popUpDelete',['delete_information' => ['users.destroy', $user->id]])
                        @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="alert text-black alert-success" role="alert" style="margin-top: 20px;">
                <h4 class="alert-heading">Sorry<h4>
                <p>The Program has not any user yet .</p>
                <hr>
                <p class="mb-0">Whenever you need to add a new user, click the yellow button .</p>
            <h1><a href="{{url()->previous()}}" class="btn btn-secondary"> Back</a></h1>
            {{-- problem in back --}}
            </div>
      @endif
{{-- added --}}
        {{-- <div class="modal show" id="formModal" aria-hidden="true">
            <div class="modal-dialog" style="display:none">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="formModalLabel">Create Todo</h4>
                    </div>
                    <div class="modal-body">
                        <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input value="" id='email'
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    placeholder="Email address" required>
                            </div>
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input value="" id='username'
                                    type="text"
                                    class="form-control"
                                    name="username"
                                    placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id='password' class="form-control" name="password" value="" placeholder="Password" required="required">
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id='verifyPassword' class="form-control" name="password" value="" placeholder="Password" required="required">
                            </div>
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id='role'
                                name="role" required>
                                <option value="">Select role</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Master's student">Master's student</option>
                                <option value="administrative employee">administrative employee</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                        </button>
                        <input type="hidden" id="user_id" name="user_id" value="0">
                    </div>
                </div>
            </div>
        </div> --}}
{{-- added --}}
        {{-- <div class="d-flex">
            {!! $users->links() !!}
        </div> --}}

    </div>
@endsection
