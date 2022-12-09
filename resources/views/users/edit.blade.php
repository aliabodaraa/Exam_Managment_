@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1 class="text-center">
                Update User Page
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
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
                    <label for="username" class="form-label">Username :</label>
                    <input value="{{ $user->username }}"
                        type="text"
                        class="form-control"
                        name="username"
                        placeholder="Username" required>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                @if(Auth::user()->id == $user->id)
                    <div class="mb-3">
                        <label for="old_password" class="form-label">old_password :</label>
                        <input 
                            type="text"
                            class="form-control"
                            name="old_password"
                            placeholder="please enter your old password">
                        @if ($errors->has('old_password'))
                            <span class="text-danger text-left">{{ $errors->first('old_password') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">new_password :</label>
                        <input
                            type="text"
                            class="form-control"
                            name="new_password"
                            placeholder="please enter your new password">
                        @if ($errors->has('new_password'))
                            <span class="text-danger text-left">{{ $errors->first('new_password') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="new_password_verification" class="form-label">new_password_verification :</label>
                        <input
                            type="text"
                            class="form-control"
                            name="new_password_verification"
                            placeholder="reenter your new password">
                        @if ($errors->has('new_password_verification'))
                            <span class="text-danger text-left">{{ $errors->first('new_password_verification') }}</span>
                        @endif
                    </div>
                @endif
                @if((Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد"))
                    <div class="mb-3">
                        <label for="role" class="form-label">Role :</label>
                        <select class="form-control" name="role">
                            <option value="">لا يوجد</option>
                            <option value="بروفيسور"  {{ ($user->role == 'بروفيسور') ? 'selected': '' }}>بروفيسور</option>
                            <option value="دكتور" {{ ($user->role == 'دكتور') ? 'selected': '' }}>دكتور</option>
                            <option value="طالب دراسات" {{ ($user->role == "طالب دراسات") ? 'selected': '' }}>طالب دراسات</option>
                            <option value="مهندس" {{ ($user->role == "مهندس") ? 'selected': '' }}>مهندس</option>
                            <option value="مدرس" {{ ($user->role == "مدرس") ? 'selected': '' }}>مدرس</option>
                            <option value="موظف إداري" {{ ($user->role == 'موظف إداري') ? 'selected': '' }}> موظف إداري</option>
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
                        <label for="faculty_id" class="form-label">faculty_id :</label>
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
                        <label for="number_of_observation" class="form-label">number_of_observation :</label>
                        <select class="form-control" name="number_of_observation" class="form-control" required>
                            @for ($i = 0; $i <31; $i++)
                                <option value='{{ $i }}' {{ ($user->number_of_observation == $i) ? 'selected': '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @if ($errors->has('number_of_observation'))
                            <span class="text-danger text-left">{{ $errors->first('number_of_observation') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City :</label>
                        <input value="{{ $user->city }}"
                            type="text"
                            class="form-control"
                            name="city"
                            placeholder="City" required>
                        @if ($errors->has('city'))
                            <span class="text-danger text-left">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="property" class="form-label">property :</label>
                        <select class="form-control" name="property" class="form-control" required>
                                <option value='0' {{ ($user->property == '') ? 'selected': '' }}>لا يوجد</option>
                                <option value='1' {{ ($user->property == 'عضو هيئة فنية') ? 'selected': '' }}>عضو هيئة فنية</option>
                                <option value='2' {{ ($user->property == 'عضو هيئة تدريسية') ? 'selected': '' }}>عضو هيئة تدريسية</option>
                        </select>
                        @if ($errors->has('property'))
                            <span class="text-danger text-left">{{ $errors->first('property') }}</span>
                        @endif
                    </div>
                @endif
                <button type="submit" class="btn btn-primary">Update user</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>
    </div>
@endsection