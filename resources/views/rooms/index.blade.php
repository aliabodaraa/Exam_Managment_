@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Rooms Control Page
            <div style="float: right;">
                <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        @if ($messageDelete = Session::get('room-delete'))
        <div class="alert alert-success alert-block">
            <strong>{{ $messageDelete }}</strong>
        </div>
        @endif
        <div class="lead">
            <a href="{{ route('rooms.create') }}" class="btn btn-success btn-sm float-right">Add new room</a>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="45%">room name</th>
                <th scope="col" width="45%">capacity</th>
                <th scope="col" width="5%">Actions</th>
            </tr>
            </thead>
            <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->room_name }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td><a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-info btn-sm">Edit</a></td>
                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['rooms.destroy', $room->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endsection
