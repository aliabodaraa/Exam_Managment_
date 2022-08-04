@extends('layouts.app-master')

@section('content')

    <h1 class="mb-3">
        Control's @role('Admin')Admin <div class="lead">You Can Manage Any User Has A Role Student Or Teacher So You @can('user-edit') Can Edit ,@endcan @can('user-edit')Delete @endcan Any One You Need @can('user-create') , Also You Can Add A New User @endcan .</div>@endrole
                  @role('Teacher')Teacher<div class="lead">You Can Show Any Profile's Admin Or Any one Of Your Teacher Colleagues here Also you @can('user-edit') Can Edit ,@endcan @can('user-edit')Delete @endcan Any Student In Your Department Only @can('user-create') , Also You Can Add A New User @endcan . @endrole
                  @role('Student')Student<div class="lead">You Can Show Any Profile's Admin Or Profile's Teacher Or Any one Of Your Student Colleagues here @can('user-edit')Also You Can Edit Any Student In Your Department Only ,@endcan @can('user-edit')Also You Can Delete Any Student In Your Department Only @endcan  @can('user-create') , Also You Can Add A New User @endcan . @endrole
    </h1>
    <div class="bg-light p-4 rounded">
        <h1>Users
            <div style="float: right;">
                <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        <div class="lead">
            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm float-right">Add new user</a>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="3%">#</th>
                <th scope="col" width="15%">Email</th>
                <th scope="col" width="15%">Username</th>
                <th scope="col" width="10%">Role</th>
                <th scope="col" width="1%" colspan="3">Actions</th>
            </tr>
            </thead>
            <tbody id="user-list" name="users-list">
                    @foreach($users as $user)
                        <tr class="{{Auth::user()->id==$user->id? 'text-primary':''}}" id="user{{$user->id}}">
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <span class="badge bg-danger">{{$user->role}}</span>
                            </td>
                            <td><a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm">Show</a></td>
                            <td><a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a></td>
                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
{{-- added --}}
        {{-- <div class="modal show" id="formModal" aria-hidden="true"> --}}
            <div class="modal-dialog">
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
    });
    </script>
