@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1>
                إضافة مقرر جديد
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="lead">

            </div>
            @if ($message = Session::get('retryEntering'))
                <div class="alert alert-danger alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <form method="POST" action="{{route('courses.store')}}" id="coursesForm">
                @csrf
                <div class="mb-3">
                    <label for="course_name" class="form-label">course_name :</label>
                    <input value="{{ old('course_name') }}"
                        type="text"
                        class="form-control"
                        name="course_name"
                        placeholder="course_name" required>
                    @if ($errors->has('course_name'))
                        <span class="text-danger text-left">{{ $errors->first('course_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Studing Year :</label>
                    <select class="form-control" name="studing_year" class="form-control" required>
                            <option value='1'>سنة أولى</option>
                            <option value='2'>سنة ثانية</option>
                            <option value='3'>سنة ثالثة </option>
                            <option value='4'>سنة رابعة</option>
                            <option value='5'>سنة خامسة</option>
                    </select>
                    @if ($errors->has('studing_year'))
                        <span class="text-danger text-left">{{ $errors->first('studing_year') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Semester :</label>
                    <select class="form-control" name="semester" class="form-control" required>
                            <option value='1'>فصل أول</option>
                            <option value='2'>فصل ثاني</option>
                    </select>
                    @if ($errors->has('semester'))
                        <span class="text-danger text-left">{{ $errors->first('semester') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="department_ids" class="form-label">department_ids :</label>
                    <div id="checkboxes" style="text-align-last: justify;
                                                                display: table-caption;
                                                                width: 202px;">
                        @foreach (App\Models\Department::all() as $department)
                            <label for="{{ $department->name }}"  style="display: flex;margin-bottom: 8px;">
                            <input type="checkbox" id="{{ $department->id }}" 
                            name="department_ids[{{ $department->id }}]"
                            value="{{ $department->id }}"
                            class='rooms toggler-wrapper style-4'/>
                            {{ $department->name }}
                            </label>
                        @endforeach
                        @if ($errors->has('department_ids'))
                        <span class="text-danger text-left">{{ $errors->first('department_ids') }}</span>
                        @endif
                      </div>
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
                <button type="submit" class="btn btn-primary">Save course</button>
                {{-- <a href="{{ route('courses.index') }}" class="btn btn-default">Back</a> --}}
            </form>
        </div>

    </div>

@endsection
@section('scripts')
<script type="text/javascript">
    let request = new XMLHttpRequest();
    console.log(request.readyState);
    request.onreadystatechange=()=>{
        if(request.readyState==4)
            if(request.status==200)
                console.log(request.responseText);
            else if(request.status==404)
                console.log("Not Found");
    }
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Save');

        $.ajax({
          data: $('#coursesForm').serialize(),
          url: "{{ route('courses.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#bookForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
request.open("GET","/resources/views/courses/edit.blade.php",true);
request.send();
console.log("Ali");
 </script>
@endsection
