@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1 class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                    <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                  </svg> إضافة مستخدم جديد
                <div class="float-right">
                    <a href="{{url()->previous()}}" class="btn btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg> رجوع
                    </a>
                </div>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="POST" action="{{route('users.store')}}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">الإيميل :</label>
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
                    <label for="username" class="form-label">الأسم :</label>
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
                    <label for="password" class="form-label">كلمة المرور :</label>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">الدور الدئم :</label>
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
                    <label for="temporary_role" class="form-label">الدور المؤقت :</label>
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
                    <label for="faculty_id" class="form-label">الكلية :</label>
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
                    <label for="department_id" class="form-label">القسم :</label>
                    <div class="d-flex">
                      <label for="programming">
                        <input type="radio" id="programming"
                        name="department_id" value="1"
                        class='toggler-wrapper style-4'/>برمجيات
                      </label>
                      <label for="two">
                        <input type="radio" id="network" 
                        name="department_id" value="2"
                        class='toggler-wrapper style-4'/>شبكات
                      </label>
                      <label for="two">
                        <input type="radio" id="artifialIntellegence" 
                        name="department_id" value="3"
                        class='toggler-wrapper style-4'/>ذكاء صنعي
                      </label>
                    </div>
                    @if ($errors->has('department_id'))
                    <span class="text-danger text-left">{{ $errors->first('department_id') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="number_of_observation" class="form-label">عدد المراقبات :</label>
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
                    <label for="city" class="form-label">المدينة :</label>
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
                    <label for="property" class="form-label">العضوية :</label>
                    <select class="form-control" name="property" class="form-control" required>
                            <option value='0'>لا يوجد</option>
                            <option value='1'>عضو هيئة فنية</option>
                            <option value='2'>عضو هيئة تدريسية</option>
                    </select>
                    @if ($errors->has('property'))
                        <span class="text-danger text-left">{{ $errors->first('property') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ URL::previous() }}" class="btn btn-default">إلغاء</a>
            </form>
        </div>

    </div>
@endsection
