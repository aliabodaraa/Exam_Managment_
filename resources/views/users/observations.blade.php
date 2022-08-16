@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 m-4 rounded">
        <h3>Observations {{$user_name}} :
            <div style="float: right;"><a href="{{ URL::previous() }}" class="btn btn-dark">Back</a></div>
        </h3>
        <div class="lead">
        </div>
        @if(count($table))
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col" width="15%">date</th>
                        <th scope="col" width="15%">time</th>
                        <th scope="col" width="15%">roleIn</th>
                        <th scope="col" width="15%">course_name</th>
                        <th scope="col" width="15%">current room_name</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($table as $info_table)
                    <tr class="table-active">
                        <td>{{ $info_table['date']}}</td>
                        <td>{{ $info_table['time'] }}</td>
                        <td>{{ $info_table['roleIn'] }}</td>
                        <td>{{ $info_table['course_name'] }}</td>
                        <td>{{ $info_table['room_name'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
@else
        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>There are not any observation assigned To {{$user_name}}</strong>
        </div>
@endif

    </div>

@endsection