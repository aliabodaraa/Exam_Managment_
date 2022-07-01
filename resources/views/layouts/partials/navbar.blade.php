<header class="p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        @foreach (\Spatie\Permission\Models\Role::latest()->get() as $role)
            @auth
                @if(auth()->user()->hasRole($role->name))
                    <span class="badge <?php if($role->name =='Admin') echo 'bg-success'; elseif($role->name =='Secertary') echo 'bg-warning'; elseif($role->name =='RoomHead') echo 'bg-info'; else echo 'bg-danger'?>">{{$role->name}}</span>
                @endif
            @endauth
        @endforeach
      <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li class="<?php if(URL::full()=='http://127.0.0.1:8000'){ echo'Active';}else{echo '';} ?>"><a href="{{ route('home.index') }}" class="nav-link px-2 text-white">Home</a></li>
            @auth
                @can(['users-list'])
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/users'){ echo'Active';}else{echo '';}?>"><a href="{{ route('users.index') }}" class="nav-link px-2 text-white">Users</a></li>
                @endcan
                @can(['roles-panel'])
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/roles'){ echo'Active';}else{echo '';}?>"><a href="{{ route('roles.index') }}" class="nav-link px-2 text-white">Roles</a></li>
                @endcan
                @can(['permissions-panel'])
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/permissions'){ echo'Active';}else{echo '';}?>"><a href="{{ route('permissions.index') }}" class="nav-link px-2 text-white">Permissions</a></li>
                @endcan
                @can(['posts-list'])
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/posts'){ echo'Active';}else{echo '';}?>"><a href="{{ route('posts.index') }}" class="nav-link px-2 text-white">Posts</a></li>
                @endcan
                @can(['courses-list'])
                    <li class="<?php if(URL::full()=='http://127.0.0.1:8000/courses/index'){ echo'Active';}else{echo '';}?>"><a href="{{ route('courses.index') }}" class="nav-link px-2 text-white">Exam Program</a></li>
                @endcan
                @can(['lecture-create'])
                <li class="<?php if(URL::full()=='http://127.0.0.1:8000/lectures/create'){ echo'Active';}else{echo '';}?>"><a href="{{ route('lectures.create') }}" class="nav-link px-2 text-white">Create Lecture</a></li>
                @endcan
            @endauth
      </ul>

      <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
      </form>

      @auth
        {{auth()->user()->username}}&nbsp;
        <div class="text-end">
          <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
        </div>
      @endauth

      @guest
        <div class="text-end">
          <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Login</a>
          <a href="{{ route('register.perform') }}" class="btn btn-warning">Sign-up</a>
        </div>
      @endguest
    </div>
  </div>
</header>
