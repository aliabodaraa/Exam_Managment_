<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Course;
use App\Models\Rotation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;
use App\Http\Controllers\MaxFlow\Graph;
use App\Http\Controllers\MaxFlow\EnumPersonType;
class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::first()->paginate(20);
        $users = User::paginate(80);
        //$users = User::all();

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
        $property='';
        if($request->property==='1')
            $property="عضو هيئة فنية";
        elseif($request->property==='2')
            $property="عضو هيئة تدريسية";
        $custom_arr=array_merge($request->except('property'),['property'=>$property]);
        $user = User::create(
            // you also can be to write this User::create($request->validated()); but go to StoreUserRequest and make all fields required
            $custom_arr   
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
                return redirect()->back()
                ->withDanger(__('incorrect verification password.'));
                }
            }else{
                return redirect()->back()
                ->withDanger(__('incorrect old password.'));
            }
        }
        $property='';
        if($request->property==='1')
            $property="عضو هيئة فنية";
        elseif($request->property==='2')
            $property="عضو هيئة تدريسية";
        $custom_arr=array_merge($request->except('property'),['property'=>$property]);
        $user->update($custom_arr);
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

    public function create_user_courses(User $user)
    {
        $user_courses_teaches_ids=$user->teaches()->pluck('course_id');
        return view('users.create_user_courses', [
            'user' => $user,
            'user_courses_teaches_ids' => $user_courses_teaches_ids
        ]);
    }

    public function store_user_courses(Request $request,User $user)
    {   //sections_types
        //course_user_teach
        $this->validate($request,[
            'sections_types' => 'required'
        ],[
            'sections_types.unique' => 'the name of course should be unique'
        ]);
        if(count($request->sections_types)==2){
            $user->teaches()->attach($request->course_user_teach,['section_type'=> 'نظري - عملي']);
        }else{
            if(array_keys($request->sections_types)[0]==1)
                $user->teaches()->attach($request->course_user_teach,['section_type'=> 'نظري']);
            elseif(array_keys($request->sections_types)[0]==2)
                $user->teaches()->attach($request->course_user_teach,['section_type'=> 'عملي']);
        }
        //return Response::json($user);
        return redirect()->route('users.edit_user_courses',$user->id)
            ->withSuccess(__('course created successfully for user.'));
    }

    public function edit_user_courses(User $user)
    {
        $user_courses_teaches_ids=$user->teaches()->pluck('course_id');
        return view('users.edit_user_courses', [
            'user' => $user,
            'user_courses_teaches_ids' => $user_courses_teaches_ids
        ]);
    }

    public function update_user_courses(Request $request, User $user)
    {
        foreach ($request->sections_types as $course_id => $sections_types) {
        $user->teaches()->detach($course_id);
            if(count($sections_types)==2){
                $user->teaches()->attach($course_id,['section_type'=> 'نظري - عملي']);
            }else{
                if(array_keys($sections_types)[0]==1)
                    $user->teaches()->attach($course_id,['section_type'=> 'نظري']);
                elseif(array_keys($sections_types)[0]==2)
                    $user->teaches()->attach($course_id,['section_type'=> 'عملي']);
            }
        }
        return redirect()->route('users.edit_user_courses',$user->id)
        ->withSuccess(__('Course For User updated successfully.'));
    }



    public function destroy_user_courses(User $user,Course $course)
    {
        $user->teaches()->detach($course->id);
        return redirect()->route('users.edit_user_courses',$user->id)
            ->withSuccess(__('Course deleted successfully.'));
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
