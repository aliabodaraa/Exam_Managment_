@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>القاعات الامتحانية
            <div style="float: right;">
                <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        @if ($messageDelete = Session::get('room-delete'))
        <div class="alert alert-success alert-block">
            <strong>{{ $messageDelete }}</strong>
        </div>
        @endif
        @if(auth()->user()->id==1)
            <div class="lead">
                <a href="{{ route('rooms.create') }}" class="btn btn-warning float-right mb-4">إضافة قاعة</a>
            </div>
        @endif
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    @if(count($rooms))
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col" width="20%">room name</th>
                <th scope="col" width="20%">capacity</th>
                <th scope="col" width="20%">location</th>
                <th scope="col" width="30%">notes</th>
                @if(auth()->user()->id==1)<th scope="col" width="10%">Actions</th>@endif
            </tr>
            </thead>
            <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->room_name }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td>{{ $room->location }}</td>
                            <td>{{ $room->notes }}</td>
                            @if(auth()->user()->id==1)
                                <td style="display:flex;">
                                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-info btn-sm me-2 btn-close-white">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['rooms.destroy', $room->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
            </tbody>
        </table>
        @else
        <div class="alert text-black alert-success" role="alert" style="margin-top: 20px;">
            <h4 class="alert-heading">Sorry<h4>
            <p>There are not any room yet .</p>
            <hr>
            <p class="mb-0">Whenever you need to add a new room, click the yellow button .</p>
           <h1><a href="{{url()->previous()}}" class="btn btn-secondary"> Back</a></h1>
           {{-- problem in back --}}
        </div>
      @endif
    </div>
@endsection
