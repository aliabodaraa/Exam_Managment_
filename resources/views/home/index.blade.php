@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        @auth
            <h2>Hello From My Application</h2>
            <p class="lead">Only authenticated users can access this section.</p>
                <div class="courses">

                  </div>
             <h4 style="margin-top:10px;">Some Of Your Posts :</h4>
                <div class="posts" style="display: -webkit-box;
                overflow-x: scroll;">

                </div>
                <a href="{{route('courses.create')}}" class="btn btn-warning">new course</a>
                all your courses that you will atend them
                <div class="row">
                    "@foreach (Auth::user()->courses as $item)
                {{$item}}
                    @endforeach"
                </div>
        @endauth

        @guest
        <h1>Homepage</h1>
        <h2>{{session('success')}}</h2>
        <p class="lead">Your viewing the home page. Please <mark>Login</mark> to view the restricted data Or click <mark>Sign-up</mark> button to create a new account for you</p>
        @endguest
    </div>
@endsection
