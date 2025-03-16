<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email=$request->session()->get('email','default');
        $user_id=$request->session()->get('user_id','default');
        $count=User::where('email','=',$email)->where('id','=',$user_id)->count();
        if($email=="default" || $count==0){
            return redirect('/login-page');
        }
        else{
            $request->headers->set('email',$email);
            $request->headers->set('id',$user_id);
            return $next($request);
        }

    }
}
