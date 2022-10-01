@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1>
                Update User Page
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
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
                    <select class="form-control" name="role">
                        <option value="">Select role</option>
                        <option value="Doctor" {{ ($user->role == 'Doctor') ? 'selected': '' }}>Doctor</option>
                        @if($user->id != 1)
                            <option value="Master's student" {{ ($user->role == "Master's student") ? 'selected': '' }}>Master's student</option>
                        @endif
                        <option value="teacher" {{ ($user->role == "teacher") ? 'selected': '' }}>teacher</option>
                        <option value="administrative employee" {{ ($user->role == 'administrative employee') ? 'selected': '' }}>administrative employee</option>
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="temporary_role" class="form-label">temporary role</label>
                    <select class="form-control"
                        name="temporary_role">
                        <option value="">Select temporary role</option>
                        <option value="عميد" {{ ($user->temporary_role == 'عميد') ? 'selected': '' }}>عميد</option>
                        <option value="نائب إداري" {{ ($user->temporary_role == 'نائب إداري') ? 'selected': '' }}>نائب إداري</option>
                        <option value="نائب علمي" {{ ($user->temporary_role == 'نائب علمي') ? 'selected': '' }}>نائب علمي</option>
                        <option value="رئيس قسم" {{ ($user->temporary_role == 'رئيس قسم') ? 'selected': '' }}>رئيس قسم</option>
                        <option value="رئيس دائرة" {{ ($user->temporary_role == 'رئيس دائرة') ? 'selected': '' }}>رئيس دائرة</option>
                        <option value="رئيس شعبة الامتحانات" {{ ($user->temporary_role == 'رئيس شعبة الامتحانات') ? 'selected': '' }}>رئيس شعبة الامتحانات</option>
                        <option value="مراقب دوام" {{ ($user->temporary_role == 'مراقب دوام') ? 'selected': '' }}>مراقب دوام</option>
                        <option value="رئيس شعبة شؤون الطلاب" {{ ($user->temporary_role == 'رئيس شعبة شؤون الطلاب') ? 'selected': '' }}>رئيس شعبة شؤون الطلاب</option>
                    </select>
                    @if ($errors->has('temporary_role'))
                        <span class="text-danger text-left">{{ $errors->first('temporary_role') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">faculty_id</label>
                    <select class="form-control" name="faculty_id" class="form-control" required>
                        @foreach (App\Models\Faculty::all() as $faculty)
                            <option value='{{ $faculty->id }}' {{ ($user->faculty->id == $faculty->id) ? 'selected': '' }}>{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('faculty_id'))
                        <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="number_of_observation" class="form-label">number_of_observation</label>
                    <select class="form-control" name="number_of_observation" class="form-control" required>
                        @for ($i = 0; $i <31; $i++)
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