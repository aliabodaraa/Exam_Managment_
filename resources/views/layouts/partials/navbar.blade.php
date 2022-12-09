<div class="collapse show" id="navbarToggleExternalContent">
  <div class="bg-dark p-2 row" id="nav_row">
    {{-- <h5 class="text-white h4">Collapsed content</h5> --}}
    {{-- <span class="text-muted">Toggleable via the navbar brand.</span> --}}
          @auth
            <div class="col-lg-3 col-sm-3 col-xs-1" style="display:-webkit-inline-box;">
              <nav class="navbar navbar-dark bg-dark" id="nav_content_internal">
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
              <li class="<?php if(URL::full()=='http://127.0.0.1:8000'){ echo'Active';}else{echo '';} ?>"><a href="{{ route('home.index') }}" class="nav-link px-2 text-white">الصفحة الرئيسية</a></li>
              @auth
              @php $latest_rotation_id=App\Models\Rotation::latest()->first()->id;
                  $current_user_id = Auth::user()->id; 
                  list($all_rotations_table, $observations_number_in_latest_rotation)=App\Http\Controllers\MaxMinRoomsCapacity\Stock::calcInfoForEachRotationForSpecificuser(auth()->user());
              @endphp
              @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                      <li class="{{ (preg_match("*users*", URL::full()) && !str_ends_with(URL::full(),"profile")) ? 'Active':''}}"><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">المستخدمين</a></li>
                      <li class="{{ preg_match("*rooms*", URL::full()) ? 'Active':''}}"><a href="{{ route('rooms.index') }}" class="nav-link px-2 text-white">القاعات</a></li>
                      <li class="{{ preg_match("*courses*", URL::full()) ? 'Active':''}}"><a href="{{ route('courses.index') }}" class="nav-link px-2 text-white">المقررات</a></li>
                      <li class="{{ preg_match("*rotations*", URL::full()) ? 'Active':''}}"><a href="{{ route('rotations.index') }}" class="nav-link px-2 text-white">الدورات الامتحانية</a></li>
              @else
                      <li class="{{ (preg_match("*rotations*", URL::full()) && str_ends_with(URL::full(),"show")) ? 'Active':''}}"><a href="{{ route('rotations.program.show',[$latest_rotation_id]) }}" class="nav-link px-2 text-white">البرنامج الامتحاني للدوره الحالية</a></li>
                      {{-- @if($observations_number_in_latest_rotation && auth()->user()->number_of_observation && auth()->user()->is_active && !auth()->user()->temporary_role) --}}
                        <li class="{{ (preg_match("*rotations*", URL::full()) && (str_ends_with(URL::full(),"objections/create") || str_ends_with(URL::full(),"objections/edit"))) ? 'Active':''}}">
                          @php
                          $num_of_my_courses_objections=App\Models\Course::with('rotationsObjection')->whereHas('rotationsObjection', function($query) use($latest_rotation_id){
                              $query->where('user_id',Auth::user()->id)->where('rotation_id',$latest_rotation_id);})->pluck('id')->toArray();
                          @endphp
                          @if(!count($num_of_my_courses_objections))
                              <a href="{{ route('rotations.objections.create',$latest_rotation_id) }}" class="nav-link px-2 text-white">إنشاء إعتراضات</a>
                          @else
                              <a href="{{ route('rotations.objections.edit',$latest_rotation_id) }}" class="nav-link px-2 text-white">تعديل إعتراضاتي</a>
                          @endif
                        </li>
                      {{-- @endif --}}
              @endif
              
              <li class="{{ str_ends_with(URL::full(),"profile") ? 'Active':''}}"><a href="{{ route('users.profile',Auth::user()->id) }}" class="nav-link px-2 text-white"> الصفحة الشخصية</a></li>
              {{-- @if(!count(\App\Models\Rotation::find($latest_rotation_id)->initial_members()->get()))
                <li class="{{ str_ends_with(URL::full(),"initial_members") ? 'Active':''}}"><a href="{{ route('rotations.create_initial_members',$latest_rotation_id) }}" class="nav-link px-2 text-white"> createInitial</a></li>
              @else
                <li class="{{ str_ends_with(URL::full(),"initial_members") ? 'Active':''}}"><a href="{{ route('rotations.edit_initial_members',$latest_rotation_id) }}" class="nav-link px-2 text-white"> updateInitial</a></li>
              @endif --}}
              @endauth
            </ul>
          </div>
          <div class="col-lg-4 col-sm-4 col-xs-1">
            @auth 
            <div class="btns gap-2">
              @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                <a href="{{ route('courses.create') }}" class="btn btn-warning btn-sm" id="addCourse">Add New Course</a>
              @endif
              <a href="{{ route('logout.perform') }}" class="btn btn-outline-light btn-sm" id="logout">Logout</a>
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