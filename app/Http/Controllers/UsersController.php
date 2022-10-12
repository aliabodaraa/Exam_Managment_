<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Rotation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use illuminate\Support\Facades\Auth;
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
        list($all_rotations_table, $observations_number_in_latest_rotation)=Stock::calcInfoForEachRotationForSpecificuser($user);
        if(array_key_exists(Rotation::latest()->get()[0]->id,$all_rotations_table))
            return view('users.profile', [
                'user' => $user,
                'rotations_in_lastet_rotation_table' => $all_rotations_table[Rotation::latest()->get()[0]->id],
                'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation
            ]);
        else
            return view('users.profile', [
                'user' => $user,
                'rotations_in_lastet_rotation_table' => [],
                'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation
            ]);
    }
    public function observations(User $user)
    {
        $user_name=User::where('id',$user->id)->first()->username;

        list($all_rotations_table, $observations_number_in_latest_rotation)=Stock::calcInfoForEachRotationForSpecificuser($user);
        //dd( $observations_number_in_latest_rotation);
        return view('users.observations', [
            'user_name' => $user_name,
            'all_rotations_table' => $all_rotations_table,
            'rotations_numbers' => array_unique($user->rotations->pluck('id')->toArray()),
            'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation
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
    {   //dd(bcrypt($request['old_password'])==$user->password);
        //dd(Auth::attempt(['email'=>$user->email,'password'=>$request['old_password']]), $request['new_password'] , $request['new_password_verification']);
        if($request['old_password'] && $request['new_password'] && $request['new_password_verification']){
            if(Auth::attempt(['email'=>$user->email,'password'=>$request['old_password']])){
                if($request['new_password'] == $request['new_password_verification']){
                    $user->update(['password' => $request['new_password']]);
                }else{
                return redirect()->back()->with('password-message','incorrect verification password.');
                }
            }else{
                return redirect()->back()->with('password-message','incorrect old password.');
            }
        }
        $user->update($request->all());
        //$user->syncRoles($request->get('role'));

        return redirect()->route('users.index')->withSuccess(__('User updated successfully.'));
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
