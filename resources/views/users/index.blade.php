@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <div class="row">
            <div class="col-lg-9 col-sm-8 col-xs-12">
                <h1 class="text-center m-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                    </svg> المستخدمين
                    في {{auth()->user()->faculty->name}}
                </h1>
            </div>
            <div class="col-lg-3 col-sm-4 col-xs-12">
                <div class="collect-index-btns gap-1">
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-right mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                            <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                          </svg> إضافة مستخدم</a>
                    @endif
                    <a href="{{url()->previous()}}" class="btn btn-dark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                    </svg> رجوع</a>
                </div>
            </div>
        </div>

        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        {{-- @livewire('search') --}}
        @if(count($users))
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                {{-- That is not related with controller - Only for Js --}}
                <label for="search_user" class="form-label">Search :</label>
                <input class="form-control" 
                type="text" 
                id="search_user" 
                onkeyup="searchUsers(
                    JSON.stringify({{ App\Models\User::where('faculty_id',auth()->user()->faculty->id)->toBase()->get() }}),
                    '{{ auth()->user()->faculty->name }}'
                    )" placeholder="Serarch Users"/>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <div style="display: flex!important;
                flex-wrap: nowrap;
                flex-direction: row;
                justify-content: flex-end;
                align-items: baseline;margin-top: 30px;">
                    {!! $users->links() !!}
                </div>
            </div>
            <div class="set-observations col-lg-5 col-md-12 col-sm-12 col-xs-12" style="direction: rtl;">
                <form method="post" class="row g-3"  style="margin-top: 15px;"
                action="{{ route('users.setObservations') }}"
                >
                    @method('patch')
                    @csrf
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <select name="reset_vlaue" class="form-control" required>
                            <option value="">حدد عدد المراقبات</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">14</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <select name="role_user" class="form-control" required>
                            <option value="">حدد دور الشخص</option>
                            <option value="all_users">الكل</option>
                            <option value="بروفيسور">بروفيسور</option>
                            <option value="دكتور">دكتور</option>
                            <option value="مهندس">مهندس</option>
                            <option value="مدرس">مدرس</option>
                            <option value="طالب دراسات">طالب دراسات</option>
                            <option value="موظف إداري">موظف إداري</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <button type="submit" class="float-right btn btn-warning form-control">تهيئة <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                          </svg></button>
                    </div>
                </form>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-light">
                <thead>
                <tr>
                    <th>#</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">property</th>
                    <th scope="col">Role</th>
                    <th scope="col">Temporary Role</th>
                    <th scope="col">Active</th>
                    <th scope="col">City</th>
                    <th scope="col">Courses</th>
                    <th scope="col">num obs</th>
                    {{-- <th scope="col">faculty</th> --}}
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="user-list" name="users-list">
                        @foreach($users as $user)
                            <tr class="{{Auth::user()->id==$user->id? 'text-primary':''}} user" id="{{$user->id}}">
                                <td>{{ $user->id }}</td>

                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td><span class="badge bg-{{($user->property==='عضو هيئة تدريسية')?'primary':'info' }}">{{ $user->property }}</span></td>
                                <td><span class="badge bg-danger">{{$user->role}}</span></td>
                                <td><span class="badge bg-secondary">{{ $user->temporary_role }}</span></td>
                                <td style="display: flex;">
                                    <form id="isActiveForm{{ $user->id }}" method="post" action="{{ route('users.isActive', $user->id) }}">
                                        @method('patch')
                                        @csrf
                                        <input type="checkbox" name="is_active" id="is_active_user{{ $user->id }}" onclick="isActiveUser({{ $user->id }})" class='toggler-wrapper style-4' {{($user->is_active == 1)? 'checked':'' }}>
                                    </form>
                                    @if($user->is_active==1)
                                        <img id="img_warning" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 20px;height: 20px;">
                                        @endif
                                    @if($user->is_active==0)
                                        <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="danger" style="width: 20px;height: 20px;">
                                    @endif
                                </td>
                                <td>{{ $user->city }}</td>
                                <td>
                                    @foreach ($user->teaches()->toBase()->get() as $course)
                                        <span class="badge bg-dark">{{ $course->course_name }}</span>
                                    @endforeach    
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{$user->number_of_observation}}</span>
                                </td>
                                    {{-- <td>
                                        @php
                                            $current_observations_for_all_users=App\Models\User::with('courses')->whereHas('courses',function($query) use($user) {
                                                $query->where('user_id',$user->id);
                                            })->get();
                                            //dd($current_observations_for_all_users);

                                            $dates_distinct=[];
                                            $times_distinct=[];
                                        @endphp
                                        @foreach($current_observations_for_all_users as $current_user)
                                            @foreach($current_user->courses as $course)
                                                @if( (!in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                                    ( in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                                                    (!in_array($course->pivot->date,$dates_distinct) &&  in_array($course->pivot->time,$times_distinct) ) )
                                                        @php 
                                                            array_push($dates_distinct,$course->pivot->date);
                                                            array_push($times_distinct,$course->pivot->time); 
                                                        @endphp
                                                @endif
                                            @endforeach
                                        @endforeach

                                        <span class="badge bg-secondary">{{count($dates_distinct)}}</span>
                                    </td> --}}
                                {{-- <td><span class="badge bg-{{ ($user->faculty->name===Auth::user()->faculty->name)?'success':'dark' }}">{{ $user->faculty->name }}</span></td> --}}
                                <td>
                                    <div class="btn-group-vertical" class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="font-size: 1px;">
                                        {{-- <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary btn-sm me-2">Show</a> --}}

                                        @if((Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد") && count($user->rotationsObjection()->where('id',App\Models\Rotation::latest()->toBase()->first()->id)->toBase()->get()))
                                                <a href="{{ route('objections.user.index', ['user'=>$user->id]) }}" class="btn btn-sm me-2 btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-down" style=" float:left;" viewBox="0 0 16 16">
                                                    <path d="M12.5 9a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7Zm.354 5.854 1.5-1.5a.5.5 0 0 0-.708-.708l-.646.647V10.5a.5.5 0 0 0-1 0v2.793l-.646-.647a.5.5 0 0 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                                  </svg> الإعتراضات</a>
                                        @endif
                                        @if((Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد") && count($user->rooms))
                                                <a href="{{ route('users.observations', $user->id) }}" class="btn btn-secondary btn-sm me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" style=" float:left;" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                  </svg> المراقبات</a>
                                        @endif

                                            <a href="{{ route('users.profile', $user->id) }}" class="btn btn-primary btn-sm me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" style=" float:left;" viewBox="0 0 16 16">
                                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"/>
                                              </svg> الشخصية</a>
                                        @if(Auth::user()->id == $user->id || Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-gear" style=" float:left;" viewBox="0 0 16 16">
                                                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"/>
                                                  </svg> تعديل</a>
                                        @endif

                                        @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                                            <a href="#exampleModalToggle{{ $user->id }}" data-bs-toggle="modal" class="btn btn-danger btn-sm" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-x" style=" float:left;" viewBox="0 0 16 16">
                                                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z"/>
                                              </svg> حذف</a> 
                                        @endif
                                    </div>
                                </td>
                                @include('layouts.partials.popUpDelete',['route_info' => ['users.destroy', $user->id],'description' =>"هل أنت متأكد أنك تريد حذف $user->username"])
                        @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="alert text-black alert-success" role="alert" style="margin-top: 20px;">
                <h4 class="alert-heading">Sorry<h4>
                <p>The Program has not any user yet .</p>
                <hr>
                <p class="mb-0">Whenever you need to add a new user, click the yellow button .</p>
            <h1><a href="{{url()->previous()}}" class="btn btn-secondary"> Back</a></h1>
            {{-- problem in back --}}
            </div>
      @endif
{{-- added --}}
        {{-- <div class="modal show" id="formModal" aria-hidden="true">
            <div class="modal-dialog" style="display:none">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="formModalLabel">Create Todo</h4>
                    </div>
                    <div class="modal-body">
                        <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input value="" id='email'
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    placeholder="Email address" required>
                            </div>
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input value="" id='username'
                                    type="text"
                                    class="form-control"
                                    name="username"
                                    placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id='password' class="form-control" name="password" value="" placeholder="Password" required="required">
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id='verifyPassword' class="form-control" name="password" value="" placeholder="Password" required="required">
                            </div>
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id='role'
                                name="role" required>
                                <option value="">Select role</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Master's student">Master's student</option>
                                <option value="administrative employee">administrative employee</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                        </button>
                        <input type="hidden" id="user_id" name="user_id" value="0">
                    </div>
                </div>
            </div>
        </div> --}}
{{-- added --}}
        <div class="d-flex">
            {!! $users->links() !!}
        </div>

    </div>
@endsection
