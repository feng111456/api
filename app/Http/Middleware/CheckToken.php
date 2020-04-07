<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\Myexception;
class CheckToken
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
        /**检测用户是否传权限令牌 */
        $token = $request->token;
        if(empty($token)){
            throw new MyException('To get an token',401);  
            //return returnErrorJson(40010,'To get an token',401);
        }
        /**判断用户权限令牌是否正确 */
        $userinfo = Redis::get($token);
        if(empty($userinfo)){
            throw new MyException('To get an token',403);
            //return returnErrorJson(40012,'To get an token',403);   
        }
        return $next($request);
    }
}
