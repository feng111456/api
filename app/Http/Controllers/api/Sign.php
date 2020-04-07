<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\Myexception;
class Sign extends Controller
{
    /**用户注册方法 */
    public function signUp(Request $request){
        $data['username'] = $request->username;
        if(empty($data['username'])){
            throw new MyException(' username required',401); 
            //return returnErrorJson(40020,'User name required',401);
        }
        $data['pwd'] = md5($request->pwd);
        if(empty($data['pwd'])){
            throw new MyException('User password required',401);
            //return returnErrorJson(40021,'User password required',401);
        }
        $data['sex'] = $request->sex;
        $data['mobile'] = $request->mobile;
        $userInfo = User::where('username','=',$data['username'])->first();
        if($userInfo){
            throw new MyException('The user already existsT',403);
            //return returnErrorJson(4001,'The user already existsT',403);
        }
        $res = user::create($data);
        return returnSucccessJson($data);
    }
    /**用户登录方法 */
    public function signIn(Request $request){
        $username = $request->username;
        $pwd  = $request->pwd;
        $time = time();
        $token = md5($username.$pwd.$time);
        $userInfo = User::where('username','=',$username)->first()->toArray();
        if($userInfo['pwd']!=md5($pwd)){
            throw new MyException('Wrong username or password',403);
            //return returnErrorJson(40003,'Wrong username or password',403);
        }
        Redis::set($token,serialize($userInfo),2*3600);
        return returnSucccessJson($token);
    }
}
