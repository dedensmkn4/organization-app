<?php

namespace App\Http\Middleware;

use App\Constant\RoleType;
use Closure;
use Illuminate\Http\Request;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->user_type == RoleType::MANAGER) :
            return $next($request);
        endif;

        return redirect()->route('login');


    }
}
