@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1 class="text-center m-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                </svg>
                إضافة مقرر جديد
                <div class="float-right">
                    <a href="{{url()->previous()}}" class="btn btn-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                        </svg> رجوع
                    </a>
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
                        @foreach (App\Models\Department::toBase()->get() as $department)
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
                        @foreach (App\Models\Faculty::toBase()->get() as $faculty)
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
