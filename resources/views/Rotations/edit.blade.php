@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1>
                Update Rotation Page
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="lead">

            </div>
            <form method="post" action="{{ route('rotations.update', $rotation->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Rotation Name</label>
                    <select class="form-control" name="name" class="form-control" value="{{ $rotation->name }}" required>
                            <option value='الدورة الفصلية الأولى'>الدورة الفصلية الأولى</option>
                            <option value='الدورة الفصلية الثانية'>الدورة الفصلية الثانية</option>
                            <option value='الدورة الفصلية الثالة'>الدورة الفصلية الثالثة</option>
                    </select>
                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">rotation Year</label>
                    <input value="{{ $rotation->year }}"
                        type="number"
                        class="form-control"
                        name="year"
                        placeholder="year" required>
                    @if ($errors->has('year'))
                        <span class="text-danger text-left">{{ $errors->first('year') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">start date</label>
                    <input value="{{ $rotation->start_date }}"
                        type="date"
                        class="form-control"
                        name="start_date"
                        placeholder="start_date" required>
                    @if ($errors->has('start_date'))
                        <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">end date</label>
                    <input value="{{ $rotation->end_date }}"
                        type="date"
                        class="form-control"
                        name="end_date"
                        placeholder="end_date" required>
                    @if ($errors->has('end_date'))
                        <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">faculty_id</label>
                    <select class="form-control" name="faculty_id" class="form-control" required>
                        @foreach (App\Models\Faculty::all() as $faculty)
                            <option value='{{ $faculty->id }}' {{ ($rotation->faculty->id == $faculty->id) ? 'selected': '' }}>{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('faculty_id'))
                        <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update rotation</button>
                <a href="{{ route('rotations.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection
