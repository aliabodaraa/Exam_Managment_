<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();//dd($request->user()->id,Auth::user()->id,$request->route()->uri);
        if ( $user->temporary_role == "رئيس شعبة الامتحانات" || $user->temporary_role == "عميد" || ($request->route()->parameters()['user']->id == Auth::user()->id))
            return $next($request);
        return abort(404);
    }
}
