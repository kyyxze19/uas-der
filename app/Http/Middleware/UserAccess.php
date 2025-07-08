<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
    /**
     * Handle an incoming request.
     * @param \illuminate\Htttp\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $Usertype1 = null, $Usertype2 = null, $Usertype3 = null)
    {
        if (Auth::check()){
            if (Auth::user()->role == $Usertype1 || Auth::user()->role == $Usertype2 || Auth::user()->role == $Usertype3){
                return $next($request); 
            } else {
                return redirect('/blok')->with('message','maaf lo gada hak hak akses disini');
            }
        } else {
                return redirect('/login')->with('message', 'lo belom login der');
            }
    }
}
