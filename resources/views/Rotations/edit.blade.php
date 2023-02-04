@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1 class="text-center m-0">
                تعديل الدورة الإمتحانية
                <a href="{{url()->previous()}}" class="btn btn-dark float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg> رجوع
                </a>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <form method="post" action="{{ route('rotations.update', $rotation->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">أسم الدورة :</label>
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
                    <label for="year" class="form-label">السنة :</label>
                    <input value="{{ $rotation->year }}"
                        type="number"
                        class="form-control"
                        name="year"
                        placeholder="year" required disabled>
                    @if ($errors->has('year'))
                        <span class="text-danger text-left">{{ $errors->first('year') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">تاريخ بداية الدورة :</label>
                    <input class="date_picker_start form-control" onclick="date_picker_start()" 
                        value="{{ $rotation->start_date }}"
                        type="date"
                        name="start_date"
                        placeholder="start_date">
                    @if ($errors->has('start_date'))
                        <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">تاريخ نهاية الدورة :</label>
                    <input class="date_picker_end form-control" onclick="date_picker_end()" 
                        value="{{ $rotation->end_date }}"
                        type="date"
                        name="end_date"
                        placeholder="end_date">
                    @if ($errors->has('end_date'))
                        <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">الكلية :</label>
                    <select class="form-control" name="faculty_id" class="form-control" required>
                        @foreach (App\Models\Faculty::toBase()->get() as $faculty)
                            <option value='{{ $faculty->id }}' {{ ($rotation->faculty->id == $faculty->id) ? 'selected': '' }}>{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('faculty_id'))
                        <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a href="{{ route('rotations.index') }}" class="btn btn-default">إلغاء</button>
            </form>
        </div>

    </div>
@endsection
