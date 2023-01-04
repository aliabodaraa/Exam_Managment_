@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1>
                تعديل مواد {{ $user->username }}
                <div class="float-right">
                    <a href="{{ route('users.index') }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="post" action="{{ route('users.store_user_courses', $user->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="courses_user_teach" class="form-label">courses_user_teach</label>
                    <input name="course_user_teach" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                    <datalist id="datalistOptions">
                        @foreach (App\Models\Course::where('faculty_id',auth()->user()->faculty->id)->whereNotIn('id',$user_courses_teaches_ids)->get() as $course)
                            <option value='{{ $course->course_name }}'>
                        @endforeach
                    </datalist>
                    @if ($errors->has('courses_user_teach'))
                        <span class="text-danger text-left">{{ $errors->first('courses_user_teach') }}</span>
                    @endif
                </div>
                <div class="multiselect">
                  <div id="checkboxes" class="d-flex">
                    <label for="one">
                      <input type="checkbox" id="one"
                      name="sections_types[1]"
                      class='toggler-wrapper style-4'/>نظري</label>
                    <label for="two">
                      <input type="checkbox" id="two" 
                      name="sections_types[2]"
                      class='toggler-wrapper style-4'/>عملي</label>
                      @if ($errors->has('sections_types'))
                      <span class="text-danger text-left">{{ $errors->first('sections_types') }}</span>
                      @endif
                  </div>
                </div>

                <button type="submit" class="btn btn-primary">تخصيص مادة</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">إلغاء</button>
            </form>
        </div>
    </div>
@endsection