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
            <div class="lead">
                
            </div>
            @if ($message = Session::get('retryEntering'))
                <div class="alert alert-danger alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <form method="POST" action="{{route('rooms.store')}}">
                @csrf
                <div class="mb-3">
                    <label for="room_name" class="form-label">room name</label>
                    <input value="{{ old('room_name') }}"
                        type="text"
                        class="form-control"
                        name="room_name"
                        placeholder="room_name" required>
                    @if ($errors->has('room_name'))
                        <span class="text-danger text-left">{{ $errors->first('room_name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input value="{{ old('capacity') }}"
                        type="number"
                        class="form-control"
                        name="capacity"
                        placeholder="capacity" required>
                    @if ($errors->has('capacity'))
                        <span class="text-danger text-left">{{ $errors->first('capacity') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">location</label>
                    <input value="{{ old('location') }}"
                        type="text"
                        class="form-control"
                        name="location"
                        placeholder="location" required>
                    @if ($errors->has('location'))
                        <span class="text-danger text-left">{{ $errors->first('location') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">notes</label>
                    <textarea cols="30" rows="10" value="{{ old('notes') }}"
                        type="text"
                        class="form-control"
                        name="notes"
                        placeholder="write note for this room" required></textarea>
                    @if ($errors->has('notes'))
                        <span class="text-danger text-left">{{ $errors->first('notes') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save Room</button>
            </form>
        </div>
    </div>
@endsection
