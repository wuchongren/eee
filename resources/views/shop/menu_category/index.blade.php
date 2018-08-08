@extends('shop.layouts.default')
@section('title','菜品分类列表')
@section('content')
    <a href="{{route('menu_category.add')}}" class="btn btn-primary">添加</a>
    <table class="table table-hover table-bordered text-center">
        <caption class="text-center">分类列表</caption>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">名称</th>
            <th class="text-center">描述</th>
            <th class="text-center">是否默认</th>
            <th >操作</th>
        </tr>
        @foreach($menu_categories as $menu_category)
        <tr>
            <td>{{$menu_category->id}}</td>
            <td>{{$menu_category->name}}</td>
            <td>{{$menu_category->description}}</td>
            <td>
                {{\App\Http\Controllers\Shop\MenuCategoryController::$status[$menu_category->is_selected]}}
            </td>
            <td class="text-left">
                <a href="{{route('menu_category.edit',$menu_category->id)}}" class="btn btn-primary">编辑</a>
                <a href="{{route('menu_category.del',$menu_category->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
            </td>
        </tr>
            @endforeach
    </table>
   {{$menu_categories->links()}}
    @stop
