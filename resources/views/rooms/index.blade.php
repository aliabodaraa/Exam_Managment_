@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <div class="row">
            <div class="col-lg-10 col-sm-10 col-xs-10">
                <h1 class="text-center m-0">القاعات الامتحانية
                    في {{auth()->user()->faculty->name}}
                </h1>
            </div>
            <div class="col-lg-2 col-sm-2 col-xs-2">
                <div class="collect-index-btns gap-1">
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary float-right mb-4">إضافة قاعة</a>
                    @endif
                    <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
                </div>
            </div>
        </div>
        @if ($messageDelete = Session::get('room-delete'))
        <div class="alert alert-success alert-block">
            <strong>{{ $messageDelete }}</strong>
        </div>
        @endif
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    @if(count($rooms))
        <div class="col-sm-3 mb-1">
            {{-- That is not related with controller - Only for Js --}}
            <label for="search_user_name" class="form-label">Search :</label>
            <input class="form-control" 
            type="text" 
            id="search_room_name" 
            onkeyup="searchRooms(JSON.stringify({{ App\Models\Room::where('faculty_id',auth()->user()->faculty->id)->get() }}))" placeholder="Serarch Rooms">
        </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                <thead>
                <tr>
                    <th scope="col" width="10%">room name</th>
                    <th scope="col" width="10%">capacity</th>
                    <th scope="col" width="10%">is_active</th>
                    <th scope="col" width="10%">faculty</th>
                    <th scope="col" width="10%">location</th>
                    <th scope="col" width="3%">notes</th>
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                        <th scope="col" width="10%">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                        @foreach($rooms as $room)
                            <tr class="room" id="{{$room->id}}">
                                <td>{{ $room->room_name }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td style="display: flex;">
                                    <form id="isActiveForm{{ $room->id }}" method="post" action="{{ route('rooms.isActive', $room->id) }}">
                                        @method('patch')
                                        @csrf
                                        <input type="checkbox" name="is_active" id="is_active_room" onclick="isActiveRoom({{ $room->id }})" class='toggler-wrapper style-4' {{($room->is_active == 1)? 'checked':'' }}>
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
                                @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                    <td style="display:flex;align-items:baseline;">
                                            <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-info btn-sm me-2 btn-close-white">Edit</a>
                                            <a href="#exampleModalToggle" data-bs-toggle="modal" class="btn btn-danger btn-sm" >Delete</a> 
                                    </td>
                                    @include('layouts.partials.popUpDelete',['delete_information' => ['rooms.destroy', $room->id]])
                                @endif
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
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