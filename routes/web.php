<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
        $sign = "123456abc";
        $time = time();
        $access_token = md5($sign.$time);
        echo $time;
        echo "\n";
        echo $access_token;die;
    return view('welcome');
});
/**user用户 */
Route::prefix('user')->middleware('checkToken')->group(function () {
    Route::get('list','api\User@list');
    Route::get('testgoods','api\User@testGoods');
    Route::put('updateuserpwd','api\User@updateUserPwd');
    Route::get('goodsinfo','api\User@GoodsInfo');
});
/**sign注册登录 */
Route::prefix('sign')->middleware('checkAccessToken','throttle:100')->group(function () {
    Route::post('signup','api\Sign@signUp');
    Route::post('signin','api\Sign@signIn');
});
/**购物车 */
Route::prefix('cart')->middleware('checkToken')->group(function () {
    Route::get('list','api\Cart@cartList');
    Route::delete('cartdel','api\Cart@cartDel');
    Route::post('cartadd','api\Cart@cartAdd');
    Route::put('Cartup','api\Cart@cartUp');
});
/**user用户 */
Route::prefix('order')->middleware('checkToken')->group(function () {
    Route::post('orderadd','api\Order@orderAdd');
});
