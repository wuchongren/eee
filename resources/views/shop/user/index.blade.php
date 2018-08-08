@extends('shop.layouts.default')
@section('title','用户信息')
@section('content')
    <a href="{{route('user.shopedit')}}" class="btn btn-primary">更新信息</a>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">我的商店信息</caption>
        <tr><td class="text-center">商家名称:</td><td>{{$shop->shop_name}}</td></tr>
        <tr><td class="text-center">商家图片</td> <td>
                @if($shop->shop_img)
                    <img src="{{$shop->shop_img}}" style="height: 50px" alt="">
                @endif
            </td></tr>
        <tr> <td class="text-center">商家所属分类</td><td>{{$shop->shop_categories->name}}</td></tr>
        <tr>  <td class="text-center">评分</td><td>{{$shop->shop_rating}}</td></tr>
        <tr><td class="text-center">品牌</td>  <td>{{\App\Http\Controllers\Shop\UserController::$status[$shop->brand]}}</td></tr>
        <tr> <td class="text-center">准送</td> <td> {{\App\Http\Controllers\Shop\UserController::$status[$shop->on_time]}}</td></tr>

        <tr><td class="text-center">蜂鸟</td> <td> {{\App\Http\Controllers\Shop\UserController::$status[$shop->fengniao]}}</td></tr>
        <tr><td class="text-center">保</td><td> {{\App\Http\Controllers\Shop\UserController::$status[$shop->bao]}}</td></tr>
        <tr> <td class="text-center">票</td><td> {{\App\Http\Controllers\Shop\UserController::$status[$shop->piao]}}</td></tr>
        <tr><td class="text-center">起送金额</td>  <td>{{$shop->start_send}}</td></tr>
        <tr><td class="text-center">配送费</td><td>{{$shop->send_cost}}</td></tr>
    </table>
@stop