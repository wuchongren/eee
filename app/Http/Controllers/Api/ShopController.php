<?php

namespace App\Http\Controllers\Api;

use App\Models\MenuCategory;
use App\Models\Menus;
use App\Models\Shop;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;

class ShopController extends BaseController
{
 //商家列表
    public function list(Request $request)
    {
        $query=Shop::orderBy('id');
        //判断搜索
        if ($request->input('keyword')){
            $keyword=\request()->input('keyword');
            //获取数据
            $query=$query->where('shop_name','like',"%$keyword%");
        }
         $shops=$query->get();
        //循环数据
        foreach ($shops as $shop){
            $shop->distance=rand(400,1200);//距离
            $shop->estimate_time=$shop->distance/100+4;//耗时
        }
        //返回数据
        return $shops;
    }

    /**
     * 展示指定商家
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function index(Request $request)
    {
        //获得的指定商家的ID
        $id=$request->input('id');

        //找出商家
        $shop=Shop::findOrFail($id);
        //写入部分前台需要的数据
        $shop->distance=rand(400,1200);//距离
        $shop->estimate_time=$shop->distance/100+4;//耗时
        //用户评价
        $shop->evaluate = [
            [
                "user_id" => 12344,
                "username" => "w******k",
                "user_img" => "http://www.homework.com/images/slider-pic4.jpeg",
                "time" => "2017-2-22",
                "evaluate_code" => 1,
                "send_time" => 30,
                "evaluate_details" => "不怎么好吃"],
            [
                "user_id" => 12344,
                "username" => "w******k",
                "user_img" => "http://www.homework.com/images/slider-pic4.jpeg",
                "time" => "2017-2-22",
                "evaluate_code" => 4.5,
                "send_time" => 30,
                "evaluate_details" => "很好吃"]
        ];
        //取出该商铺的菜品即分类
        $cates=MenuCategory::where('shop_id',$id)->get();
        if ($cates!==null){
            //取出所有的菜品
            foreach ($cates as $cate){
                $cate->goods_list=Menus::where('menu_category_id',$cate->id)->get();
            }
            //把分类数据追加
            $shop->commodity=$cates;
        }
        //返回数据
        return $shop;

    }




}
