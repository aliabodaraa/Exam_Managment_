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
            <tbody>
                    @foreach($users as $user)
                        <tr class="{{Auth::user()->id==$user->id? 'text-primary':''}}">
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

        <div class="d-flex">
            {!! $users->links() !!}
        </div>

    </div>
@endsection
