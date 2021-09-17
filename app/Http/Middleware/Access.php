<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Access
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
        $currentRouteName=Route::currentRouteName();
        $userRole=auth()->user()->role_id;
            if(in_array($currentRouteName,$this->userAccessRole()[$userRole])){
        return $next($request);
    }   else{
        abort(403,"You are not allowed to access this page.");
    }
}
    private function userAccessRole()
    {
        return[
            '2'=>[
                'dashboard',
                'users.index',
            ],
            '1'=>[
                'dashboard',
                'users.index',
                'roles.index',
            ],
            '3'=>[
                'dashboard'
            ],
            '4'=>[
                'dashboard'
            ],
            '5'=>[
                'dashboard'
            ],
            '6'=>[
                'dashboard'
            ],
            '7'=>[
                'dashboard'
            ],
            
            ];

    }
}
