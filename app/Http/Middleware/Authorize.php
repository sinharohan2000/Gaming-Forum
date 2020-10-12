<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session::has('user'))
            return $next($request);
        else
        {
            $request->session()->flash('fail', 'not Authorized. please login');
            return redirect()->to('/signin');
        }
    }
}
