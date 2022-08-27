@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update User Page</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ $user->email }}"
                        type="email"
                        class="form-control"
                        name="email"
                        placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input value="{{ $user->username }}"
                        type="text"
                        class="form-control"
                        name="username"
                        placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    @if($user->id==1)
                        <span class="badge bg-secondary" style="float:right">{{$user->id==1 ?"Admin can't have Role":''}} </span>
                    @endif
                    <select class="form-control"
                        name="role" {{$user->id==1 ?'disabled':''}}>
                        <option value="">Select role</option>
                        <option value="Doctor" {{ ($user->role == 'Doctor') ? 'selected': '' }}>Doctor</option>
                        <option value="Master's student" {{ ($user->role == "Master's student") ? 'selected': '' }}>Master's student</option>
                        <option value="teacher" {{ ($user->role == "teacher") ? 'selected': '' }}>teacher</option>
                        <option value="administrative employee" {{ ($user->role == 'administrative employee') ? 'selected': '' }}>administrative employee</option>
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="number_of_observation" class="form-label">number_of_observation</label>
                    @if($user->id==1)
                        <span class="badge bg-secondary" style="float:right">{{$user->id==1 ?"Admin can't have observations":''}} </span>
                    @endif
                    <select class="form-control" name="number_of_observation" class="form-control" required  {{$user->id==1 ?'disabled':''}}>
                        @for ($i = 1; $i <31; $i++)
                            <option value='{{ $i }}' {{ ($user->number_of_observation == $i) ? 'selected': '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @if ($errors->has('number_of_observation'))
                        <span class="text-danger text-left">{{ $errors->first('number_of_observation') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update user</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>
    </div>
@endsection