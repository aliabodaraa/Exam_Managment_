<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform()
    {
        Session::flush();

        // //add 1 to denote there are new added lectures and user minus when login
        // $currUser = User::findOrFail(Auth::user()->id);
        // $currUser->num_new_lectures_not_shown = 0;
        // $currUser->num_new_posts_not_shown = 0;
        // $currUser->save();

        Auth::logout();

        return redirect('login');
    }
}
