@extends('layouts.app-master')

@section('content')
<div class="bg-light p-4 rounded">
    <div class="container mt-4">
            <div class="row">
                <div class="col-lg-10 col-sm-10 col-xs-10">
                    <h1 class="text-center m-0">
                        تعديل مواد {{ $user->username }}
                        <div class="float-right">
                            <a href="{{ URL::previous() }}" class="btn btn-dark">Back</a>
                        </div> 
                    </h1>
                </div>
                <div class="col-lg-2 col-sm-2 col-xs-2">
                    <div class="collect-index-btns gap-1">
                        <a href="{{ route('users.create_user_courses',$user->id) }}" class="btn btn-primary float-right mb-2">إضافة مادة 
                        <a href="{{url()->previous()}}" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
        <div class="row" style="margin-top:70px;">
               <div class="col-sm-10">
                <form method="post" action="{{ route('users.update_user_courses', $user->id) }}">
                    @method('patch')
                    @csrf
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" width="25%">Name</th>
                            <th scope="col" width="25%">Year</th>
                            <th scope="col" width="25%">Section</th>
                            <th scope="col" colspan="3" width="25%"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach(App\Models\Course::with('teachesBy')->whereHas('teachesBy',function($q) use($user){
                                    $q->where('user_id',$user->id);
                            })->where('faculty_id',auth()->user()->faculty->id)->get() as $course)
                                <tr>
                                    <td><span class="badge bg-success">{{ $course->course_name }}</span></td>
                                    <td>{{ $course->studing_year }}</td>
                                    <td>
                                        <div class="multiselect">
                                            <div id="checkboxes" class="d-flex">
                                            <label for="one">
                                                <input type="checkbox" id="one"
                                                name="sections_types[{{ $course->id }}][1]"
                                                class='rooms toggler-wrapper style-4'
                                                {{ count($course->teachesBy()->wherePivot('user_id',$user->id)->wherePivot('section_type','نظري')->get())
                                                    ? 'checked'
                                                    : '' }}
                                                {{ count($course->teachesBy()->wherePivot('user_id',$user->id)->wherePivot('section_type','نظري - عملي')->get())
                                                ? 'checked'
                                                : '' }}/>نظري</label>
                                            <label for="two">
                                                <input type="checkbox" id="two" 
                                                name="sections_types[{{ $course->id }}][2]"
                                                class='rooms toggler-wrapper style-4'
                                                {{ count($course->teachesBy()->wherePivot('user_id',$user->id)->wherePivot('section_type','عملي')->get())
                                                    ? 'checked'
                                                    : '' }}
                                                {{ count($course->teachesBy()->wherePivot('user_id',$user->id)->wherePivot('section_type','نظري - عملي')->get())
                                                ? 'checked'
                                                : '' }}/>عملي</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
            <div class="col-sm-1">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Operations</th>
                            <th scope="col" colspan="3" width="100%"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach(App\Models\Course::with('teachesBy')->whereHas('teachesBy',function($q) use($user){
                                    $q->where('user_id',$user->id);
                            })->where('faculty_id',auth()->user()->faculty->id)->get() as $course)
                                <tr>
                                    <td>
                                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy_user_courses',['user'=>$user,'course'=>$course]],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm mb-3']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div> 
    </div>
</div>
@endsection