<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Frontend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->hasRole('customer') && Auth::user()->is_approved == 1) {
            return $next($request);
        }elseif(Auth::user()->is_approved == 0){
            return redirect()->route('user-approval');
        }
        else{
            return redirect()->route('login')->with('error','You have not user access');
        }
        // if(session()->has('language')){
        //     \App::setLocale('ar');
        // }
        // else{
        //     \App::setLocale('en');
        // }
        // return $next($request);
    }
}