@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1 class="text-center">
                تعديل مقرر {{ $course->course_name }}
                <div class="float-right">
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                    <a href="{{url()->previous()}}" class="btn btn-dark">رجوع
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </h1>
            <div class="lead">

            </div>
            @if ($message = Session::get('retryEntering'))
                <div class="alert alert-danger alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <form method="POST" action="{{route('courses.update',$course->id)}}" id="coursesForm">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="course_name" class="form-label">أسم المقرر :</label>
                    <input value="{{ $course->course_name }}"
                        type="text"
                        class="form-control"
                        name="course_name"
                        placeholder="course_name"
                        required>
                    @if ($errors->has('course_name'))
                        <span class="text-danger text-left">{{ $errors->first('course_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="studing_year" class="form-label">سنة المقرر :</label>
                    <select class="form-control" name="studing_year" class="form-control" required>
                            <option value='1' {{ $course->studing_year=='1'?'selected':'' }}>سنة أولى</option>
                            <option value='2' {{ $course->studing_year=='2'?'selected':'' }}>سنة ثانية</option>
                            <option value='3' {{ $course->studing_year=='3'?'selected':'' }}>سنة ثالثة </option>
                            <option value='4' {{ $course->studing_year=='4'?'selected':'' }}>سنة رابعة</option>
                            <option value='5' {{ $course->studing_year=='5'?'selected':'' }}>سنة خامسة</option>
                    </select>
                    @if ($errors->has('studing_year'))
                        <span class="text-danger text-left">{{ $errors->first('studing_year') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="semester" class="form-label">فصل المقرر :</label>
                    <select class="form-control" name="semester" class="form-control" required>
                            <option value='1' {{ $course->semester=='1'?'selected':'' }}>فصل أول</option>
                            <option value='2' {{ $course->semester=='2'?'selected':'' }}>فصل ثاني</option>
                    </select>
                    @if ($errors->has('semester'))
                        <span class="text-danger text-left">{{ $errors->first('semester') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="department_ids" class="form-label">القسم الذي ينتمي له المقرر (أختياري) :</label>
                    <div id="checkboxes" style="text-align-last: justify;margin-top: 24px;
                                                display: table-caption;
                                                width: 202px;">
                        @foreach (App\Models\Department::all() as $department)
                            <label for="{{ $department->name }}" style="display: flex;margin-bottom: 8px;">
                            <input type="checkbox"
                            id="{{ $department->id }}"
                            name="department_ids[{{ $department->id }}]"
                            class='toggler-wrapper style-4'
                            {{ in_array($department->id,$current_departments_ids)?'checked':'' }}/>
                            {{ $department->name }}
                            </label>
                        @endforeach
                        @if ($errors->has('department_ids'))
                        <span class="text-danger text-left">{{ $errors->first('department_ids') }}</span>
                        @endif
                      </div>
                </div>
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">الكلية التي ينتمي لها المقرر :</label>
                    <select class="form-control" name="faculty_id" class="form-control" required>
                            <option value='{{ $course->faculty->id }}'>{{ $course->faculty->name }}</option>
                    </select>
                    @if ($errors->has('faculty_id'))
                        <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">تعديل</button>
            </form>
        </div>

    </div>

@endsection
