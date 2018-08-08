<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Menus;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class CartController extends BaseController
{
    public function index(Request $request)
    {
        //找到用户
        $user_id=\request()->input('user_id');
         //获取所有购物车商品
         $carts=Cart::where('user_id',$user_id)->get();
          //先定义已空数组
          $totalCost=0;
          $data=[];
        //循环出所有购物车商品
        foreach ($carts as $cart){
           //找出每一个商品信息
            $good=Menus::where('id',$cart['goods_id'])->first();
        $data['goods_list'][]=[
                'goods_id'=>$cart['goods_id'],
                'goods_name'=>$good['goods_name'],
                'goods_img'=>$good['goods_img'],
                'amount'=>$cart['amount'],
                'goods_price'=>$good['goods_price'],
            ];
        //商品计算总价
        $totalCost=$totalCost+$good['goods_price']*$cart['amount'];
        };
        //返回购物车数据
        return [
            'goods_list'=>$data['goods_list'],
            'totalCost'=>$totalCost
        ];

    }

    /**
     * 添加到购物车
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        //判断是否加入商品
        if (\request()->input('goodsList')===null){
            return [
                'status'=>'false',
                'message'=>'您还未添加任何商品'
            ];
        }

        //接收数据
        $user_id=\request()->input('user_id');
        $goodLists=\request()->input('goodsList');
        $goodCounts=\request()->input('goodsCount');
        //先清除购物车的其他数据
        $carts=Cart::where('user_id',$user_id)->get();
        foreach ($carts as $cart){
            $cart->delete();
        }
        //循环存入数据库
        foreach($goodLists as $k=>$v){
            Cart::create([
            'user_id'=>$user_id,
            'goods_id'=>$v,
            'amount'=>$goodCounts[$k],
            ]);
        };
        //返回提示信息
        return [
            'status'=>'true',
            'message'=>'成功添加到购物车'
        ];
    }

}
