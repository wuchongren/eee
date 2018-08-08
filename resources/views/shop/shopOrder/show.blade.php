@extends('shop.layouts.default')
@section('title','商品添加')
@section('content')
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">订单编号</label>
            <div class="col-sm-3">{{$order->sn}}</div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">收件人</label>
            <div class="col-sm-3">{{$order->name}}</div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">送货地址</label>
            <div class="col-sm-3">{{$order->provence.$order->city.$order->area.$order->detail_address}}</div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">电话</label>
            <div class="col-sm-3">{{$order->tel}}</div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">商品详情</label>
            <div class="col-sm-3">
                <table class="table-bordered">
                    <tr>
                        <th>菜品名</th>
                        <th>数量</th>
                        <th>单价</th>
                    </tr>
                    @foreach($goods as $good)
                        <tr>
                            <td >{{$good->goods_name}}</td>
                            <td>{{$good->amount}}</td>
                            <td>{{$good->goods_price}}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>


        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">处理状态</label>
            <div class="col-sm-3">{{\App\Http\Controllers\Shop\ShopOrderController::$status[$order->status]}}</div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">订单金额</label>
            <div class="col-sm-3">{{$order->total}}</div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">订单编号</label>
            <div class="col-sm-3">{{$order->sn}}</div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="submit" class="btn btn-success" value="提交">
            </div>
        </div>
    </form>
@stop
