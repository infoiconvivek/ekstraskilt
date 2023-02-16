<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if(!empty(auth('api')->user()->id)){
    
            $is_exists = User::where('id' , auth('api')->user()->id)->exists();
            if($is_exists){
                return $next($request);
            }
        }
        $response = ['message'=>'Invalid Token','success' => false];
        return response()->json($response, 401);
    }
}
