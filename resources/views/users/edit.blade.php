@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update user</h1>
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
                        <option value='1' {{ ($user->number_of_observation == 1) ? 'selected': '' }}>1</option>
                        <option value='2' {{ ($user->number_of_observation == 2) ? 'selected': '' }}>2</option>
                        <option value='3' {{ ($user->number_of_observation == 3) ? 'selected': '' }}>3</option>
                        <option value='4' {{ ($user->number_of_observation == 4) ? 'selected': '' }}>4</option>
                        <option value='5' {{ ($user->number_of_observation == 5) ? 'selected': '' }}>5</option>
                        <option value='6' {{ ($user->number_of_observation == 6) ? 'selected': '' }}>6</option>
                        <option value='7' {{ ($user->number_of_observation == 7) ? 'selected': '' }}>7</option>
                        <option value='8' {{ ($user->number_of_observation == 8) ? 'selected': '' }}>8</option>
                        <option value='9' {{ ($user->number_of_observation == 9) ? 'selected': '' }}>9</option>
                        <option value='10' {{ ($user->number_of_observation == 10) ? 'selected': '' }}>10</option>
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
