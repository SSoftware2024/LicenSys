<?php

namespace App\Http\Middleware;

use Closure;
use App\Enum\TypeUser;
use App\Facades\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->type === TypeUser::DEFAULT->value){
            Toast::warning('Necessário ter acesso de administrador');
            return redirect()->back();
        }
        return $next($request);
    }
}
