@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="container mt-4">
            <h1 class="text-center">
                Personal User Page
                <div class="float-right">
                    <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                </div>
            </h1>
            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <div>
                Email: {{ $user->email }}
            </div>
            <div>
                Username: {{ $user->username }}
            </div>
            <div>
                Role: {{ $user->role }}
            </div>
            <div>
                City: {{ $user->city }}
            </div>
        </div>

    </div>
@endsection
