@extends('layouts.app-master')

@section('content')

    <h1 class="mb-3">
        Control's @role('Admin')Admin <div class="lead">You Can Manage Any room Has A Role Student Or Teacher So You @can('room-edit') Can Edit ,@endcan @can('room-edit')Delete @endcan Any One You Need @can('room-create') , Also You Can Add A New room @endcan .</div>@endrole
                  @role('Teacher')Teacher<div class="lead">You Can Show Any Profile's Admin Or Any one Of Your Teacher Colleagues here Also you @can('room-edit') Can Edit ,@endcan @can('room-edit')Delete @endcan Any Student In Your Department Only @can('room-create') , Also You Can Add A New room @endcan . @endrole
                  @role('Student')Student<div class="lead">You Can Show Any Profile's Admin Or Profile's Teacher Or Any one Of Your Student Colleagues here @can('room-edit')Also You Can Edit Any Student In Your Department Only ,@endcan @can('room-edit')Also You Can Delete Any Student In Your Department Only @endcan  @can('room-create') , Also You Can Add A New room @endcan . @endrole
    </h1>
    <div class="bg-light p-4 rounded">
        <h1>rooms
            <div style="float: right;">
                <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        <div class="lead">
            <a href="{{ route('rooms.create') }}" class="btn btn-success btn-sm float-right">Add new room</a>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="50%">room name</th>
                <th scope="col" width="50%">capacity</th>
            </tr>
            </thead>
            <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->room_name }}</td>
                            <td>{{ $room->capacity }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
@endsection
