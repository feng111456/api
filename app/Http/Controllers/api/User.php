<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Model\TestGoods;
use App\Model\GoodsInfo;
use App\Exceptions\Myexception;
use App\Model\User as UserModel;
class User extends Controller
{
    /**显示用户信息 */
    public function list(Request $request){
        $token = $request->token;
        $unsrinfo = Redis::get($token);
        $unsrinfo = unserialize($unsrinfo);
        return returnSucccessJson($unsrinfo);
    }
    /**测试获取商品列表 */
    public function testGoods(Request $request){
        // $goodsInfo = testGoods::select('goods_name','goods_price')->get()->toarray();
         //查询数据库总条数
        $count = count(DB::table('goods')->get());
        //设置每页显示条数
        $rev = "4";
        //求总页数
        $sums = ceil($count/$rev);
        //求当前页
        $page = $request->page; //2
        if(empty($page)){
            $page = "1";
        }
        //求偏移量
        $offset = ($page-1)*$rev; //4
        $token = $request->token;
        $token = $token.$page;
        $goodsInfo = Redis::get($token);
        if(empty($goodsInfo)){
            $goodsInfo = DB::select("select goods_id,goods_name,goods_price from goods limit $offset,$rev");
            Redis::set($token,serialize($goodsInfo),2*3600);
            return returnSucccessJson($goodsInfo);
        }else{
            $goodsInfo = unserialize($goodsInfo);
        return returnSucccessJson($goodsInfo);
        }
        
    }
    /**修改用户密码 */
    public function updateUserPwd(Request $request){
        $token = $request->token;
        $unsrinfo = Redis::get($token);
        $unsrinfo = unserialize($unsrinfo);
        $name = $request->name;
        if(empty($name)){
            throw new MyException("Account number required",403); 
        }
        $pwd = $request->pwd;
        if(empty($pwd)){
            throw new MyException("Password required",403); 
        }
        if($unsrinfo['name']!=$name){
            throw new MyException("Wrong account number entered",403);
        }
        $res = UserModel::where('name','=',$name)->update(['pwd'=>md5($pwd)]);
        if($res!==false){
            return returnSucccessJson('Password changed successfully');
        }
    }
    /**商品详情 */
    function goodsInfo(Request $request){
        $goods_id = $request->goods_id;
        if(empty($goods_id)){
            throw new MyException("Item id required",403);
        }
        $goodsinfo = GoodsInfo::where('goods_id','=',$goods_id)->first();
        if(empty($goodsinfo)){
            throw new MyException("No such goods",401);
        }
        return returnSucccessJson($goodsinfo);
    }
}
