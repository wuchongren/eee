<?php

namespace App\Http\Controllers\Api;

use App\Mail\OrderShipped;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Menus;
use App\Models\Order;
use App\Models\OrderGood;
use App\Models\Shop;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mrgoon\AliSms\AliSms;

class OrderController extends BaseController
{
    /**
     * 生成订单
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        //接收参数
        $user_id = \request()->input('user_id');
        $address_id = \request()->input('address_id');
        //通过user_id找出购物车的信息
        $carts = Cart::where('user_id', $user_id)->get();
        //找到shop_id
        $shop_id = Menus::find($carts[0]['goods_id'], ['shop_id'])->shop_id;
        //计算总金额
        $total = 0;
        foreach ($carts as $cart) {
            $goods_price = Menus::find($cart['goods_id'], ['goods_price']);            //找出单品价格
            $total = $total + $cart['amount'] * $goods_price->goods_price;
        }
        //通过address_id找出地址信息
        $address = Address::where('id', $address_id)->first();
        //使用随机数生成订单编号
        $sn = time() . rand(100000, 999999);
        //使用事务操作两张数据表
        DB::beginTransaction();    //开启事务
        try {
            //构造造订单表的数据
            $order = Order::create([
                'user_id' => $user_id,
                'shop_id' => $shop_id,
                'sn' => $sn,
                'provence' => $address->provence,
                'city' => $address->city,
                'area' => $address->area,
                'detail_address' => $address->detail_address,
                'tel' => $address->tel,
                'name' => $address->name,
                'total' => $total,
                'status' => 0,
            ]);
            //将商品循环写入订单数据表
            foreach ($carts as $ct) {
                $good = Menus::find($ct['goods_id']);
                OrderGood::create([
                    'order_id' => $order['id'],
                    'goods_id' => $good->id,
                    'amount' => $ct['amount'],
                    'goods_name' => $good->goods_name,
                    'goods_img' => $good->goods_img,
                    'goods_price' => $good->goods_price,
                ]);
            }
            DB::commit(); //成功，提交事务
            //返回状态等信息
            return [
                "status" => "true",
                "message" => "添加成功",
                "order_id" => $order['id']
            ];
        } catch (Exception $ex) {
            DB::rollback();  //失败，回滚事务
            //返回失败信息
            return [
                "status" => "flase",
                "message" => "添加失败"
            ];
        }
    }

    /**
     * 订单详情
     * @param Request $request
     * @return array
     */
    public function detail(Request $request)
    {
        //接收orderID
        $order_id = \request()->input('id');
        //找出订单
        $order = Order::find($order_id);
        //构造前端需要的时间格式
        $time = strtotime($order->created_at);
        $time = date('Y-m-d H:i', $time);
        //通过订单id找订单商品表中的信息
        $goods_list = OrderGood::where('order_id', $order_id)->get();
        //通过订单的shop_id 找出商家信息
        $shop = Shop::find($order->shop_id);
        //返回数据
        return [
            "id" => $order_id,
            "order_code" => $order->sn,
            "order_birth_time" => $time,
            "order_status" => $order->status(),
            "shop_id" => $order->shop_id,
            "shop_name" => $shop->shop_name,
            "shop_img" => $shop->shop_img,
            "goods_list" => $goods_list,
            "order_price" => (int)$order->total,
            "order_address" => $order->provence . $order->city . $order->area . $order->detail_address
        ];

    }

    /**
     * 订单列表
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function orderList(Request $request)
    {
        //接收数据
        $user_id = \request()->input('user_id');
        //找出当前用户的所有订单
        $orders = Order::where('user_id', $user_id)->get();
        //循环改写订单数据提供给给前端
        foreach ($orders as $order) {
            //通过订单id找出所有的订单商品
            $goodList = OrderGood::where('order_id', $order['id'])->get();
            //通过订单的shop_id找商铺信息
            $shop = Shop::find($order['shop_id']);
            $order['order_code'] = $order['sn'];//增加订单编号字段
            $order["order_birth_time"] = date('Y-m-d H:i', strtotime($order['created_at']));//改写时间
            $order['order_status'] = $order->status();
            $order["goods_list"] = $goodList;
            $order["shop_id"] = $shop->id;
            $order["shop_name"] = $shop->shop_name;
            $order["shop_img"] = $shop->shop_img;
            $order["order_price"] = $order['total'];
            $order["order_address"] = $order['provence'] . $order['city'] . $order['area'] . $order['order_address'];

        }
        //返回数据
        return $orders;
    }

    /**
     * 订单支付
     * @param Request $request
     * @return array
     * @throws \Throwable
     */
    public function pay(Request $request)
    {
        //获得订单ID
        $order_id = \request()->input('id');
        //找出需要支付的订单
        $order = Order::find($order_id);
        //通过订单的user_id找到当前用户的信息
        $user = Member::find($order->user_id);

        //使用事务保证交易的完整性
        DB::beginTransaction();//开启事务
        try {
            $user->money = $user->money - $order->total;//用户账户金额减记
            $user->update();//更新用户账户金额
            $order->status = 1;//将订单状态改为待发货
            $order->update();//更新订单
            DB::commit();//执行事务
            //支付成功后给用户发送短信
            //验证配置
            $config = [
                'access_key' => 'LTAIY6Jhcx5Rld0y',
                'access_secret' => 'lzRFXdAVEtUP1jLBx9JJzNyW1LMu0q',
                'sign_name' => '陈小龙',
            ];
            $product = $order->sn;//订单编号
            $aliSms = new AliSms();//实例化阿里云短信服务对象
            $aliSms->sendSms($user->tel, 'SMS_141630099', ['product' => $product], $config);//发送短信
            //给商家发送邮件
            $shop = Shop::findOrFail($order->shop_id);//找到店铺
            $shoper = User::findOrFail($shop->id);//找到店家用户
            //通过审核发送邮件
            Mail::to($shoper)->send(new OrderShipped("mail.order", $order));
            //返回成功的信息
            return [
                "status" => "true",
                "message" => "支付成功"
            ];
        } catch (Exception $exception) {//捕获异常并回滚
            DB::rollBack();//事务回滚
            return [
                'status' => 'false',
                'message' => '支付异常或账户金额不足',
            ];
        }
    }


}


