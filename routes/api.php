<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//api接口
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//}
Route::namespace('Api')->group(function () {
    //首页展示
    Route::get('shop/list','ShopController@list');
    Route::get('shop/index','ShopController@index');
    //会员管理
    Route::post('member/reg','MemberController@reg');
    Route::any('member/login','MemberController@login');
    Route::any('member/sms','MemberController@sms');
    Route::any('member/changPassword','MemberController@changPassword');
    Route::post('member/forgetPassword','MemberController@forgetPassword');
    Route::get('member/show','MemberController@show');

    //用户地址管理
    Route::any('address/add','AddressController@add');
    Route::any('address/index','AddressController@index');
    Route::any('address/edit','AddressController@edit');
    Route::any('address/show','AddressController@show');

    //购物车管理
    Route::any('cart/add','CartController@add');
    Route::any('cart/index','CartController@index');

    //订单管理
    Route::any('order/add','OrderController@add');
    Route::any('order/detail','OrderController@detail');
    Route::any('order/orderList','OrderController@orderList');
    Route::any('order/pay','OrderController@pay');




});
