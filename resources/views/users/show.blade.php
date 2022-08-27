@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Personal User Page</h1>
        <div class="lead">

        </div>

        <div class="container mt-4">
            <div>
                Name: {{ $user->name }}
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
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
    </div>
@endsection
