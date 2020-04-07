<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\MyException;
class Order extends Controller
{
    private $userInfo;
    function __construct() {
        parent::__construct();
        $token = $request->token;
        $userInfo = Redis::get($token);
        $this->userInfo = unserialize($userInfo);
    }
    /**订单添加 */
    public function orderAdd(Request $request){
        $user_id = $this->userInfo['user_id'];
        $buy_num = $request->buy_num;
        $goods_id = $request->goods_id;
        //开启事务
        DB::beginTransaction();
        try{
            $result1 = Test::create(['name'=>$name]);
            if (!$result1) {
                throw new MyException("1");
            }
            $result2 = Test::create(['name'=>$name]);
            if (!$result2) {
                throw new MyException("2");
            }
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();//事务回滚
            }
    }
}