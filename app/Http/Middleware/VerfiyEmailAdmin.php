<?php

namespace App\Http\Middleware;

use Closure;
use App\Enum\TypeUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerfiyEmailAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        if($user->type_user == TypeUser::DEFAULT->value){
            return $next($request);
        }else if($user->hasVerifiedEmail()){
            return $next($request);
        }else{
            return redirect(routesFortify()['verificationNotice_get']);
        }
    }
}
