@extends('admin.layouts.default')
@section('title','商家分类首页')
@section('content')
    <a href="{{route('shop_category.add')}}" class="btn btn-primary">添加</a>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">分类列表</caption>

        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">名称</th>
            <th class="text-center">状态</th>
            <th class="text-center">图片</th>
            <th >操作</th>
        </tr>
        @foreach($shop_categories as $shop_category)
        <tr>
            <td>{{$shop_category->id}}</td>
            <td>{{$shop_category->name}}</td>
            <td>
                {{\App\Http\Controllers\Admin\ShopCategoryController::$status[$shop_category->status]}}
            </td>
            <td><img src="/images/{{$shop_category->img}}" height="50" alt="">
                </td>
            <td class="text-left">
                <a href="{{route('shop_category.edit',$shop_category->id)}}" class="btn btn-primary">编辑</a>
                <a href="{{route('shop_category.del',$shop_category->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
            @endforeach

    </table>
   {{$shop_categories->links()}}
    @stop
