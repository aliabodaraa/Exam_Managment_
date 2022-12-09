@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1>
                Add new user
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="POST" action="{{route('users.store')}}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input value="{{ old('email') }}"
                        type="email"
                        class="form-control"
                        name="email"
                        placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username :</label>
                    <input value="{{ old('username') }}"
                        type="text"
                        class="form-control"
                        name="username"
                        placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role :</label>
                    <select class="form-control"
                        name="role" required>
                        <option value="">لا يوجد</option>
                        <option value="بروفيسور">بروفيسور</option>
                        <option value="دكتور">دكتور</option>
                        <option value="مهندس">مهندس</option>
                        <option value="مدرس">مدرس</option>
                        <option value="طالب دراسات">طالب دراسات</option>
                        <option value="موظف إداري">موظف إداري</option>
                    </select>
                    @if ($errors->has('role'))
                        <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="temporary_role" class="form-label">temporary role :</label>
                    <select class="form-control"
                        name="temporary_role">
                        <option value="">لا يوجد</option>
                        <option value="عميد">عميد</option>
                        <option value="نائب إداري">نائب إداري</option>
                        <option value="نائب علمي">نائب علمي</option>
                        <option value="رئيس قسم">رئيس قسم</option>
                        <option value="رئيس دائرة">رئيس دائرة</option>
                        <option value="رئيس شعبة الامتحانات">رئيس شعبة الامتحانات</option>
                        <option value="مراقب دوام">مراقب دوام</option>
                        <option value="رئيس شعبة شؤون الطلاب">رئيس شعبة شؤون الطلاب</option>
                    </select>
                    @if ($errors->has('temporary_role'))
                        <span class="text-danger text-left">{{ $errors->first('temporary_role') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">faculty_id :</label>
                    <select class="form-control" name="faculty_id" class="form-control" required>
                        @foreach (App\Models\Faculty::all() as $faculty)
                            <option value='{{ $faculty->id }}'>{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('faculty_id'))
                        <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="number_of_observation" class="form-label">number_of_observation :</label>
                    <select class="form-control" name="number_of_observation" class="form-control" required>
                        @for ($i = 0; $i <31; $i++)
                            <option value='{{ $i }}'>{{ $i }}</option>
                        @endfor
                    </select>
                    @if ($errors->has('number_of_observation'))
                        <span class="text-danger text-left">{{ $errors->first('number_of_observation') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City :</label>
                    <input value="{{ old('city') }}"
                        type="text"
                        class="form-control"
                        name="city"
                        placeholder="City" required>
                    @if ($errors->has('city'))
                        <span class="text-danger text-left">{{ $errors->first('city') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="property" class="form-label">property : :</label>
                    <select class="form-control" name="property" class="form-control" required>
                            <option value='0'>لا يوجد</option>
                            <option value='1'>عضو هيئة فنية</option>
                            <option value='2'>عضو هيئة تدريسية</option>
                    </select>
                    @if ($errors->has('property'))
                        <span class="text-danger text-left">{{ $errors->first('property') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save user</button>
                <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection
