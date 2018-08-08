@extends('admin.layouts.default')
@section('title','商家列表')
@section('content')
    <div>
        <a href="{{route('shop.add')}}" class="btn btn-primary">添加</a>
    </div>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">商品列表</caption>

        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">商家名称</th>
            <th class="text-center">商家图片</th>
            <th class="text-center">商家所属分类</th>
            <th class="text-center">商家排名</th>
            <th class="text-center">品牌</th>
            <th class="text-center">状态</th>
            <th >操作</th>
        </tr>
        @foreach($shops as $shop)
        <tr>
            <td>{{$shop->id}}</td>
            <td>{{$shop->shop_name}}</td>
            <td>
              @if($shop->shop_img)
                    <img src="/images/{{$shop->shop_img}}" style="height: 50px" alt="">
              @endif
            </td>
            {{--<td>{{$shop->shop_category->name}}</td>--}}
            <td>{{$shop->shop_rating}}</td>
            <td>{{$shop->brand}}</td>
            <td>
              {{\App\Http\Controllers\Admin\ShopController::$status[$shop->status]}}
            </td>

            <td class="text-left">
                <a href="{{route('shop.edit',$shop->id)}}" class="btn btn-primary">编辑</a>
                <a href="{{route('shop.check',$shop->id)}}" class="btn btn-primary">审核</a>
                <a href="{{route('shop.del',$shop->id)}}" class="btn btn-danger">删除<i class="glyphicon glyphicon-trash"></i></a>

            </td>
        </tr>
            @endforeach
    </table>
    {{$shops->links()}}
    @stop
