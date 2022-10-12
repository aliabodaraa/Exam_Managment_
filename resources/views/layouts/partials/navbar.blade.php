<header class="p-3 bg-dark text-white" style="position: fixed;z-index: 99999999999999999999999999;top: 0;width: 100%;font-family:arial xx-small">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>
      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        @auth<span class="badge bg-success" style="position: relative;right: 30%;">{{auth()->user()->username}}</span>&nbsp;@endauth
            <li class="<?php if(URL::full()=='http://127.0.0.1:8000'){ echo'Active';}else{echo '';} ?>"><a href="{{ route('home.index') }}" class="nav-link px-2 text-white">الصفحة الرئيسية</a></li>
            @auth
            @php $latest_rotation_id=App\Models\Rotation::latest()->get()[0]->id;
                 $current_user_id = Auth::user()->id; 
                 list($all_rotations_table, $observations_number_in_latest_rotation)=App\Http\Controllers\MaxMinRoomsCapacity\Stock::calcInfoForEachRotationForSpecificuser(auth()->user());
            @endphp
            @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/users'){ echo'Active';}else{echo '';}?>"><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">المستخدمين</a></li>
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/rooms/index'){ echo'Active';}else{echo '';}?>"><a href="{{ route('rooms.index') }}" class="nav-link px-2 text-white">القاعات</a></li>
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/courses'){ echo'Active';}else{echo '';}?>"><a href="{{ route('courses.index') }}" class="nav-link px-2 text-white">المقررات</a></li>
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/rotations/index'){ echo'Active';}else{echo '';}?>"><a href="{{ route('rotations.index') }}" class="nav-link px-2 text-white">الدورات الامتحانية</a></li>
            @else
                    <li class="<?php if(URL::full()=="http://127.0.0.1:8000/rotations/$latest_rotation_id/show"){ echo'Active';}else{echo '';}?>"><a href="{{ route('rotations.program.show',[$latest_rotation_id]) }}" class="nav-link px-2 text-white">البرنامج الامتحاني للدوره الحالية</a></li>
                    <li class="<?php if(Request::fullUrlIs("http://127.0.0.1:8000/users/$current_user_id/profile")){ echo'Active';}else{echo '';}?>"><a href="{{ route('users.profile',Auth::user()->id) }}" class="nav-link px-2 text-white"> الصفحة الشخصية</a></li>
                    @if($observations_number_in_latest_rotation && auth()->user()->number_of_observation && auth()->user()->is_active && !auth()->user()->temporary_role)
                      <li class="<?php if(Request::fullUrlIs("http://127.0.0.1:8000/rotations/$latest_rotation_id/objections/create") ||Request::fullUrlIs("http://127.0.0.1:8000/rotations/$latest_rotation_id/objections/edit")){ echo'Active';}else{echo '';}?>">
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
                    @endif
            @endif
            @endauth
      </ul>

      {{-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
      </form> --}}

      @auth
        <div class="text-end">
          @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
            <a href="{{ route('courses.create') }}" class="btn btn-secondary me-2">Add New Course</a>
          @endif
          <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
        </div>
      @endguest
    </div>
  </div>
</header>
