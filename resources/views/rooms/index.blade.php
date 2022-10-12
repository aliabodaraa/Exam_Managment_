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
        <table class="table table-light">
            <thead>
            <tr>
                <th scope="col" width="15%">room name</th>
                <th scope="col" width="15%">capacity</th>
                <th scope="col" width="10%">is_active</th>
                <th scope="col" width="10%">faculty</th>
                <th scope="col" width="15%">location</th>
                <th scope="col" width="20%">notes</th>
                @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                    <th scope="col" width="10%">Actions</th>
                @endif
            </tr>
            </thead>
            <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->room_name }}</td>
                            <td>{{ $room->capacity }}</td>
                            <td style="display: flex;">
                                <form id="isActiveForm{{ $room->id }}" method="post" action="{{ route('rooms.isActive', $room->id) }}">
                                    @method('patch')
                                    @csrf
                                    <input type="checkbox" name="is_active" id="is_active" onclick="isActive({{ $room->id }})" class='toggler-wrapper style-4' {{($room->is_active == 1)? 'checked':'' }}>
                                </form>
                                @if($room->is_active==1)
                                    <img id="img_warning" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 20px;height: 20px;">
                                    @endif
                                    @if($room->is_active==0)
                                    <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="danger" style="width: 20px;height: 20px;">
                                @endif
                            </td>
                            <td>{{ $room->faculty->name }}</td>
                            <td>{{ $room->location }}</td>
                            <td>{{ $room->notes }}</td>
                            @if(auth()->user()->id==1)
                                <td style="display:flex;align-items:baseline;">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"> </script>

<script type="text/javascript">
    $(document).ready(function(){

        //is active

        isActive=(room_id)=>{
            if(! $('#is_active').is(':checked'))
                $('#is_active').prop('value', false)
            else
                $('#is_active').prop('value', true)
            $('#isActiveForm'+room_id).submit();
        }
        

        //is active
    });

    </script>