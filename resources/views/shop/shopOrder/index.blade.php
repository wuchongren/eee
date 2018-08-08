@extends('shop.layouts.default')
@section('title','订单列表')
@section('content')
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">订单列表</caption>
        <tr>
            <th class="text-center">订单编号</th>
            <th class="text-center">收货人</th>
            <th class="text-center">联系电话</th>
            <th class="text-center">送货地址</th>
            <th class="text-center">总金额</th>
            <th class="text-center">下单时间</th>
            <th class="text-center">状态</th>
            <th >操作</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{$order->sn}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->tel}}</td>
            <td>{{$order->provence.$order->city.$order->area.$order->detail_address}}</td>
            <td>{{$order->total}}</td>
            <td>{{$order->created_at}}</td>
            <td>
              {{\App\Http\Controllers\Shop\ShopOrderController::$status[$order->status]}}
            </td>

            <td class="text-left">
                <a href="{{route('shopOrder.show',$order->id)}}" class="btn btn-primary">查看</a>
                @if($order->status>-1 && $order->status<2)
                    <a href="{{route('shopOrder.cancel',$order->id)}}" class="btn btn-danger">取消订单</a>
                @endif
                 @if($order->status===1)
                    <a href="{{route('shopOrder.send',$order->id)}}" class="btn btn-success">发货</a>
                @endif
            </td>
        </tr>
            @endforeach
    </table>
    {{$orders->links()}}
    @stop
