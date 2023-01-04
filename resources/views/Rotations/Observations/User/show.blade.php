@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 m-4 rounded">
        <h1 class="text-center">
            <h3> مراقبات <mark>{{$user->username}}</mark>
            <div class="float-right">
                <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
            </div>
        </h1>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @if(isset($rotation_table))
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <p class="mb-0"><a href="{{ route('users.observations',[$user->id]) }}" class="text-muted">Show all</a></p>
                    <p class="lead fw-normal mb-0"> : المراقبات في اخر دورة </p>
                </div>
                <div class="card text-dark bg-dark my-2" style="font-size: 16px;">
                    <div class="card-header" style="font-size: 26px;color:white;direction: rtl;">
                        مراقبات {{ $rotation_table['name']}}
                        <span class="card-title badge bg-success me-1" style="font-size: 16px;">{{ $rotation_table['year'] }}</span>
                        <span class="card-title badge bg-secondary me-1" style="font-size: 16px;float: left;">start : {{ $rotation_table['start_date'] }}</span>
                        <span class="card-title badge bg-danger" style="font-size: 16px;float: left;">end : {{ $rotation_table['end_date'] }}</span>
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
                            @foreach($rotation_table['observations'] as $observation_table)
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
        @else
        <div class="alert alert-dark alert-dismissible fade show mt-4" role="alert">
            <strong>لا يوجد مراقبات ل  {{$user->username}} في {{ $rotation->name }}</strong>
        </div>
        @endif

</div>

@endsection