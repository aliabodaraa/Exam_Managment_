<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
    /**
     * Display register page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle account registration request
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        //dd($request->validated());
        //$user = User::create($request->validated());
        $user = User::create(//the overriding for the validation
            // [
            //     'username'=> $request->username,
            //     'email'=> $request->email,
            //     'password' => $request['password'],
            //     'password_confirmation' =>$request['password'], //you can add
            //     'department_id'=> $request['department_id'],
            //     'studing_year'=>$request->studing_year
            // ]
            $request->validated()
        );
        $user->syncRoles(2);//enter to the app as A User Role
        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }
}
