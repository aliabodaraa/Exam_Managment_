@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 m-4 rounded">
        <h3> مراقبات {{$user_name}}
            <div style="float: right;"><a href="{{ URL::previous() }}" class="btn btn-dark">Back</a></div>
        </h3>
        <div class="lead"></div>
        @if(count($all_rotations_table))
            @foreach($all_rotations_table as $rotation)
                <div class="card text-dark bg-dark mb-2 mt-4" style="font-size: 16px;">
                    <div class="card-header" style="font-size: 26px;color:white;direction: rtl;">
                        {{ $rotation['name']}}
                        <span class="card-title badge bg-success me-1" style="font-size: 16px;">{{ $rotation['year'] }}</span>
                        <span class="card-title badge bg-secondary me-1" style="font-size: 16px;float: left;">start : {{ $rotation['start_date'] }}</span>
                        <span class="card-title badge bg-danger" style="font-size: 16px;float: left;">end : {{ $rotation['end_date'] }}</span>
                    </div>
                    <div class="card-body" style="font-size: 26px;color:white;text-align:center">
                    </div>
                    <div class="table-observations px-2">
                        <table class="table table-light table-striped">
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
                            @foreach($rotation['observations'] as $observation_table)
                                <tr class="table-active">
                                    <td>{{ $observation_table['date']}}</td>
                                    <td>{{ $observation_table['time'] }}</td>
                                    <td>{{ $observation_table['roleIn'] }}</td>
                                    <td>{{ $observation_table['course_name'] }}</td>
                                    <td>{{ $observation_table['room_name'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                    <strong>There are not any observation assigned To {{$user_name}}</strong>
                </div>
        @endif

</div>

@endsection