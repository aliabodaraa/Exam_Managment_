@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1>
                Add new course
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="POST" action="{{route('rotations.store')}}">
                @csrf
                @php

                @endphp
                <div class="mb-3">
                    <label for="name" class="form-label">Rotation Name</label>
                    <select class="form-control" name="name" class="form-control" required>
                        @foreach ($insertion_enabled_rotation as $rot)
                            <option value='{{ $rot }}'>{{ $rot }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                {{-- @dd(date('Y-m-d')) --}}
                <div class="mb-3">
                    <label for="start_date" class="form-label">start_date</label>
                    <input id="date_pickerStart" onclick="myFunction2()" 
                        value="{{ old('start_date') }}"
                        type="date"
                        class="form-control"
                        name="start_date"
                        placeholder="start_date" required>
                    @if ($errors->has('start_date'))
                        <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">end_date</label>
                    <input id="date_pickerEnd" onclick="myFunction2()" 
                        value="{{ old('end_date') }}"
                        type="date"
                        class="form-control"
                        name="end_date"
                        placeholder="end_date" required>
                    @if ($errors->has('end_date'))
                        <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Rotation Year</label>
                    <input value="{{ date('Y') }}"
                    {{-- this value does not transfer to the rotation controller propaply because we use POST Mothod --}}
                        type="number"
                        class="form-control"
                        name="year"
                        placeholder="year" required disabled>
                    @if ($errors->has('year'))
                        <span class="text-danger text-left">{{ $errors->first('year') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">faculty_id</label>
                    <select class="form-control" name="faculty_id" class="form-control" required>
                        @foreach (App\Models\Faculty::all() as $faculty)
                            <option value='{{ $faculty->id }}'>{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('faculty_id'))
                        <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save Rotation</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
    $(document).ready(function () {
        myFunction2=()=>{
            today=new Date(),
            //today=today.toDateString(),
            month = '' + (today.getMonth() + 1),
            day = '' + today.getDate(),
            year = today.getFullYear();
            
            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;
          $('#date_pickerStart').attr('min',[year, month, day].join('-'));
          $('#date_pickerEnd').attr('min',[year, month, day].join('-'));
          console.log([year, month, day].join('-'));  
            //       var d = new Date(date),
            //     month = '' + (d.getMonth() + 1),
            //     day = '' + d.getDate(),
            //     year = d.getFullYear();

            // if (month.length < 2) 
            //     month = '0' + month;
            // if (day.length < 2) 
            //     day = '0' + day;

            // return [year, month, day].join('-');
        }
    });
</script>
@endsection