@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h1>المستخدمين
            <div style="float: right;">
                <a href="{{url()->previous()}}" class="btn btn-dark">رجوع</a>
            </div>
        </h1>
        <div class="lead">
            @if(auth()->user()->id==1)
                <a href="{{ route('users.create') }}" class="btn btn-warning float-right mb-4">إضافة مستخدم</a>
            @endif
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        {{-- @livewire('search') --}}
        @if(count($users))
        <table class="table table-light">
            <thead>
            <tr>
                <th scope="col" width="5%">#</th>
                <th scope="col" width="15%">Email</th>
                <th scope="col" width="15%">Username</th>
                <th scope="col" width="10%">Role</th>
                <th scope="col" width="10%">Temporary Role</th>
                <th scope="col" width="10%">Active</th>
                @if(auth()->user()->id==1)
                    <th scope="col" width="5%">number observation</th>
                    {{-- <th scope="col" width="5%">current number_of_observation</th> --}}
                @endif
                <th scope="col" width="15%">faculty</th>
                <th scope="col" width="15%" colspan="3">Actions</th>
            </tr>
            </thead>
            <tbody id="user-list" name="users-list">
                    @foreach($users as $user)
                        <tr class="{{Auth::user()->id==$user->id? 'text-primary':''}}" id="user{{$user->id}}">
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td><span class="badge bg-danger">{{$user->role}}</span></td>
                            <td><span class="badge bg-warning">{{ $user->temporary_role }}</span></td>
                            <td style="display: flex;">
                                <form id="isActiveForm{{ $user->id }}" method="post" action="{{ route('users.isActive', $user->id) }}">
                                    @method('patch')
                                    @csrf
                                    <input type="checkbox" name="is_active" id="is_active" onclick="isActive({{ $user->id }})" class='toggler-wrapper style-4' {{($user->is_active == 1)? 'checked':'' }}>
                                </form>
                                @if($user->is_active==1)
                                    <img id="img_warning" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 20px;height: 20px;">
                                    @endif
                                    @if($user->is_active==0)
                                    <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="danger" style="width: 20px;height: 20px;">
                                @endif
                            </td>
                            @if(auth()->user()->id==1)
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
                            <td>{{ $user->faculty->name }}</td>
                            <td style="display:flex;align-items:baseline;">
                                         @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                            <a href="{{ route('users.observations', $user->id) }}" class="btn btn-info btn-sm me-2 btn-close-white">observations</a>
                                        @endif
                                        <a href="{{ route('users.profile', $user->id) }}" class="btn btn-primary btn-sm me-2">profile</a>
                                        {{-- <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm me-2">Show</a> --}}

                                        @if(Auth::user()->id == $user->id)
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm me-2">Edit</a>
                                        @endif

                                         @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                            {!! Form::close() !!}
                                        @endif
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
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
        {{-- <div class="modal show" id="formModal" aria-hidden="true"> --}}
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
        </div>
{{-- added --}}
        <div class="d-flex">
            {!! $users->links() !!}
        </div>

    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"> </script>

<script type="text/javascript">
    $(document).ready(function(){//console.log(4444);
        //----- Open model CREATE -----//
        jQuery('#btn-add').click(function () {
            jQuery('#btn-save').val("add");
            jQuery('#myForm').trigger("reset");
            jQuery('#formModal').modal('show');
        });
        // CREATE
        $("#btn-save").click(function (e) {//console.log(4444);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = {
                email: jQuery('#email').val(),
                username: jQuery('#username').val(),
                password: jQuery('#password').val(),
                verifyPassword: jQuery('#verifyPassword').val(),
                role: jQuery('#role').val(),
            };
            var state = jQuery('#btn-save').val();
            var type = "POST";
            var user_id = jQuery('#user_id').val();
            var ajaxurl = 'http://127.0.0.1:8000/users/create';
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    var user = '<tr id="user' + data.id + '"><td>' + data.id + '</td><td>' + data.username + '</td><td>' + data.password + '</td><td>' + data.password ;
                    if (state == "add") {
                        jQuery('#user-list').append(user);
                    } else {
                        jQuery("#user" + user_id).replaceWith(user);
                    }
                    jQuery('#myForm').trigger("reset");
                    jQuery('#formModal').modal('hide')
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });




        //is active

        isActive=(user_id)=>{
            if(! $('#is_active').is(':checked'))
                $('#is_active').prop('value', false)
            else
                $('#is_active').prop('value', true)
            $('#isActiveForm'+user_id).submit();
        }
        

        //is active
    });

    </script>
