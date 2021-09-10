<?php

namespace App\Http\Middleware;

use App\Constant\RoleType;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->user_type == RoleType::ADMIN) :
            return $next($request);
        endif;

        return redirect()->route('login');


    }
}
