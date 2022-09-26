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
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/users'){ echo'Active';}else{echo '';}?>"><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">المستخدمين</a></li>
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/rooms/index'){ echo'Active';}else{echo '';}?>"><a href="{{ route('rooms.index') }}" class="nav-link px-2 text-white">القاعات</a></li>
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/courses/index'){ echo'Active';}else{echo '';}?>"><a href="{{ route('courses.index') }}" class="nav-link px-2 text-white">البرنامج الامتحاني للدوره الحالية</a></li>
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/rotations/index'){ echo'Active';}else{echo '';}?>"><a href="{{ route('rotations.index') }}" class="nav-link px-2 text-white">الدورات الامتحانية</a></li>
            @endauth
      </ul>

      {{-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
      </form> --}}

      @auth
        <div class="text-end">
          @if(auth()->user()->id==1)
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
