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
                'number_of_observation' => $request['number_of_observation']
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
    public function observations(User $user)
    {
        $user_name=User::where('id',$user->id)->first()->username;
        $all_courses_rows_for_current_user=User::with('courses')->whereHas('courses',function($query) use($user) {
            $query->where('user_id',$user->id);
        })->get();

        $rotations_numbers=[];
        $dates_distinct=[];
        $times_distinct=[];

        //calc rotation for current user
            foreach($user->rotations as $rotation)
                array_push($rotations_numbers,$rotation->pivot->rotation_id);


        //calc info for each rotation for current user
        $rotations_table=[];
        foreach ($rotations_numbers as $rotation_number) {
            foreach($user->courses as $course){
                    $table=[];$i=0;
                    if($course->pivot->rotation_id == $rotation_number){
                        if( (!in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                            ( in_array($course->pivot->date,$dates_distinct) && !in_array($course->pivot->time,$times_distinct) ) ||
                            (!in_array($course->pivot->date,$dates_distinct) &&  in_array($course->pivot->time,$times_distinct) ) ){
                                    array_push($rotations_numbers,$course->pivot->rotation_id);
                                    array_push($dates_distinct,$course->pivot->date);
                                    array_push($times_distinct,$course->pivot->time);
                                    $table['observations'][$i]['date']=$course->pivot->date;
                                    $table['observations'][$i]['time']=$course->pivot->time;
                                    $table['observations'][$i]['roleIn']=$course->pivot->roleIn;
                                    $table['observations'][$i]['course_name']=$course->course_name;
                                    $table['observations'][$i]['room_name']=Room::where('id',$course->pivot->room_id)->first()->room_name;
                                    $i++;
                        }
                        $rotationInfo=Rotation::where('id',$rotation_number)->first();
                        $table['name']=$rotationInfo['name'];
                        $table['year']=$rotationInfo['year'];
                        $table['start_date']=$rotationInfo['start_date'];
                        $table['end_date']=$rotationInfo['end_date'];
                        $rotations_table[$rotation_number]=$table;
                }
            }
        }
        //dd($rotations_table);

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
    {
        $user->update($request->validated());

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
