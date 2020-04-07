<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\Myexception;
class CheckAccessToken
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
        //前置中间件检测accessToken代码
        //判断用户是否传access_token
        if(!$request->has('access_token')){
            throw new MyException("To find the access token",402);  
        }
        //判断用户access_tolen是否正确
        if(!checkAccess_token($request->access_token,$request->time)){
            throw new MyException("Access token complement is norma",403);
        }
        return $next($request);
    }
}
