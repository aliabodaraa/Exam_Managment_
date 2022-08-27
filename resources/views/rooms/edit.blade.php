@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update Room Page</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
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
                <button type="submit" class="btn btn-primary">Update room</button>
                <a href="{{ route('rooms.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection
