<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    /**
     * 订单总计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statistics(Request $request)
    {
        //取出数据
       $orders=Order::where("status",'>',0)->select(DB::raw("
       COUNT(*) AS nums,SUM(total) AS totals"))->first();
      //显示视图
        return view('admin.order.statistics',compact('orders'));
    }

    /**
     * 订单按日统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function day(Request $request)
    {
        //获取所有商户
        $shops=Shop::all();
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        $shop_id=$request->input('shop_id');
       // dd($shop_id);
        //构造初始查询（仅查已支付的订单）
        $query = Order::where('status','>=',1);
        //判断是否查询商家
        if ($shop_id !== null) {
            $query->where("shop_id",  $shop_id);
        }
         $query=$query->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day,SUM(total) AS money,count(*) AS count"))->groupBy("day")->orderBy("day", 'desc')->limit(30);
        // var_dump($start,$end);
        //如果有起始时间
        if ($start !== null) {
            $query->whereDate("created_at", ">=", $start);
        }
        if ($end !== null) {
            $query->whereDate("created_at", "<=", $end);
        }
        //得到每日统计数据
        $counts = $query->get();
        //dd($orders);
        //显示视图
        return view('admin.order.day', compact('counts','shops'));



    }

    /**
     * 订单按月统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function month(Request $request)
    {
        //获取所有商户
        $shops=Shop::all();
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        $shop_id=$request->input('shop_id');
        // dd($shop_id);
        //构造初始查询（仅查已支付的订单）
        $query = Order::where('status','>=',1);
        //判断是否查询商家
        if ($shop_id !== null) {
            $query->where("shop_id",  $shop_id);
        }
        $query=$query->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month,SUM(total) AS money,count(*) AS count"))->groupBy("month")->orderBy("month", 'desc')->limit(12);
        // var_dump($start,$end);
        //如果有起始时间
        if ($start !== null) {
            $query->whereDate("created_at", ">=", $start);
        }
        if ($end !== null) {
            $query->whereDate("created_at", "<=", $end);
        }
        //得到每日统计数据
        $counts = $query->get();
        //dd($orders);
        //显示视图
        return view('admin.order.month', compact('counts','shops'));



    }

    /**
     * 菜品统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menuStatistics(Request $request)
    {
        //1.从订单表中查出所有有效数据（已支付的订单）
        $orders=Order::where('status','>=',1)->get(['id']);
        foreach ($orders as $order){
            $order_ids[]=$order->id;
        }
        //从订单商品表中查出所有菜品统计
        $counts =OrderGood::Select(DB::raw("goods_id,goods_name,sum(amount) AS nums "))->whereIn('order_id',$order_ids)->groupBy("goods_id")->get();
        //返回数据到视图
        return view('admin.order.menuStatistics',compact('counts'));
    }

    /**
     * 菜品按日统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menuDay(Request $request)
    {
        //获取所有商户
        $shops=Shop::all();
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        $shop_id=$request->input('shop_id');
        //初始订单查询（仅查已支付的订单）
        $orders= Order::where('status','>=',1);
        //判断是否查询商家
        if ($shop_id !== null) {
            $orders=$orders->where("shop_id",  $shop_id);
        }
        $orders=$orders->get(['id'])->toArray();
      //判断是否有订单产生
        if(!$orders){
           //返回没有的信息
            $request->session()->flash('danger','没有任何数据');
            //跳转
            return redirect()->route('order.menuDay');

        }
        //将shop_id压入数组
        foreach ($orders as $order){
            $ids[]=$order['id'];
        }
        //构造订单商品初始查询条件
        $query=OrderGood::Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day,goods_id,goods_name,SUM(amount) AS nums"))->whereIn('order_id',$ids)->groupBy("day","goods_id")->orderBy("day", 'desc')->limit(30);
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        // var_dump($start,$end);
        //如果有起始时间
        if ($start !== null) {
            $query->whereDate("created_at", ">=", $start);
        }
        if ($end !== null) {
            $query->whereDate("created_at", "<=", $end);
        }
        //得到每日统计数据
        $counts = $query->get();
        //显示视图
        return view('admin.order.menuDay', compact('counts','shops'));

    }

    /**
     * 菜品按月统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function menuMonth(Request $request)
    {
        //获取所有商户
        $shops=Shop::all();
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        $shop_id=$request->input('shop_id');
        //初始订单查询（仅查已支付的订单）
        $orders= Order::where('status','>=',1);
        //判断是否查询商家
        if ($shop_id !== null) {
            $orders=$orders->where("shop_id",  $shop_id);
        }
        $orders=$orders->get(['id'])->toArray();
        //判断是否有订单产生
        if(!$orders){
            //返回没有的信息
            $request->session()->flash('danger','没有任何数据');
            //跳转
            return redirect()->route('order.menuMonth');

        }
        //将shop_id压入数组
        foreach ($orders as $order){
            $ids[]=$order['id'];
        }
        //构造订单商品初始查询条件
        $query=OrderGood::Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month,goods_id,goods_name,SUM(amount) AS nums"))->whereIn('order_id',$ids)->groupBy("month","goods_id")->orderBy("month", 'desc')->limit(12);
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        // var_dump($start,$end);
        //如果有起始时间
        if ($start !== null) {
            $query->whereDate("created_at", ">=", $start);
        }
        if ($end !== null) {
            $query->whereDate("created_at", "<=", $end);
        }
        //得到每日统计数据
        $counts = $query->get();
        //显示视图
        return view('admin.order.menuMonth', compact('counts','shops'));

    }





}
