@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1>
                Update Room Page
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="lead">

            </div>
            <form method="post" action="{{ route('rooms.update', $room->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="roon-name" class="form-label">Room Name</label>
                    <input value="{{ $room->room_name }}"
                        type="text"
                        class="form-control"
                        name="room_name"
                        placeholder="room_name"
                        value="{{$room->room_name}}" required>
                    @if ($errors->has('room_name'))
                        <span class="text-danger text-left">{{ $errors->first('room_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label">Room Name</label>
                    <input value="{{ $room->capacity }}"
                        type="number"
                        class="form-control"
                        name="capacity"
                        placeholder="capacity"
                        value="{{$room->capacity}}" required>
                    @if ($errors->has('capacity'))
                        <span class="text-danger text-left">{{ $errors->first('capacity') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Room Name</label>
                    <input value="{{ $room->location }}"
                        type="text"
                        class="form-control"
                        name="location"
                        placeholder="location"
                        value="{{$room->location}}" required>
                    @if ($errors->has('location'))
                        <span class="text-danger text-left">{{ $errors->first('location') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">notes</label>
                    <textarea cols="30" rows="10"
                        type="text"
                        class="form-control"
                        name="notes"
                        placeholder="notes" required>{{ $room->notes }}</textarea>
                    @if ($errors->has('notes'))
                        <span class="text-danger text-left">{{ $errors->first('notes') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="faculty_id" class="form-label">faculty_id</label>
                    <select class="form-control" name="faculty_id" class="form-control" required>
                        @foreach (App\Models\Faculty::all() as $faculty)
                            <option value='{{ $faculty->id }}' {{ ($room->faculty->id == $faculty->id) ? 'selected': '' }}>{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('faculty_id'))
                        <span class="text-danger text-left">{{ $errors->first('faculty_id') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update room</button>
                <a href="{{ route('rooms.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection
