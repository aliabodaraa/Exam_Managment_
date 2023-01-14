@include('layouts.partials.popUp_cubic')

<div class="collapse show" id="navbarToggleExternalContent">
  <div class="bg-dark p-2 row" id="nav_row">
    {{-- <h5 class="text-white h4">Collapsed content</h5> --}}
    {{-- <span class="text-muted">Toggleable via the navbar brand.</span> --}}
          @auth
          <div class="spinner-border" id="navigation" role="status" style="display: block;z-index:99999999999999999999999999999;
          position: absolute;
          top: 350px;font-size: xxx-large;
          right: 45%;width: 75px;height: 75px; font-weight:bold">
            <span class="visually-hidden">Loading...</span>
          </div>
            <div class="col-lg-3 col-sm-3 col-xs-1" style="display:-webkit-inline-box;">
              <nav class="navbar navbar-inverse navbar-dark bg-dark" id="nav_content_internal">
                  <button id="nav_btn_internal" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
              </nav>
              <div class="faculty">
                <img id="Tishreen_University_logo" src="{{ asset('images/Tishreen_University_logo.webp') }}" alt="Tishreen_University_logo">

                <span class="badge bg-success" id="faculty">{{auth()->user()->faculty->name}}</span>
              </div>
            </div>
          @endauth
          <div class="col-lg-5 col-sm-5 col-xs-10">
            <ul id="nav" class="nav col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" style="font-weight:400">
              <li class="<?php if(
              !str_contains(URL::full(),"users") &&
              !str_contains(URL::full(),"rooms") &&
              !str_contains(URL::full(),"courses") &&
              !str_contains(URL::full(),"rotations")&&
              !str_contains(URL::full(),"objections")&&
              !str_contains(URL::full(),"observations")&&
              !str_contains(URL::full(),"profile")){ echo'Active';}else{echo '';} ?>"><a href="{{ route('home.index') }}" class="nav-link px-2 text-white">الصفحة الرئيسية</a></li>
              @auth
              @php $latest_rotation=App\Models\Rotation::latest()->first();
                  $current_user_id = Auth::user()->id;
                  $num_of_my_courses_objections=Auth::user()->rotationsObjection()->where('id',$latest_rotation->id)->toBase()->get();

                  list($all_rotations_table, $observations_number_in_latest_rotation)=App\Http\Controllers\MaxMinRoomsCapacity\Stock::calcInfoForEachRotationForSpecificuser(auth()->user());
              @endphp
              @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                      <li class="{{ (preg_match("*users*", URL::full()) && !str_ends_with(URL::full(),"profile")) ? 'Active':''}}"><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">المستخدمين</a></li>
                      <li class="{{ preg_match("*rooms*", URL::full()) ? 'Active':''}}"><a href="{{ route('rooms.index') }}" class="nav-link px-2 text-white">القاعات</a></li>
                      <li class="{{ !str_ends_with(URL::full(),"create_user_courses") && !str_ends_with(URL::full(),"edit_user_courses") && preg_match("*courses*", URL::full()) ? 'Active':''}}"><a href="{{ route('courses.index') }}" class="nav-link px-2 text-white">المقررات</a></li>{{-- conditions orchestrated is important --}}
                      <li class="{{ preg_match("*rotations*", URL::full()) ? 'Active':''}}"><a href="{{ route('rotations.index') }}" class="nav-link px-2 text-white">الدورات الامتحانية</a></li>
              @else
                      @php
                      $is_find_in_names_list_in_latest_rotation=(bool)$latest_rotation->initial_members()->where('id',Auth::user()->id)->toBase()->get();
                      //  App\Models\Course::with('rotationsObjection')->whereHas('rotationsObjection', function($query) use($latest_rotation->id){
                      //      $query->where('user_id',Auth::user()->id)->where('rotation_id',$latest_rotation->id);})->pluck('id')->toArray();
                          list($all_rotations_table, $observations_number_in_latest_rotation)=App\Http\Controllers\MaxMinRoomsCapacity\Stock::calcInfoForEachRotationForSpecificuser(Auth::user());
                      @endphp
                      {{-- <li class="{{ (!str_contains(URL::full(),"observations") && preg_match("*rotations*", URL::full()) && str_ends_with(URL::full(),"show")) ? 'Active':''}}"><a href="{{ route('rotations.program.show',[$latest_rotation->id]) }}" class="nav-link px-2 text-white">البرنامج الامتحاني</a></li> --}}
                      @if((auth()->user()->is_active && auth()->user()->number_of_observation && $is_find_in_names_list_in_latest_rotation))
                          @if(count($latest_rotation->users()->toBase()->get()))
                            <li class="{{ (str_contains(URL::full(),"objections")) ? 'Active':''}}">
                              <a href="{{ route('objections.user.show',[$latest_rotation->id,Auth::user()->id]) }}" class="nav-link px-2 text-white">إعتراضاتي</a>
                            </li>
                          @else
                            <li class="{{ (!str_contains(URL::full(),"observations") && preg_match("*rotations*", URL::full()) && (str_ends_with(URL::full(),"objections/create") || str_ends_with(URL::full(),"objections/edit"))) ? 'Active':''}}">
                                @if(!count($num_of_my_courses_objections))
                                    <a href="{{ route('rotations.objections.create',$latest_rotation->id) }}" class="nav-link px-2 text-white">إنشاء إعتراضات</a>
                                @else
                                    <a href="{{ route('rotations.objections.edit',$latest_rotation->id) }}" class="nav-link px-2 text-white">تعديل إعتراضاتي</a>
                                @endif
                            </li>
                        @endif
                      @endif
                      @if($observations_number_in_latest_rotation)
                          <li class="{{ (str_contains(URL::full(),"observations")) ? 'Active':''}}">
                            <a href="{{ route('rotations.observations.user.show',[$latest_rotation->id,Auth::user()->id]) }}" class="nav-link px-2 text-white">مراقباتي</a>
                          </li>
                      @endif
                      {{-- @endif --}}
              @endif
              
              {{-- @if(!count(\App\Models\Rotation::find($latest_rotation->id)->initial_members()->get()))
                <li class="{{ str_ends_with(URL::full(),"initial_members") ? 'Active':''}}"><a href="{{ route('rotations.create_initial_members',$latest_rotation->id) }}" class="nav-link px-2 text-white"> createInitial</a></li>
              @else
                <li class="{{ str_ends_with(URL::full(),"initial_members") ? 'Active':''}}"><a href="{{ route('rotations.edit_initial_members',$latest_rotation->id) }}" class="nav-link px-2 text-white"> updateInitial</a></li>
              @endif --}}
            @endauth
            </ul>
          </div>
          <div class="col-lg-4 col-sm-4 col-xs-1">
            @auth 
            <div class="btns gap-2">
              @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                <a href="{{ route('courses.create') }}" class="btn btn-warning btn-xs" id="addCourse">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                  </svg>
                إضافة مقرر
                </a>
              @endif
              <a href="{{ route('logout.perform') }}" class="btn btn-outline-light btn-xs" id="logout">Logout</a>
            </div>
            @endauth
            <div class="text-end">
              @guest
                <a href="{{ route('login.perform') }}" class="btn btn-outline-light" id="login">Login</a>
              @endguest
              @auth
              <div class="username">
                <span class="badge bg-danger">{{auth()->user()->username}}</span>
              </div>
              <div class="profile-icon">
                <a href="{{ route('users.profile', Auth::user()->id) }}" ><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle text-white mt-1" viewBox="0 0 16 16">
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
                </a>
              </div>
              @endauth
            </div>
          </div>
  </div>
</div>


<nav class="navbar navbar-dark bg-dark" id="nav_content_external" style="display: none">
  <div class="container-fluid">
    <button id="nav_btn_external" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    @auth
    <div class="facu-uname" style="display: inline-flex;">
      <span class="badge bg-danger">{{auth()->user()->username}}</span>
      &nbsp;
      <span class="badge bg-success" id="faculty">{{auth()->user()->faculty->name}}</span>
    </div>
    @endauth
  </div>
</nav>
<script>
let nav=document.getElementById("navbarToggleExternalContent");
let nav_btn_external=document.getElementById("nav_btn_external");
let nav_btn_internal=document.getElementById("nav_btn_internal");
let nav_content_external=document.getElementById("nav_content_external");
let nav_content_internal=document.getElementById("nav_content_internal");
nav_btn_internal.addEventListener("click",()=>{
  if(!nav.classList.contains("show")){
    nav_content_external.style.display="block";
  }
});
nav_btn_external.addEventListener("click",()=>{
  if(!nav.classList.contains("show"))
    nav_content_external.style.display="none";
});
</script>