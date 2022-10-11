<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Rotation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;
class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::first()->paginate(20);

        return view('users.index', compact('users'));
    }
    public function isActive(Request $request, User $user){
        if($user->is_active == true){
            $user->is_active = 0;
            $user->save();
            return redirect()->route('users.index')
            ->withSuccess($user->username.' not active now.');
        }else {   
            $user->is_active = 1;
            $user->save();
            return redirect()->route('users.index')
            ->withSuccess($user->username.' active now.');
        }
    }
    /**
     * Show form for creating user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', ['roles' => Role::latest()->get()]);
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {//dd($request->secure());
        //dd($request->getRequestUri());
        //dd(1123);
        $user = User::create(
            [// you also can be to write this User::create($request->validated()); but go to StoreUserRequest and make all fields required
                'username'=> $request->username,
                'email'=> $request->email,
                'password' => $request['password'],
                'role' => $request['role'],
                'number_of_observation' => $request['number_of_observation'],
                'temporary_role' => $request['temporary_role'],
                'faculty_id' =>  $request['faculty_id'],
            ]
        );
        //return Response::json($user);
        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }
    public function profile(User $user)
    {
        return view('users.profile', [
            'user' => $user
        ]);
    }
    public function observations(User $user)
    {
        $user_name=User::where('id',$user->id)->first()->username;
        $all_courses_rows_for_current_user=User::with('courses')->whereHas('courses',function($query) use($user) {
            $query->where('user_id',$user->id);
        })->get();

        $rotations_numbers=[];$rotations_table=[];
        //calc info for each rotation for current user
        foreach (array_unique($user->rotations->pluck('id')->toArray()) as $rotation_number) {
            $rotationInfo=Rotation::where('id',$rotation_number)->first();
            $table=[];
            $table['name']=$rotationInfo->name;
            $table['year']=$rotationInfo->year;
            $table['start_date']=$rotationInfo->start_date;
            $table['end_date']=$rotationInfo->end_date;
            array_push($rotations_numbers, $rotation_number);
            $common_course_name_once=[];
            foreach($user->courses()->wherePivot('rotation_id',$rotation_number)->get() as $i => $course){
                if(in_array($course->id, $common_course_name_once)) continue;
                $table['observations'][$i]['date']=$course->rotationsProgram()->where('id',$rotation_number)->get()[0]->pivot->date;
                $table['observations'][$i]['time']=$course->rotationsProgram()->where('id',$rotation_number)->get()[0]->pivot->time;
                $table['observations'][$i]['roleIn']=$course->pivot->roleIn;
                $room=Room::where('id',$course->pivot->room_id)->first();
                $table['observations'][$i]['room_name']=Room::where('id',$course->pivot->room_id)->first()->room_name;
                list($arr_common_names, $get_common_course_name_once)=Stock::getNamesSharedCoursesWithCommonRoom($rotationInfo, $course, $room);
                $table['observations'][$i]['course_name']=$arr_common_names;
                $common_course_name_once=array_merge($common_course_name_once, $get_common_course_name_once);
            }
            $rotations_table[$rotation_number]=$table;
        }
        return view('users.observations', [
            'user_name' => $user_name,
            'rotations_table' => $rotations_table,
            'rotations_numbers' => $rotations_numbers
        ]);
    }                             
    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {//dd($request);
        //$user->update($request->validated());//take only the column that set require in UpdateUserRequest.php
        $user->update($request->all());
        //$user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }
}


/*

git clone https://github.com/codeanddeploy/laravel8-authentication-example.git

if your using my previous tutorial navigate your project folder and run composer update



install packages

composer require spatie/laravel-permission
composer require laravelcollective/html

then run php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

php artisan migrate

php artisan make:migration create_posts_table

php artisan migrate

models
php artisan make:model Post

middleware
- create custom middleware
php artisan make:middleware PermissionMiddleware

register middleware
-

routes

controllers

- php artisan make:controller UsersController
- php artisan make:controller PostsController
- php artisan make:controller RolesController
- php artisan make:controller PermissionsController

requests
- php artisan make:request StoreUserRequest
- php artisan make:request UpdateUserRequest

blade files

create command to lookup all routes
- php artisan make:command CreateRoutePermissionsCommand
- php artisan permission:create-permission-routes

seeder for default roles and create admin user
php artisan make:seeder CreateAdminUserSeeder
php artisan db:seed --class=CreateAdminUserSeeder



*/
