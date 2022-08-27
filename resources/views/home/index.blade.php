@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        @auth
            <h2>Hello {{ auth()->user()->username }}</h2>
            <p class="lead">You are Only authenticated person where you can access to some specific sections that others can't access to them.</p>
        @endauth

        @guest
        <h1>Hello From My Application</h1>
        <h2>{{session('success')}}</h2>
        <p class="lead">Your viewing the home page. Please <mark>Login</mark> to view the restricted data<br>this application to manage time exam whereas each user can overview what times specific for him .</p>
        @endguest
    </div>
@endsection
