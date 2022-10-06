@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>الدورات الامتحانية
            {{-- <div style="float: right;">
                <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
            </div> --}}
            @if(auth()->user()->id==1)
                <div style="float: right;">
                    <div class="lead">
                        <a href="{{ route('rotations.create') }}" class="btn btn-warning float-right mb-4" style="{{ $count_existing_rotation==3 ?'display: none;':'' }}">إضافة دورة امتحانية</a>
                    </div>
                </div>
            @endif
        </h1>
        @if ($messageDelete = Session::get('rotation-delete'))
        <div class="alert alert-success alert-block">
            <strong>{{ $messageDelete }}</strong>
        </div>
        @endif
        {{-- @if(auth()->user()->id==1)
            <div class="lead">
                <a href="{{ route('rotations.create') }}" class="btn btn-warning float-right mb-4">Add new rotation</a>
            </div>
        @endif --}}
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    @if(count($rotations))
        <table class="table table-light">
            <thead>
            <tr>
                <th scope="col" width="10%">rotation name</th>
                <th scope="col" width="10%">year</th>
                <th scope="col" width="10%">start_date</th>
                <th scope="col" width="10%">end_date</th>
                <th scope="col" width="10%">faculty</th>
                <th scope="col" width="17%">Actions</th>
            </tr>
            </thead>
            <tbody>
                    @foreach($rotations as $rotation)
                        <tr class="{{App\Models\Rotation::latest()->first()->id==$rotation->id? 'text-primary':''}}" id="user{{$rotation->id}}">
                            <td>{{ $rotation->name }}</td>
                            <td>{{ $rotation->year }}</td>
                            <td>{{ $rotation->start_date }}</td>
                            <td>{{ $rotation->end_date }}</td>
                            <td>{{ $rotation->faculty->name }}</td>
                            <td style="display:inline-block;align-items:baseline;">
                                    @php
                                    $num_of_my_courses_objections=App\Models\Course::with('rotationsObjection')->whereHas('rotationsObjection', function($query) use($rotation){
                                    $query->where('user_id',Auth::user()->id)->where('rotation_id',$rotation->id);})->pluck('id')->toArray();
                                    @endphp
                                    @if(!count($num_of_my_courses_objections))
                                        <a href="{{ route('rotations.objections.create',$rotation->id) }}"  class="btn btn-secondary btn-sm">إنشاء إعتراضات</a>
                                    @else
                                        <a href="{{ route('rotations.objections.edit',$rotation->id) }}"  class="btn btn-secondary btn-sm">تعديل إعتراضاتي</a>
                                    @endif
                                    <a href="{{ route('rotations.program.show',$rotation->id) }}" class="btn btn-success btn-sm">البرنامج الامتحاني</a>
                                    @if(auth()->user()->id==1)
                                        <a href="/rotations/{{$rotation->id}}/edit" class="btn btn-info btn-sm btn-close-white">Edit</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['rotations.destroy', $rotation->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                    @endif
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        @else
        <div class="alert text-black alert-warning" role="alert" style="margin-top: 20px;">
            <h4 class="alert-heading">Sorry<h4>
            <p>There are not any rotation yet .</p>
            <hr>
            <p class="mb-0">Whenever you need to add a new rotation, click the yellow button .</p>
           <h1><a href="{{url()->previous()}}" class="btn btn-secondary"> Back</a></h1>
           {{-- problem in back --}}
        </div>
      @endif
    </div>
@endsection
