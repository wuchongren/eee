<?php

namespace App\Http\Controllers\Shop;

use App\Models\Member;
use App\Models\Menus;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Shop\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopOrderController extends BaseController
{
    public static $status= [
            '-1'=>'已取消',
            '0'=>'代付款',
            '1'=>'待发货',
            '2'=>'待确认',
            '3'=>'完成',
        ];

    /**
     * 订单列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        //找出当前用户
        $user=Auth::user();
        //通过商铺ID在订单表中查找数据
        $orders=Order::where('shop_id',$user['shop_id'])->orderBy('created_at','desc')->paginate(10);
        //返回数据到示图
        return view('shop.shopOrder.index',compact('orders'));

    }

    /**
     * 查看订单
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        //通过订单ID找到订单信息
        $order=Order::findOrFail($id);
        //通过id找到订单商品信息
        $goods=OrderGood::where('order_id',$id)->get();
        //返回数据到视图
        return view('shop.shopOrder.show',compact('order','goods'));
    }

    /**
     * 订单取消
     * @param Request $request
     * @param $id
     */
    public function cancel(Request $request,$id)
    {
         //得到订单
        $order=Order::findOrFail($id);
        //找到订单用户
        $member=Member::findOrFail($order->user_id);
        //以下使用事务处理
        DB::beginTransaction();//开启事务
        try{
            //判断订单的状态，分别处理
            if ($order->status===1){
                $member->money+=$order->total;//此处需要将用户的金额返还
                if (!$member->update()){
                    //抛出异常
                    throw new \Exception('订单状态不可更改');
                }
                $order->status=-1;//更改订单状态
                if (!$order->update()){
                    //抛出异常
                    throw new \Exception('订单状态不可更改');
                };
            }elseif($order->status===0){
                //直接更改订单状态
                $order->update(['status'=>-1]);
            }else{
                //抛出异常
                throw new \Exception('订单状态不可更改');;
            }
            DB::commit();//执行事务
            //成功的提示信息
            $request->session()->flash('success','取消订单成功');
            //跳转
            return redirect()->route('shopOrder.index');
        }catch (\Exception $exception){//捕获异常
            //输出信息
             $request->session()->flash('danger',$exception->getMessage());
             //跳转
            return redirect()->route('shopOrder.index');
        }
     }

    /**
     * 发货
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function send(Request $request,$id)
    {
        //得到订单
        $order=Order::findOrFail($id);
        //shop_id
        $shop_id=Auth::user()->shop_id;
        //判断订单id与自己shop_id是否一致
        if ($shop_id!==$order->shop_id){
            $request->session()->flash('danger','订单异常');
            //跳转
            return redirect()->route('shopOrder.index');
        }
        //通过订单找到订单商品
        $goods=OrderGood::where('order_id',$id)->get();
        DB::beginTransaction();//开启事务
        try{
            //将商店的库存减记
            foreach ($goods as $good){
                $menu=Menus::find($good->goods_id);//找出对应菜品
                if ($menu->stock<$good->amount){
                    throw new \Exception($menu->goods_name.'库存不足');
                }
                //库存减记
                $menu->stock=$menu->stock - $good->amount;
                //库存
                $menu->update();
            }
            //更改订单状态
            $order->update(['status'=>2]);
            DB::commit();//执行事务
            $request->session()->flash('success','发货操作成功');//成功提示
            return redirect()->route('shopOrder.index');//重定向
        }catch (\Exception $exception){//异常捕获
            $request->session()->flash('danger',$exception->getMessage());//异常信息
            return redirect()->route('shopOrder.index');//重定向
        }





     }

    /**
     * 总量统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statistics(Request $request)
    {
      $shop_id=Auth::user()->shop_id;//得到当前用户
        //查出总量
        $orders=Order::where('shop_id',$shop_id)->where('status','>=',1)->select(DB::raw("SUM(total) AS money, count(*) AS count"))->first();

//       " SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS date, SUM(total)AS money, count(*) AS count FROM orders WHERE shop_id = 19 GROUP BY date";
     return view('shop.shopOrder.statistics',compact('orders'));
     }

    /**
     * 订单日报表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function day(Request $request)
    {
        //获取当前商户shop_id
        $shop_id=Auth::user()->shop_id;
        //构造初始查询（仅查已支付的订单）
        $query = Order::where("shop_id", $shop_id)->where('status','>=',1)->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as day,SUM(total) AS money,count(*) AS count"))->groupBy("day")->orderBy("day", 'desc')->limit(30);
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
        $orders = $query->get();
        //dd($orders);
        //显示视图
        return view('shop.shopOrder.day', compact('orders'));
     }

    /**
     * 订单月报表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function month(Request $request)
    {
        //获取当前商户shop_id
        $shop_id=Auth::user()->shop_id;
        //构造初始查询(进查询有效数据)
        $query = Order::where("shop_id", $shop_id)->where('status','>=',1)->Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month,SUM(total) AS money,count(*) AS count"))->groupBy("month")->orderBy("month", 'desc')->limit(12);
        //接收参数
        $start = $request->input('start');
        $end = $request->input('end');
        //如果有起始时间
        if ($start !== null) {
            $query->whereDate("created_at", ">=", $start);
        }
        if ($end !== null) {
            $query->whereDate("created_at", "<=", $end);
        }
        //得到每日统计数据
        $orders = $query->get();
        //dd($orders);
        //显示视图
        return view('shop.shopOrder.month', compact('orders'));

     }

    /**
     * 菜品销售历史统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menuStatistics(Request $request)
    {
        //获得当前商户shop_id
        $shop_id=Auth::user()->shop_id;
        //1.从订单表中查出所有有效数据（已支付的订单）
        $orders=Order::where('shop_id',$shop_id)->where('status','>=',1)->get(['id']);
        foreach ($orders as $order){
            $order_ids[]=$order->id;
        }
        //从订单商品表中查出所有菜品统计
        $counts =OrderGood::Select(DB::raw("goods_id,goods_name,sum(amount) AS nums "))->whereIn('order_id',$order_ids)->groupBy("goods_id")->get();
        //返回数据到视图
        return view('shop.shopOrder.menuStatistics',compact('counts'));
  }

    /**
     * 菜品按日统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menuDay(Request $request)
    {
        //获取当前商户shop_id
        $shop_id=Auth::user()->shop_id;
        //构造初始查询（仅查已支付的订单）
        $orders= Order::where("shop_id", $shop_id)->where('status','>=',1)->get(['id'])->toArray();
       foreach ($orders as $order){
           $ids[]=$order['id'];
     }

        //构造初始查询条件
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
        return view('shop.shopOrder.menuDay', compact('counts'));

  }


    public function menuMonth(Request $request)
    {
        //获得当前商户shop_id
        $shop_id=Auth::user()->shop_id;
        //1.从订单表中查出所有有效数据（已支付的订单）
        $orders=Order::where('shop_id',$shop_id)->where('status','>=',1)->get(['id'])->toArray();
        foreach ($orders as $order){
            $order_ids[]=$order['id'];
        }
        //构造初始查询条件
        $query=OrderGood::Select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month,goods_id,goods_name,SUM(amount) AS nums"))->whereIn('order_id',$order_ids)->groupBy("month","goods_id")->orderBy("month", 'desc')->limit(12);
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
        //返回到试图
        return view('shop.shopOrder.menuMonth',compact('counts'));


    }



}
