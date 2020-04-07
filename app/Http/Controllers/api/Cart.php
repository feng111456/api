<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\Cart as CartModel;
use App\Exceptions\Myexception;
class Cart extends Controller
{
    /**购物车列表 */
    public function cartList(Request $request){
        //获取用户信息
        $token = $request->token;
        $unsrinfo = Redis::get($token);
        $unsrinfo = unserialize($unsrinfo);
        $user_id = $unsrinfo['user_id'];
        $cartList = CartModel::where('user_id','=',$user_id)->get()->toArray();
        if(empty($cartList)){
            $cartList = [];
            return returnSucccessJson($cartList);
        }
        return returnSucccessJson($cartList);
    }
    /**购物车删除数据 */
    public function cartDel(Request $request){
        //获取用户信息
        $token = $request->token;
        $unsrinfo = Redis::get($token);
        $unsrinfo = unserialize($unsrinfo);
        $user_id = $unsrinfo['user_id'];
        $goods_id = explode(',',$request->goods_id);
        if(empty($goods_id)){
            throw new MyException("Please fill in the deleted product id",401);
        }
        $res = CartModel::whereIn('goods_id',$goods_id)->delete();
        if($res!==false){
            return returnSucccessJson('Shopping cart items deleted successfully');
        }
    }
    /**购物车商品添加 */
    public function cartAdd(Request $request){
        //获取用户信息
        $token = $request->token;
        $unsrinfo = Redis::get($token);
        $unsrinfo = unserialize($unsrinfo);
        $data['goods_id'] = $request->goods_id;
        $data['add_time'] = time();
        $data['goods_name'] = $request->goods_name;
        $data['buy_num'] = $request->buy_num;
        $data['user_id']    = $unsrinfo['user_id'];
        $where = [
            'user_id'=>$data['user_id'],
            'goods_id'=>$data['goods_id']
        ];
        $cart_info = CartModel::where($where)->first();
        if($cart_info){
            $res = CartModel::where($where)->update(['buy_num'=>$cart_info['buy_num']+$data['buy_num'],'add_time'=>time()]);
            return returnSucccessJson('Shopping cart items added successfully');
        }
        $res = CartModel::create($data);
        if($res!==false){
            return returnSucccessJson('Shopping cart items added successfully');
        }
    }
    /**购物车修改 */
    public function cartUp(){
        //获取用户信息
        $token = $request->token;
        $unsrinfo = Redis::get($token);
        $unsrinfo = unserialize($unsrinfo);
        $user_id = $unsrinfo['user_id'];
        $data['goods_id'] = $request->goods_id;
        if(empty($data['goods_id'])){
            throw new MyException("Item id required",401);
        }
        $data['user_id']    = $unsrinfo['user_id'];
        $data['buy_num'] = $request->buy_num;
        if(empty($data['buy_num'])){
            $res = CartModel::where($where)->delete($goods_id);
        }
        $cart_info = CartModel::where($where)->first();
        if(empyt($cart_info)){
            throw new MyException("Your shopping cart does not have this item",401);
        }
        $res = CartModel::where($where)->update(['buy_num'=>$data['buy_num']]);
        if($res!==false){
            return returnSucccessJson('Your shopping cart modified successfully');
        }
    }
}
