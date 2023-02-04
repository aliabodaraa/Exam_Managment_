@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <button class="scroll_buttom_button" style="position: fixed;
        top: 367px;
        right: 0;
        border-radius: 63px;border: 1px solid #eaeaea;
        width: 63px;
        height: 63px;
        z-index: 999;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path></svg>
        </button>
        <button class="scroll_top_button" style="position: fixed;
        top: 167px;
        right: 0;
        border-radius: 63px;
        border: 1px solid #eaeaea;
        width: 63px;
        height: 63px;
        z-index: 999;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path></svg>
        </button>
        <div class="container-fluid mt-4">
            <h1 class="text-center">
                تهيئة الأعضاء في  {{ $rotation->name }}
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <div class="col-sm-3 mb-4" 
             style="position: relative;"
            >
                <span class="badge bg-info result" style="position: absolute;
                top: 23px;"></span>
                {{-- That is not related with controller - Only for Js --}}
                <label for="searchForUserNameInInitialMembers" class="form-label">البحث عن أعضاء :</label>
                <input class="form-control searchForUserNameInInitialMembers" 
                type="text" 
                onkeyup="searchForUserNameInInitialMembers(JSON.stringify({{ collect($users_and_roomHeads) }}))" placeholder="Serarch Users">
            </div>
            <form method="post" action="{{ route('rotations.store_initial_members', $rotation->id) }}">
                @csrf
                <div class="users row text-center">
                    @foreach ($users_and_roomHeads as $user_id => $user)
                        <div class="user col-lg-2 col-sm-4 col-xs-12 card text-dark bg-light {{ (in_array($user_id,$disabled_users))?'border-danger':'' }} {{ (in_array($user,$users))?'border-secondary':'border-warning' }} user {{ $user_id }}">
                            <div class="card-header fs-6">
                                <b>{{$user}}</b>
                                @if(in_array($user_id,$disabled_users))
                                    <span class="badge bg-danger xsmall">Not Active</span>
                                @endif
                            </div>
                            <div class="card-body multiselect fs-6 m-auto">
                                <p class="card-text">
                                        <div id="rotationUsersOptions_create" class="d-flex">
                                            <label for="one">
                                            <input type="checkbox" id="room_head_create"
                                            name="users[{{ $user_id }}][1]"
                                            class='toggler-wrapper style-4'
                                            {{ (!in_array($user,$users) && !in_array($user_id,$disabled_users))?'checked':'' }}
                                            {{ in_array($user_id,$disabled_users)?'disabled':'' }}
                                            />رئيس قاعة</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label for="two">
                                            <input type="checkbox" id="secertary_create" 
                                            name="users[{{ $user_id }}][2]"
                                            class='toggler-wrapper style-4'
                                            {{ (!in_array($user,$users)|| in_array($user_id,$disabled_users))?'disabled':'' }}
                                            />أمين سر</label>
                                        </div>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary mt-4">حفظ</button>
                <a href="{{ route('rotations.index') }}" class="btn btn-default mt-4">إلغاء</button>
            </form>
        </div>
    </div>
@endsection