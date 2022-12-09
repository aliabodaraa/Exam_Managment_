@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="row">
            <div class="col-lg-10 col-sm-10 col-xs-10">
                <h1 class="text-center m-0">الدورات الامتحانية
                    في {{auth()->user()->faculty->name}}
                </h1>
            </div>
            <div class="col-lg-2 col-sm-2 col-xs-2">
                <div class="collect-index-btns gap-1">
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                        <a href="{{ route('rotations.create') }}" class="btn btn-primary float-right" style="{{ $count_existing_rotation==3 ?'display: none;':'' }}">إضافة دورة امتحانية</a>
                    @endif
                    <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
                </div>
            </div>
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    @if(count($rotations))
    <div class="table-responsive">
            <table class="table table-light">
                <thead>
                <tr>
                    <th scope="col" width="15%">rotation name</th>
                    <th scope="col" width="15%">year</th>
                    <th scope="col" width="15%">start_date</th>
                    <th scope="col" width="15%">end_date</th>
                    <th scope="col" width="15%">faculty</th>
                    <th scope="col" width="25%">Actions</th>
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
                                    @if(!$observations_number_in_latest_rotation && auth()->user()->number_of_observation && auth()->user()->is_active  && !auth()->user()->temporary_role)
                                        @php
                                        $num_of_my_courses_objections=App\Models\Course::with('rotationsObjection')->whereHas('rotationsObjection', function($query) use($rotation){
                                        $query->where('user_id',Auth::user()->id)->where('rotation_id',$rotation->id);})->pluck('id')->toArray();
                                        @endphp
                                        @if(!count($num_of_my_courses_objections))
                                            <a href="{{ route('rotations.objections.create',$rotation->id) }}"  class="btn btn-secondary btn-sm">إنشاء إعتراضات</a>
                                        @else
                                            <a href="{{ route('rotations.objections.edit',$rotation->id) }}"  class="btn btn-secondary btn-sm">تعديل إعتراضاتي</a>
                                        @endif
                                    @endif    
                                        <a href="{{ route('rotations.program.show',$rotation->id) }}" class="btn btn-success btn-sm">البرنامج الامتحاني</a>
                                        @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                            <a href="/rotations/{{$rotation->id}}/edit" class="btn btn-info btn-sm btn-close-white">Edit</a>
                                            <a href="#exampleModalToggle" data-bs-toggle="modal" class="btn btn-danger btn-sm" >Delete</a> 
                                        @endif
                                        @include('layouts.partials.popUpDelete',['delete_information' => ['rotations.destroy', $rotation->id]])
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
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
