<?php

namespace App\Http\Controllers\Shop;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends BaseController
{
    public static $status = [
        '1' => '正在进行中',
        '0' => '已结束',
        '2' => '未开始',
    ];
    public function index()
    {
        //构造查询的条件
        $query=Promotion::orderBy('id')->where('status','<>','0');
        //初始化查询
        $search = request()->input('search');
        //标题的模糊搜索
        if ($search !== null) {
            $query = $query->where('title', 'like', "%{$search}%");
        }
        //查出所有数据 排除已结束的活动
        $promotions=$query->paginate(4);
        //显示视图
        return view('shop.promotion.index',compact('promotions'));
    }

    /**
     * 查看活动内容
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request,$id)
    {
        //查出数据
        $promotion=Promotion::findOrFail($id);
        //显示视图
        return view('shop.promotion.show',compact('promotion'));
    }

    //申请加入
    public function jionin(Request $request,$id)
    {
        //申请加入的规则




        return  "暂时没有任何内容";



    }




}
